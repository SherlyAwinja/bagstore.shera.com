<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Class Namespace
    |--------------------------------------------------------------------------
    |
    | Root namespace for Livewire component classes.
    |
    */

    'class_namespace' => 'App\\Livewire',

    /*
    |--------------------------------------------------------------------------
    | View Path
    |--------------------------------------------------------------------------
    |
    | Directory where Livewire component Blade templates are stored.
    |
    */

    'view_path' => resource_path('views/livewire'),

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Default layout used when rendering a component as a full page.
    |
    */

    'layout' => 'components.layouts.app',

    /*
    |--------------------------------------------------------------------------
    | Lazy Loading Placeholder
    |--------------------------------------------------------------------------
    |
    | Default placeholder view for lazy-loaded components.
    |
    */

    'lazy_placeholder' => null,

    /*
    |--------------------------------------------------------------------------
    | Temporary File Uploads
    |--------------------------------------------------------------------------
    |
    | Configuration for Livewire’s temporary file upload handling.
    |
    */

    'temporary_file_upload' => [
        'disk' => null,        // Default: 'default'
        'rules' => null,       // Default: ['required', 'file', 'max:12288'] (12MB)
        'directory' => null,   // Default: 'livewire-tmp'
        'middleware' => null,  // Default: 'throttle:60,1'
        'preview_mimes' => [
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma',
        ],
        'max_upload_time' => 5, // Minutes before upload invalidation
        'cleanup' => true,      // Cleanup temporary uploads older than 24 hrs
    ],

    /*
    |--------------------------------------------------------------------------
    | Render On Redirect
    |--------------------------------------------------------------------------
    |
    | Whether to re-render a component’s view before redirecting.
    |
    */

    'render_on_redirect' => false,

    /*
    |--------------------------------------------------------------------------
    | Eloquent Model Binding
    |--------------------------------------------------------------------------
    |
    | Enable legacy wire:model binding directly to Eloquent models.
    |
    */

    'legacy_model_binding' => false,

    /*
    |--------------------------------------------------------------------------
    | Auto-inject Frontend Assets
    |--------------------------------------------------------------------------
    |
    | Control whether Livewire automatically injects its JS/CSS assets.
    |
    */

    'inject_assets' => false,

    /*
    |--------------------------------------------------------------------------
    | Asset URL
    |--------------------------------------------------------------------------
    |
    | Custom base URL for Livewire’s frontend assets.
    |
    */

    'asset_url' => null,

    /*
    |--------------------------------------------------------------------------
    | Navigate (SPA mode)
    |--------------------------------------------------------------------------
    |
    | Settings for Livewire’s wire:navigate SPA-like navigation.
    |
    */

    'navigate' => [
        'show_progress_bar' => true,
        'progress_bar_color' => '#2299dd',
    ],

    /*
    |--------------------------------------------------------------------------
    | HTML Morph Markers
    |--------------------------------------------------------------------------
    |
    | Inject morph markers around Blade directives for reliable DOM diffing.
    |
    */

    'inject_morph_markers' => true,

    /*
    |--------------------------------------------------------------------------
    | Pagination Theme
    |--------------------------------------------------------------------------
    |
    | Theme used for Livewire’s pagination views.
    | Options: "tailwind" (default) or "bootstrap".
    |
    */

    'pagination_theme' => 'tailwind',
];
