<?php 
    use SamirEltabal\MenuSystem\Controllers\MenuController;

    Route::get('/', function() {
        return MenuSystem::ping();
    });

    Route::post('create', [MenuController::class, 'create_menu']);
    Route::post('create/item', [MenuController::class, 'create_menu_item']);
    Route::get('show/{slug}', [MenuController::class, 'get_menu']);
    Route::get('enable/{slug}', [MenuController::class, 'enable_menu']);
    Route::get('disable/{slug}', [MenuController::class, 'disable_menu']);
    Route::get('delete/{slug}', [MenuController::class, 'delete_menu']);
    Route::get('delete/item/{id}', [MenuController::class, 'delete_menu_item']);
    Route::post('item/order', [MenuController::class, 'update_order']);
    Route::post('item/parent', [MenuController::class, 'update_parent']);
    Route::post('item/level', [MenuController::class, 'update_visibility']);
    Route::get('list', [MenuController::class, 'list_menus']);
    Route::get('/icons/list', [MenuController::class, 'getIcons']);
    Route::get('/icons/groups/list', [MenuController::class, 'getIconGroups']);
    Route::get('/components/list', [MenuController::class, 'getComponents']);
    Route::get('/levels/list', [MenuController::class, 'getVisibilityLevels']);
    Route::get('/types/list', [MenuController::class, 'getItemTypes']);