<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    public function category()
    {
        return $this->belongsTo(MediaCategory::class, 'category_id');
    }
    
}