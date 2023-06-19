<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserDepartmentEnums;
use App\Enums\UserLevelEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'staff_id',
        'email',
        'password',

        'department',
        'position',
        'user_level',
        'status',
        'department_head',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'user_level' => UserLevelEnums::class,
        'department' => UserDepartmentEnums::class,
    ];

    public function routeNotificationForMail($notification){
        return [$this->email => $this->name];
    }
    public function HOD(){
        // dd($this->department_head);
        return $this->hasOne(User::class,'department','department')->find($this->department_head);
    }

    public function permissions()
    {
        return $this->hasMany(userPermission::class);
    }

    public function colleague(){
        return $this->hasMany(User::class,'department','department')->get();
    }

    public function Training()
    {
        return $this->hasMany(TrainingRequest::class);
    }
}
