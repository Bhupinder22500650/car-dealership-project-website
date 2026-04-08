<?php
/**
 * COSS Stitch Design System - Shared Head Include
 * Provides Tailwind CSS with custom COSS design tokens, Inter font, Material Symbols
 */
?>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                "colors": {
                    "error": "#ba1a1a",
                    "on-primary-fixed-variant": "#004494",
                    "on-primary-fixed": "#001a41",
                    "surface-dim": "#dbdad9",
                    "on-error": "#ffffff",
                    "surface": "#faf9f9",
                    "background": "#faf9f9",
                    "secondary-container": "#e4e2e1",
                    "inverse-primary": "#adc6ff",
                    "surface-variant": "#e3e2e2",
                    "on-surface": "#1b1c1c",
                    "inverse-on-surface": "#f2f0f0",
                    "outline-variant": "#c2c6d5",
                    "error-container": "#ffdad6",
                    "on-tertiary-container": "#eaeeff",
                    "primary-container": "#1c69d4",
                    "on-primary-container": "#ebefff",
                    "on-secondary-fixed": "#1b1c1c",
                    "secondary-fixed": "#e4e2e1",
                    "on-primary": "#ffffff",
                    "on-secondary": "#ffffff",
                    "tertiary": "#0051ad",
                    "surface-container-high": "#e9e8e8",
                    "outline": "#727784",
                    "tertiary-fixed": "#d8e2ff",
                    "secondary-fixed-dim": "#c8c6c5",
                    "surface-container-lowest": "#ffffff",
                    "on-surface-variant": "#424753",
                    "on-error-container": "#93000a",
                    "on-background": "#1b1c1c",
                    "primary-fixed": "#d8e2ff",
                    "on-secondary-fixed-variant": "#474746",
                    "tertiary-fixed-dim": "#adc6ff",
                    "on-tertiary-fixed-variant": "#004494",
                    "on-tertiary-fixed": "#001a41",
                    "secondary": "#5f5e5e",
                    "primary-fixed-dim": "#adc6ff",
                    "surface-container-highest": "#e3e2e2",
                    "surface-container": "#efeded",
                    "surface-bright": "#faf9f9",
                    "surface-tint": "#005bc1",
                    "on-tertiary": "#ffffff",
                    "primary": "#0051ae",
                    "surface-container-low": "#f4f3f3",
                    "inverse-surface": "#2f3031",
                    "on-secondary-container": "#656464",
                    "tertiary-container": "#0368db"
                },
                "borderRadius": {
                    "DEFAULT": "0px",
                    "lg": "0px",
                    "xl": "0px",
                    "full": "9999px"
                },
                "fontFamily": {
                    "headline": ["Inter"],
                    "body": ["Inter"],
                    "label": ["Inter"]
                }
            }
        }
    }
</script>
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
    }
    body { font-family: 'Inter', sans-serif; }
    ::-webkit-scrollbar { height: 4px; width: 4px; }
    ::-webkit-scrollbar-track { background: #efeded; }
    ::-webkit-scrollbar-thumb { background: #0051ae; }
    .luxury-input {
        border-top: none; border-left: none; border-right: none;
        border-bottom: 1px solid #c2c6d5;
        background: transparent; border-radius: 0;
        padding-left: 0; padding-right: 0;
    }
    .luxury-input:focus {
        outline: none; border-bottom-color: #0051ae; border-bottom-width: 2px;
    }
    /* Alert messages */
    .coss-alert-error {
        background: #ffdad6; color: #93000a;
        border-left: 3px solid #ba1a1a;
        padding: 1rem 1.5rem; font-size: 0.75rem;
        letter-spacing: 0.05em; text-transform: uppercase; font-weight: 500;
    }
    .coss-alert-success {
        background: #d8e2ff; color: #001a41;
        border-left: 3px solid #0051ae;
        padding: 1rem 1.5rem; font-size: 0.75rem;
        letter-spacing: 0.05em; text-transform: uppercase; font-weight: 500;
    }
</style>
