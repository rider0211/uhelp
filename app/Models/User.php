<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Profile\UserProfile;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\Comment;
use App\Models\Articles\article_likes;
use App\Models\VerifyUser;
use App\Models\CategoryUser;
use App\Models\usersettings;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'firstname',
        'lastname',
        'empid',
        'name',
        'email',
        'password',
        'country',
        'gender',
        'timezone',
        'image',
        'role_id',
        'status',
        'verified',
        'phone',
        'skills',
        'languages',
        'darkmode',
        'rtl',
        'boxed',
    ];

   

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function verifyUser()
    {
        return $this->hasOne(VerifyUser::class);
    }

    public function userprofile()
    {
        return $this->hasOne(UserProfile::class);
    }
    
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function ticketss()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function article_likes()
    {
        return $this->hasMany(article_likes::class);
    }

    public function catuser()
    {
        return $this->hasMany(CategoryUser::class, 'category_user_id');
    }

    public function usetting()
    {
        return $this->hasOne(usersettings::class, 'users_id','id');
    }

    public function usercustomsetting(){

        return $this->hasMany(senduserlist::class, 'touser_id');
    }
    
}
