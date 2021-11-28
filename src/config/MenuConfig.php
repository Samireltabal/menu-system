<?php 
    return [
        'version' => 'v0.0.1-Alpha',
        'prefix'  => 'api/menus',
        'middleware' => ['api'],
        'admin_role' => env('ADMIN_ROLE', 'admin'),
        'admin_middleware' => ['api', 'auth:api', "role:" . env('ADMIN_ROLE', 'admin')],
        'icon_groups' => [
            ['text' => 'Material Design Icons', 'value' => 'mdi'],
            ['text' => 'Font Awesome Icons', 'value' => 'fa']
        ],
        'available_types' => [
            'link',
            'page',
            'external'
        ],
        'available_components' => [
            'FooterNavigation',
            'SideNavigation',
            'TopLevelNavigation',
            'All'
        ],
        'icons_available' => ['cog', 'account', 'google', 'information', 'login', 'logout', 'home'],
        'visibility_levels' => ['all','guest_only','registered','admin_only' ]
    ];
