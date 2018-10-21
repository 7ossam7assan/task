<?php

namespace App;

use App\Enums\UserTypeEnum;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected  $table="users";
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','name', 'email', 'password','type','phone','photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->type == UserTypeEnum::ADMIN;
    }
    public function isAdvertiser()
    {
        return $this->type == UserTypeEnum::ADVERTISER;
    }

    public function getPhotoAttribute($image){

        if ($image == null)
            return url('images/default.jpg');
        else{
            if ($this->isAdmin())
                return url('images/admin/photo/'.$image);
            else
                return url('images/advertisers/photo/'.$image);
        }

    }
}
