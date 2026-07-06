/**
 * Quantum Mentor World — Admin Scripts
 *
 * Handles backend dashboard animations, confirmations, and widgets behaviors.
 *
 * @package Quantum_Mentor_World
 * @version 1.0.0
 */

jQuery(document).ready(function($) {
    console.log('Quantum Mentor Admin Framework Initialized.');

    // Simple interaction to highlight pending tabs on load
    if ($('.highlight-pending').length) {
        $('.highlight-pending').css({
            'animation': 'qmwPulseYellow 2s infinite alternate'
        });
    }

    // Dynamic style declaration for pulsing effects
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            @keyframes qmwPulseYellow {
                0% { box-shadow: 0 0 4px rgba(245, 158, 11, 0.2); }
                100% { box-shadow: 0 0 12px rgba(245, 158, 11, 0.6); }
            }
        `)
        .appendTo('head');
});
