<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions; 

class NewsCategory extends Model
{
    use LogsActivity;

    protected $table = 'news_category';

    protected $fillable = ['name', 'parent_id', 'slug', 'description', 'status', 'sortOrder'];

    public function news()
    {
        return $this->hasMany(News::class, 'category_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])->useLogName('news category')->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
        // Chain fluent methods for configuration options
       
    }

    // protected static function booted()
    // {
    //     static::retrieved(function ($page) {
    //         $currentRoute = request()->route()->getName(); // Get the route name
    //         $currentUrl = request()->fullUrl(); // Get the full URL
        
    //         // Check if the current route is 'admin.news.index' or other relevant route
    //         activity()
    //             ->event('view') // Custom event for viewing a page
    //             ->causedBy(auth()->user())
    //             ->performedOn($page)
    //             ->withProperties([
    //                 'route' => $currentRoute,
    //                 'url' => $currentUrl,
    //             ])
    //             ->log("Page '{$currentUrl}' was viewed.");
    //     });
    // }
 
}