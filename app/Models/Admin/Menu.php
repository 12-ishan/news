<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    protected $fillable = ['name', 'slug', 'status', 'sortOrder'];

    /**
     * Define a relationship to fetch menu items associated with this menu.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(MenuItem::class, 'menu_id');
    }
}
