<?php

namespace App\Models\Advertiser;

use Illuminate\Database\Eloquent\Model;

class Advertises extends Model
{
    protected  $table="advertises";
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','content', 'rate', 'photo','price','is_active','user_id'
    ];

    public function getPhotoAttribute($image){

        if ($image == null)
            return url('images/advs/photo/defaultAdvertise.jpg');
        else
            return url('images/advs/photo/'.$image);
    }

}
