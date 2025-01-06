<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class NewsSubCategory extends Model
{
    protected $table = 'news_sub_category';

    public function news()
    {
        return $this->hasMany(News::class, 'category_id');
    }

    public function subCategories()
    {
        return $this->hasMany(NewsSubCategory::class, 'category_id');
    }

}