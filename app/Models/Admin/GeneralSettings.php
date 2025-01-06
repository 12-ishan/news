<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions; 

class GeneralSettings extends Model
{
    use LogsActivity;
    
    protected $table = 'general_settings';

    protected $fillable = ['meta_title', 'imageId', 'meta_description', 'button_url', 'description', 'status', 'sortOrder'];

    public function image()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'imageId', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])->useLogName('general setting')->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
        // Chain fluent methods for configuration options
       
    }

}