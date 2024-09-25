<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    'tom-select' => [
        'version' => '2.3.1',
    ],
    'bootstrap' => [
        'version' => '5.3.3',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'bootstrap/dist/css/bootstrap.min.css' => [
        'version' => '5.3.3',
        'type' => 'css',
    ],
    'flatpickr' => [
        'version' => '4.6.13',
    ],
    'flatpickr/dist/flatpickr.min.css' => [
        'version' => '4.6.13',
        'type' => 'css',
    ],
    'flatpickr/dist/l10n/fr' => [
        'version' => '4.6.13',
    ],
    'prismjs' => [
        'version' => '1.29.0',
    ],
    'prismjs/themes/prism.min.css' => [
        'version' => '1.29.0',
        'type' => 'css',
    ],
    'prismjs/components' => [
        'version' => '1.29.0',
    ],
    '@toast-ui/editor' => [
        'version' => '3.2.2',
    ],
    'prosemirror-model' => [
        'version' => '1.19.4',
    ],
    'prosemirror-view' => [
        'version' => '1.33.1',
    ],
    'prosemirror-transform' => [
        'version' => '1.8.0',
    ],
    'prosemirror-state' => [
        'version' => '1.4.3',
    ],
    'prosemirror-keymap' => [
        'version' => '1.2.2',
    ],
    'prosemirror-commands' => [
        'version' => '1.5.2',
    ],
    'prosemirror-inputrules' => [
        'version' => '1.4.0',
    ],
    'prosemirror-history' => [
        'version' => '1.3.2',
    ],
    'orderedmap' => [
        'version' => '2.1.1',
    ],
    'w3c-keyname' => [
        'version' => '2.2.8',
    ],
    'rope-sequence' => [
        'version' => '1.3.4',
    ],
    'prosemirror-view/style/prosemirror.min.css' => [
        'version' => '1.33.1',
        'type' => 'css',
    ],
    '@toast-ui/editor-plugin-code-syntax-highlight' => [
        'version' => '3.1.0',
    ],
    '@toast-ui/editor-plugin-code-syntax-highlight/dist/toastui-editor-plugin-code-syntax-highlight.css' => [
        'version' => '3.1.0',
        'type' => 'css',
    ],
    'prismjs/components/prism-php' => [
        'version' => '1.29.0',
    ],
    'prismjs/components/prism-js-extras' => [
        'version' => '1.29.0',
    ],
    'prismjs/components/prism-cshtml' => [
        'version' => '1.29.0',
    ],
    'prismjs/components/prism-markup-templating' => [
        'version' => '1.29.0',
    ],
    '@toast-ui/editor/dist/toastui-editor.css' => [
        'version' => '3.2.2',
        'type' => 'css',
    ],
    '@toast-ui/editor/dist/theme/toastui-editor-dark.css' => [
        'version' => '3.2.2',
        'type' => 'css',
    ],
    '@toast-ui/editor/dist/i18n/fr-fr' => [
        'version' => '3.2.2',
    ],
    '@toast-ui/editor/dist/toastui-editor-viewer' => [
        'version' => '3.2.2',
    ],
    '@toast-ui/editor/dist/toastui-editor-viewer.css' => [
        'version' => '3.2.2',
        'type' => 'css',
    ],
    '@tabler/core' => [
        'version' => '1.0.0-beta20',
    ],
    '@tabler/core/dist/css/tabler.min.css' => [
        'version' => '1.0.0-beta20',
        'type' => 'css',
    ],
    '@symfony/ux-map/abstract-map-controller' => [
        'path' => './vendor/symfony/ux-map/assets/dist/abstract_map_controller.js',
    ],
    'leaflet' => [
        'version' => '1.9.4',
    ],
    'leaflet/dist/leaflet.min.css' => [
        'version' => '1.9.4',
        'type' => 'css',
    ],
    '@symfony/ux-leaflet-map/map-controller' => [
        'path' => './vendor/symfony/ux-leaflet-map/assets/dist/map_controller.js',
    ],
    'tom-select/dist/css/tom-select.bootstrap5.min.css' => [
        'version' => '2.3.1',
        'type' => 'css',
    ],
    'tom-select/dist/css/tom-select.min.css' => [
        'version' => '2.3.1',
        'type' => 'css',
    ],
    'emoji-picker-element' => [
        'version' => '1.22.4',
    ],
    '@symfony/ux-leaflet-map' => [
        'path' => './vendor/symfony/ux-leaflet-map/assets/dist/map_controller.js',
    ],
];
