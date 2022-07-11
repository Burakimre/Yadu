<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlockedUser extends Model
{
   protected $fillable = ['account_id','blockedAccount_id'];

      public function account()
      {
         return $this->belongsTo('App\Account');
      }
      public function blockedAccount()
      {
         return $this->hasOne('App\Account', 'id', 'blockedAccount_id');
	   }
}