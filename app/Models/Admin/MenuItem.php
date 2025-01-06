<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'menu_items';

    protected $fillable = ['menu_id', 'parent_id', 'title', 'url', 'target', 'tooltip', 'icon'];

   
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    /**
     * Define a relationship to fetch the parent menu item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id', 'id');
    }
}
