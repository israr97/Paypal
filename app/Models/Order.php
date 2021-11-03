<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $table="orders";
    protected $fillable = ['user_id','name','trans_id','payment'];

    public function places()
    {
        return $this->belongsToMany('App\User','user_id');

        //return $this->belongsToMany('App\Place','App\User','Place_id', 'user_id');
    }
}
