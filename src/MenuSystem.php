<?php
  
  namespace SamirEltabal\MenuSystem;

  class MenuSystem {
    public static function ping() {
        return response()
        ->json(
            ['message' => 'syncit menu is responding', 'version' => config('meun.version')],
        201);
    }
  }