<?php

namespace SamirEltabal\MenuSystem\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'route',
        'class',
        'icon_name',
        'icon_family',
        'parent_id',
        'menu_id',
        'type',
        'visibility_level',
        'order'
    ];

    protected $hidden = ['created_at', 'updated_at', 'parent'];
    protected $with = ['children'];
    protected $appends = ['ParentName','HasChild'];
    public function menu() {
        return $this->belongsTo(SamirEltabal\MenuSystem\Models\Menu::class, 'menu_id', 'id');
    }

    public function children () {
        return $this->hasMany(self::class, 'parent_id', 'id')->orderBy('order');;
    }

    public function parent () {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function getParentNameAttribute () {
        if($this->parent != null) {
            return $this->parent->text;
        } else {
            return null;
        }
    }
    
    public function getHasChildAttribute () {
        if($this->children->count()) {
            return true;
        } else {
            return false;
        }
    }

    public function setOrder($value) {
        try {
            $this->order = $value;
            $this->save();
        } catch (\Throwable $th) {
            return false;
        }
        return $this;
    }

    public function setParent($value) {
        try {
            $this->parent_id = $value;
            $this->save();
        } catch (\Throwable $th) {
            return false;
        }
        return $this;
    }

    public function setVisibility($value) {
        try {
            $this->visibility_level = $value;
            $this->save();
        } catch (\Throwable $th) {
            return false;
        }
        return $this;
    }
}
