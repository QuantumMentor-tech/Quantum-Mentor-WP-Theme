# Backup & Recovery Documentation — Quantum Mentor World

This guide details the backup strategy, scheduling, and restore procedures for the Quantum Mentor World website.

---

## 1. Backup Strategy & Scheduling

To ensure business continuity and protect the codebase and user database, we enforce a multi-tiered backup rotation schedule.

### Retention Schedule

| Backup Type | Frequency | Storage Location | Retention Period | Content Included |
| :--- | :--- | :--- | :--- | :--- |
| **Database** | Daily | Remote Storage (S3/Drive) | 30 Days | WordPress MySQL Database (`wp_*` tables) |
| **Files (Theme & Plugins)** | Weekly | Remote Storage (S3/Drive) | 3 Months | `wp-content/themes/`, `wp-content/plugins/` |
| **Media Uploads** | Monthly | Remote Storage (S3/Drive) | 6 Months | `wp-content/uploads/` |
| **Full Site Archive** | Monthly | Cold Storage (Local/Offsite) | 1 Year | Full filesystem root + database |

### Recommended Plugins
For automated backups, configure one of the following premium-grade WordPress plugins:
1. **UpdraftPlus** (Recommended): Set up remote cloud backups (Google Drive, Dropbox, or AWS S3).
2. **BlogVault**: Best for high-frequency incremental real-time backups.
3. **Duplicator Pro**: Best for complete site mirroring and migration archives.

---

## 2. CLI-Based Manual Backup Commands

If server command-line access (SSH) is available, use these commands to generate clean backups manually.

### A. Manual Database Backup
```bash
# Export the database utilizing WP-CLI (recommended)
wp db export wp-database-backup-$(date +%F).sql --allow-root

# Or backup directly via mysqldump
mysqldump -u [db_user] -p[db_password] [db_name] > mysql-database-backup-$(date +%F).sql
```

### B. Manual Files Backup
```bash
# Compress the custom theme and plugins
tar -czf site-files-backup-$(date +%F).tar.gz wp-content/themes/quantum-mentor-world/ wp-content/plugins/
```

---

## 3. Restore & Disaster Recovery Procedures

Follow these step-by-step instructions to restore the site in the event of database corruption or file loss.

### Phase 1: File Restoration
1. Access the server via SSH or SFTP.
2. Locate the backup archive (`site-files-backup-[date].tar.gz`).
3. Extract the files over the existing directory:
   ```bash
   tar -xzf site-files-backup-[date].tar.gz -C /path/to/wordpress/root/
   ```
4. Reset file permissions:
   ```bash
   find . -type d -exec chmod 755 {} \;
   find . -type f -exec chmod 644 {} \;
   ```

### Phase 2: Database Restoration
1. Access the server via SSH.
2. Drop existing tables and import the clean SQL backup file:
   ```bash
   # Restore via WP-CLI (cleaner, runs tables drop automatically)
   wp db import wp-database-backup-[date].sql --allow-root
   
   # Or restore manually via mysql client
   mysql -u [db_user] -p[db_password] [db_name] < wp-database-backup-[date].sql
   ```
3. Clear transients and caches:
   ```bash
   wp transient delete --all --allow-root
   wp cache flush --allow-root
   ```

### Phase 3: Post-Restore Verification
- Verify that the homepage resolves cleanly.
- Try signing in as administrator and check security audit logs.
- Regenerate the XML and HTML Sitemap to ensure index coherence.
