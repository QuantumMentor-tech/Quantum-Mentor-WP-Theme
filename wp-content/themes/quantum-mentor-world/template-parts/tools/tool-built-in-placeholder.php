<?php
/**
 * Single Tool — Reusable Built-in Tool Placeholder System
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_slug = $post->post_name;
$tool_name = get_the_title();
?>

<!-- ============================================================
     BUILT-IN UTILITY WORKSPACE PANEL
     ============================================================ -->
<div class="built-in-tool-workspace glass-card p-6 md:p-8" id="built-in-tool-workspace" data-tool-slug="<?php echo esc_attr( $post_slug ); ?>">
    
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-6); border-bottom: 1px solid var(--border); padding-bottom: var(--space-4);">
        <div style="display: flex; align-items: center; gap: 8px;">
            <span style="font-size: 24px;">⚡</span>
            <div>
                <h3 style="margin: 0; font-size: 18px; font-weight: 700; color: var(--text-main);"><?php echo esc_html( $tool_name ); ?></h3>
                <span style="font-size: 11px; color: var(--success); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;"><?php esc_html_e( 'Local Sandbox Environment', 'quantum-mentor-world' ); ?></span>
            </div>
        </div>
        <span class="badge badge-success" style="font-size: 10px;"><?php esc_html_e( 'Built-in Tool', 'quantum-mentor-world' ); ?></span>
    </div>

    <!-- Loading overlay state (JS triggered) -->
    <div class="tool-workspace-loader" id="tool-workspace-loader" style="display: none;">
        <span class="loader-spinner"></span>
        <span class="loader-text" id="tool-loader-msg"><?php esc_html_e( 'Processing data locally...', 'quantum-mentor-world' ); ?></span>
    </div>

    <!-- Error message alert box (JS triggered) -->
    <div class="tool-workspace-error-alert" id="tool-workspace-error" style="display: none;">
        <span style="font-size: 18px;">⚠️</span>
        <div style="flex: 1;">
            <p style="margin: 0; font-weight: 700; font-size: 13px; color: var(--danger);"><?php esc_html_e( 'Execution Error', 'quantum-mentor-world' ); ?></p>
            <p style="margin: 0; font-size: 12px; color: var(--text-muted);" id="tool-error-msg"></p>
        </div>
        <button type="button" class="tool-error-close-btn" id="tool-error-close" style="background: transparent; border: 0; color: var(--text-muted); cursor: pointer; font-size: 16px;">&times;</button>
    </div>

    <!-- ==========================================
         SPECIFIC UTILITY WORKSPACES
         ========================================== -->

    <!-- Case 1: Word Counter -->
    <?php if ( strpos( $post_slug, 'word-counter' ) !== false ) : ?>
        <div class="tool-workspace-content" id="tool-content-word-counter">
            <div style="margin-bottom: var(--space-4);">
                <label for="word-counter-input" style="font-size: 13px; font-weight: 700; color: var(--text-muted); display: block; margin-bottom: var(--space-2);"><?php esc_html_e( 'Enter your text:', 'quantum-mentor-world' ); ?></label>
                <textarea id="word-counter-input" class="tools-search-input" style="height: 180px; width: 100%; border-radius: var(--radius-sm); padding: var(--space-3) var(--space-4); font-family: inherit; font-size: 14px; line-height: 1.6; resize: vertical;" placeholder="<?php esc_attr_e( 'Paste or type your document content here to see instant statistics...', 'quantum-mentor-world' ); ?>"></textarea>
            </div>

            <!-- Stats bar -->
            <div class="grid grid-cols-12 gap-4" style="margin-bottom: var(--space-6);">
                <div class="col-span-6 md:col-span-3 glass-card" style="padding: var(--space-3); text-align: center; border-color: rgba(255,255,255,0.04); background: rgba(255,255,255,0.01);">
                    <span style="font-size: 20px; font-weight: 800; color: var(--primary); display: block;" id="stat-words">0</span>
                    <span style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 600;"><?php esc_html_e( 'Words', 'quantum-mentor-world' ); ?></span>
                </div>
                <div class="col-span-6 md:col-span-3 glass-card" style="padding: var(--space-3); text-align: center; border-color: rgba(255,255,255,0.04); background: rgba(255,255,255,0.01);">
                    <span style="font-size: 20px; font-weight: 800; color: var(--primary); display: block;" id="stat-chars">0</span>
                    <span style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 600;"><?php esc_html_e( 'Characters', 'quantum-mentor-world' ); ?></span>
                </div>
                <div class="col-span-6 md:col-span-3 glass-card" style="padding: var(--space-3); text-align: center; border-color: rgba(255,255,255,0.04); background: rgba(255,255,255,0.01);">
                    <span style="font-size: 20px; font-weight: 800; color: var(--primary); display: block;" id="stat-paragraphs">0</span>
                    <span style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 600;"><?php esc_html_e( 'Paragraphs', 'quantum-mentor-world' ); ?></span>
                </div>
                <div class="col-span-6 md:col-span-3 glass-card" style="padding: var(--space-3); text-align: center; border-color: rgba(255,255,255,0.04); background: rgba(255,255,255,0.01);">
                    <span style="font-size: 20px; font-weight: 800; color: var(--primary); display: block;" id="stat-reading-time">0m</span>
                    <span style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 600;"><?php esc_html_e( 'Reading Time', 'quantum-mentor-world' ); ?></span>
                </div>
            </div>

            <!-- Actions -->
            <div style="display: flex; gap: var(--space-3); flex-wrap: wrap;">
                <button type="button" class="btn btn-secondary" id="word-counter-reset" style="border-color: rgba(255,255,255,0.08);"><?php esc_html_e( 'Reset Text', 'quantum-mentor-world' ); ?></button>
            </div>
        </div>

    <!-- Case 2: Text Case Converter -->
    <?php elseif ( strpos( $post_slug, 'case-converter' ) !== false ) : ?>
        <div class="tool-workspace-content" id="tool-content-case-converter">
            <div style="margin-bottom: var(--space-4);">
                <label for="case-input" style="font-size: 13px; font-weight: 700; color: var(--text-muted); display: block; margin-bottom: var(--space-2);"><?php esc_html_e( 'Input Text:', 'quantum-mentor-world' ); ?></label>
                <textarea id="case-input" class="tools-search-input" style="height: 140px; width: 100%; border-radius: var(--radius-sm); padding: var(--space-3) var(--space-4); font-family: inherit; font-size: 14px; line-height: 1.6; resize: vertical;" placeholder="<?php esc_attr_e( 'Enter your text to convert case...', 'quantum-mentor-world' ); ?>"></textarea>
            </div>

            <!-- Actions Row -->
            <div style="display: flex; gap: var(--space-2); flex-wrap: wrap; margin-bottom: var(--space-4);">
                <button type="button" class="btn btn-secondary" id="case-btn-upper" style="padding: 6px 14px; font-size: 12px; border-color: var(--primary); color: var(--primary); min-height: auto;"><?php esc_html_e( 'UPPERCASE', 'quantum-mentor-world' ); ?></button>
                <button type="button" class="btn btn-secondary" id="case-btn-lower" style="padding: 6px 14px; font-size: 12px; border-color: var(--primary); color: var(--primary); min-height: auto;"><?php esc_html_e( 'lowercase', 'quantum-mentor-world' ); ?></button>
                <button type="button" class="btn btn-secondary" id="case-btn-title" style="padding: 6px 14px; font-size: 12px; border-color: var(--primary); color: var(--primary); min-height: auto;"><?php esc_html_e( 'Title Case', 'quantum-mentor-world' ); ?></button>
                <button type="button" class="btn btn-secondary" id="case-btn-reset" style="padding: 6px 14px; font-size: 12px; border-color: rgba(255,255,255,0.08); min-height: auto;"><?php esc_html_e( 'Reset', 'quantum-mentor-world' ); ?></button>
            </div>

            <div style="margin-bottom: var(--space-4);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-2);">
                    <label for="case-output" style="font-size: 13px; font-weight: 700; color: var(--text-muted); margin: 0;"><?php esc_html_e( 'Result:', 'quantum-mentor-world' ); ?></label>
                    <button type="button" class="btn btn-secondary" id="case-btn-copy" style="padding: 4px 10px; font-size: 11px; min-height: auto; border-color: rgba(255,255,255,0.08);"><?php esc_html_e( 'Copy Result', 'quantum-mentor-world' ); ?></button>
                </div>
                <textarea id="case-output" class="tools-search-input" readonly style="height: 140px; width: 100%; border-radius: var(--radius-sm); padding: var(--space-3) var(--space-4); font-family: inherit; font-size: 14px; line-height: 1.6; resize: vertical; background: rgba(0, 0, 0, 0.2); cursor: default;" placeholder="<?php esc_attr_e( 'Result will be shown here...', 'quantum-mentor-world' ); ?>"></textarea>
            </div>
        </div>

    <!-- Case 3: JSON Formatter -->
    <?php elseif ( strpos( $post_slug, 'json-formatter' ) !== false ) : ?>
        <div class="tool-workspace-content" id="tool-content-json-formatter">
            <div style="margin-bottom: var(--space-4);">
                <label for="json-input" style="font-size: 13px; font-weight: 700; color: var(--text-muted); display: block; margin-bottom: var(--space-2);"><?php esc_html_e( 'Raw JSON String:', 'quantum-mentor-world' ); ?></label>
                <textarea id="json-input" class="tools-search-input" style="height: 140px; width: 100%; border-radius: var(--radius-sm); padding: var(--space-3) var(--space-4); font-family: monospace; font-size: 13px; line-height: 1.5; resize: vertical;" placeholder='e.g., {"name":"John", "age":30, "city":"New York"}'></textarea>
            </div>

            <!-- Actions Row -->
            <div style="display: flex; gap: var(--space-2); flex-wrap: wrap; margin-bottom: var(--space-4);">
                <button type="button" class="btn btn-secondary" id="json-btn-format" style="padding: 6px 14px; font-size: 12px; border-color: var(--primary); color: var(--primary); min-height: auto;"><?php esc_html_e( 'Format & Validate', 'quantum-mentor-world' ); ?></button>
                <button type="button" class="btn btn-secondary" id="json-btn-minify" style="padding: 6px 14px; font-size: 12px; border-color: var(--primary); color: var(--primary); min-height: auto;"><?php esc_html_e( 'Minify JSON', 'quantum-mentor-world' ); ?></button>
                <button type="button" class="btn btn-secondary" id="json-btn-reset" style="padding: 6px 14px; font-size: 12px; border-color: rgba(255,255,255,0.08); min-height: auto;"><?php esc_html_e( 'Reset', 'quantum-mentor-world' ); ?></button>
            </div>

            <div style="margin-bottom: var(--space-4);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-2);">
                    <label for="json-output" style="font-size: 13px; font-weight: 700; color: var(--text-muted); margin: 0;"><?php esc_html_e( 'Formatted Output:', 'quantum-mentor-world' ); ?></label>
                    <button type="button" class="btn btn-secondary" id="json-btn-copy" style="padding: 4px 10px; font-size: 11px; min-height: auto; border-color: rgba(255,255,255,0.08);"><?php esc_html_e( 'Copy Result', 'quantum-mentor-world' ); ?></button>
                </div>
                <textarea id="json-output" class="tools-search-input" readonly style="height: 180px; width: 100%; border-radius: var(--radius-sm); padding: var(--space-3) var(--space-4); font-family: monospace; font-size: 13px; line-height: 1.5; resize: vertical; background: rgba(0, 0, 0, 0.2); cursor: default;" placeholder="<?php esc_attr_e( 'Formatted JSON output will display here...', 'quantum-mentor-world' ); ?>"></textarea>
            </div>
        </div>

    <!-- Case 4: Image Compressor / Converter Placeholder -->
    <?php elseif ( strpos( $post_slug, 'compressor' ) !== false || strpos( $post_slug, 'image' ) !== false ) : ?>
        <div class="tool-workspace-content" id="tool-content-image-tool">
            <div style="border: 2px dashed rgba(0, 212, 255, 0.2); border-radius: var(--radius-md); padding: var(--space-8); text-align: center; background: rgba(255,255,255,0.01); margin-bottom: var(--space-6); transition: border-color 0.2s;" id="image-drag-area">
                <span style="font-size: 48px; display: block; margin-bottom: var(--space-3);">🖼️</span>
                <p style="font-size: 14px; font-weight: 700; color: var(--text-main); margin-bottom: var(--space-1);"><?php esc_html_e( 'Select or Drag Image Here', 'quantum-mentor-world' ); ?></p>
                <p style="font-size: 11px; color: var(--text-muted); margin-bottom: var(--space-4);"><?php esc_html_e( 'Supports WebP, PNG, JPEG. Max size 5 MB.', 'quantum-mentor-world' ); ?></p>
                
                <input type="file" id="image-file-input" style="display: none;" accept="image/*">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('image-file-input').click()"><?php esc_html_e( 'Browse Local Image', 'quantum-mentor-world' ); ?></button>
            </div>

            <!-- Image processing options mock -->
            <div class="glass-card" style="padding: var(--space-4); border-color: rgba(255,255,255,0.04); background: rgba(255,255,255,0.01); margin-bottom: var(--space-6); display: none;" id="image-tool-options">
                <div style="margin-bottom: var(--space-4);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--space-2);">
                        <label for="image-quality-range" style="font-size: 12px; font-weight: 600; color: var(--text-muted);"><?php esc_html_e( 'Compression Quality:', 'quantum-mentor-world' ); ?></label>
                        <span style="font-size: 12px; font-weight: 700; color: var(--primary);" id="image-quality-val">80%</span>
                    </div>
                    <input type="range" id="image-quality-range" min="10" max="100" value="80" style="width: 100%; accent-color: var(--primary);">
                </div>
                
                <div style="display: flex; gap: var(--space-4); flex-wrap: wrap;">
                    <button type="button" class="btn btn-primary" id="image-btn-compress" style="padding: 8px 16px; font-size: 13px; min-height: auto;"><?php esc_html_e( 'Process Image', 'quantum-mentor-world' ); ?></button>
                    <button type="button" class="btn btn-secondary" id="image-btn-reset" style="padding: 8px 16px; font-size: 13px; min-height: auto; border-color: rgba(255,255,255,0.08);"><?php esc_html_e( 'Clear', 'quantum-mentor-world' ); ?></button>
                </div>
            </div>

            <!-- Output slot -->
            <div id="image-tool-output" style="display: none; border-top: 1px solid var(--border); padding-top: var(--space-6);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-4);">
                    <span style="font-size: 13px; font-weight: 700; color: var(--success);">🎉 <?php esc_html_e( 'Image Compressed successfully!', 'quantum-mentor-world' ); ?></span>
                    <button type="button" class="btn btn-secondary" id="image-btn-download" style="padding: 4px 10px; font-size: 11px; min-height: auto; border-color: var(--success); color: var(--success);"><?php esc_html_e( 'Download Result', 'quantum-mentor-world' ); ?></button>
                </div>
                <div style="display: flex; gap: var(--space-4); align-items: center; flex-wrap: wrap;" class="glass-card p-3">
                    <div id="image-preview-placeholder" style="width: 80px; height: 80px; border-radius: 4px; overflow: hidden; background: #000; display: flex; align-items: center; justify-content: center;">
                        <img id="image-output-preview" style="max-width:100%; max-height:100%; object-fit:contain;" alt="<?php esc_attr_e( 'Output Preview', 'quantum-mentor-world' ); ?>">
                    </div>
                    <div>
                        <p style="margin:0; font-size:12px; font-weight:700;" id="image-output-name"></p>
                        <p style="margin:0; font-size:11px; color:var(--text-muted);"><span id="image-orig-size"></span> &rarr; <span id="image-comp-size" style="color: var(--success); font-weight:700;"></span></p>
                    </div>
                </div>
            </div>
        </div>

    <!-- Case 5: Default Fallback Tool Placeholder -->
    <?php else : ?>
        <div class="tool-workspace-content" id="tool-content-generic">
            <div style="text-align: center; padding: var(--space-8); border: 1px dashed var(--border); border-radius: var(--radius-md); background: rgba(255,255,255,0.01);">
                <span style="font-size: 48px; display: block; margin-bottom: var(--space-4);">🛠️</span>
                <h4 style="margin: 0 0 var(--space-2); font-size: 16px; color: var(--text-main); font-weight: 700;"><?php esc_html_e( 'Built-in Tool Workspace Initialized', 'quantum-mentor-world' ); ?></h4>
                <p style="font-size: 13px; color: var(--text-muted); max-width: 480px; margin: 0 auto var(--space-6); line-height: 1.5;">
                    <?php printf( esc_html__( 'We are preparing the local sandbox interface for "%s". Input, logic processors, and output controls will activate in a future release.', 'quantum-mentor-world' ), esc_html( $tool_name ) ); ?>
                </p>
                <div style="display: flex; justify-content: center; gap: var(--space-3);">
                    <button type="button" class="btn btn-primary" id="generic-tool-run-mock" style="padding: 8px 16px; font-size: 13px; min-height: auto;"><?php esc_html_e( 'Run Simulated Execution', 'quantum-mentor-world' ); ?></button>
                </div>
            </div>
            
            <div id="generic-tool-output" style="display: none; border-top: 1px solid var(--border); padding-top: var(--space-6); margin-top: var(--space-6);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-2);">
                    <label for="generic-output-field" style="font-size: 13px; font-weight: 700; color: var(--text-muted); margin: 0;"><?php esc_html_e( 'Formatted Output:', 'quantum-mentor-world' ); ?></label>
                    <button type="button" class="btn btn-secondary" id="generic-btn-copy" style="padding: 4px 10px; font-size: 11px; min-height: auto; border-color: rgba(255,255,255,0.08);"><?php esc_html_e( 'Copy', 'quantum-mentor-world' ); ?></button>
                </div>
                <textarea id="generic-output-field" class="tools-search-input" readonly style="height: 100px; width: 100%; border-radius: var(--radius-sm); padding: var(--space-3) var(--space-4); font-family: monospace; font-size: 13px; background: rgba(0, 0, 0, 0.2);" placeholder="<?php esc_attr_e( 'Simulated results...', 'quantum-mentor-world' ); ?>"></textarea>
            </div>
        </div>
    <?php endif; ?>

</div>
