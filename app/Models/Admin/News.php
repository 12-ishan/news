<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions; 

class News extends Model
{
    use LogsActivity;

    protected $table = 'news';

    protected $fillable = ['title', 'category_id', 'parent_id', 'slug', 'meta_description', 'description', 'imageId', 'status', 'sortOrder'];

    //protected static $recordEvents = ['deleted'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])->useLogName('news')->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
        // Chain fluent methods for configuration options
       
    }
    


    protected static function booted()
    {
        // static::updated(function ($news) {
        //     // Log status update if it changed
        //     if ($news->isDirty('status')) {
        //         activity()
        //             ->event(config('event.EVENT_UPDATED')) // Custom event for status update
        //             ->causedBy(auth()->user())
        //             ->performedOn($news)
        //             ->withProperties(['status' => $news->status]) // Log new status
        //             ->log("News status updated to '{$news->status}'");
            // }
       

    //     if ($news->isDirty('sortOrder')) {
    //         activity()
    //             ->event('sort_order_update') // Custom event for sort_order update
    //             ->causedBy(auth()->user())
    //             ->performedOn($news)
    //             ->withProperties(['sortOrder' => $news->sort_order]) // Log new sort order
    //             ->log("News sort order updated to '{$news->sort_order}'");
    //     }
    // });

    static::retrieved(function ($page) {
        $currentRoute = request()->route()->getName(); // Get the route name
        $currentUrl = request()->fullUrl(); // Get the full URL
    
        // Check if the current route is 'admin.news.index' or other relevant route
        activity()
            ->event('view') // Custom event for viewing a page
            ->causedBy(auth()->user())
            ->performedOn($page)
            ->withProperties([
                'route' => $currentRoute,
                'url' => $currentUrl,
            ])
            ->log("Page '{$currentUrl}' was viewed.");
    });
       

 
   }

//     public static function boot()
// {
//     parent::boot();

//     static::registerModelEvent('index', function ($model) {
//         activity('news')
//             ->causedBy(auth()->user())
//             ->performedOn($model)
//             ->log('Accessed the index event');
//     });
// }
  

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    public function image()
    {
        return $this->belongsTo(Media::class, 'imageId');
    }
        
}
