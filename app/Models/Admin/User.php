<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use App\Models\Admin\Role;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions; 

class User extends Model implements AuthenticatableContract
{
    use HasApiTokens, LogsActivity, Notifiable, Authenticatable; 

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'roleId', 'password'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'roleId', 'email', 'password'])->useLogName('user');
        // Chain fluent methods for configuration options
       
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function image()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'imageId', 'id');
    }
    public function role()
    {
        return $this->belongsTo('App\Models\Admin\Role', 'roleId', 'id');
    }

 

    public function hasPermission($permission)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions()->where('slug', $permission)->exists()) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($roleName)
{
    return $this->roles()->where('name', $roleName)->exists();
}
}