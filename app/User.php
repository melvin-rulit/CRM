<?php

namespace App;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
use EloquentFilter\Filterable;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasApiTokens, HasRelationships, Filterable;

    public function hasRole($role)
    {
        if ($this->roles->contains('title', $role)) {
            return true;
        }
        return false;
    }

    public function permissions()
    {
        return $this->hasManyDeep('App\Permission', ['role_user', 'App\Role', 'permission_role']);
    }

    public function region()
    {
        return $this->hasManyDeep('App\Permission', ['role_user', 'App\Role', 'permission_role']);
    }

    protected $casts = ["last_online_at" => "datetime"];

    public $table = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at',
    ];

    protected $fillable = [
        'name',
        'surname',
        'phone',
        'avatar',
        'about_as',
        'birthday',
        'facebook',
        'instagram',
        'email',
        'password',
        'class_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'remember_token',
        'email_verified_at',
        'secret_id',
    ];

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function getIsTeacherAttribute()
    {
        return $this->roles()->where('id', 3)->exists();
    }

    public function getIsStudentAttribute()
    {
        return $this->roles()->where('id', 4)->exists();
    }

    public function teacherLessons()
    {
        return $this->hasMany(Lesson::class, 'teacher_id', 'id');
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function userAccess()
    {
        return $this->belongsToMany('App\Role', 'user_accesses');
    }

    public function branches()
    {
        return $this->belongsToMany('App\Branch', 'user_branches');
    }

//    public function scopeFilter($builder, $filters)
//    {
//        return $filters->apply($builder);
//    }

    public function comm()
    {
        return $this->hasMany('App\Comments', 'user_id');
    }

}
