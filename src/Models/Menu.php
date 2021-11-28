<?php

namespace SamirEltabal\MenuSystem\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SamirEltabal\MenuSystem\Models\MenuItem;
use Str;
class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['menu_name', 'active', 'component_name', 'slug'];
    protected $with = ['items', 'tree'];
    public static function boot() {
        parent::boot();
        self::created(function ($model) {
            $model->slug = (string) Str::slug($model->menu_name, '-').'-'.$model->id;
            $model->save();
        });
    }

    public function disable() {
        $this->active = false;
        return $this;
    }

    public function enable() {
        $this->active = true;
        return $this;
    }

    public function tree() {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id')->where('parent_id', null)->orderBy('order');
    }

    public function items() {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id')->orderBy('order');;
    }

    public function scopeSlug($query, $slug) {
        return $query->where('slug', '=', $slug)->where('active', '=', true);
    }
    public function scopeFindBySlug($query, $slug) {
        return $query->where('slug', '=', $slug);
    }

}
