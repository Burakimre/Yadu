<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountSettings extends Model
{
    protected $fillable = [
        'account_id',
        'FollowNotificationCreateEvent',
        'FollowNotificationJoinAndLeaveEvent',
        'NotificationEventEdited',
        'NotificationEventDeleted',
        'NotificationJoinAndLeaveEvent',
        'LanguagePreference'];
    public function account()
    {
        return $this->belongsTo('App\Account', 'account_id', 'id');
    }
}
