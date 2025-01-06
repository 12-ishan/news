<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions; 

class Contact extends Model
{
    use LogsActivity;
    
    protected $table = 'contact';

    protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'status', 'sortOrder'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])->useLogName('contact leads')->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
        // Chain fluent methods for configuration options
       
    }
}
