<?php
namespace App;

use App\Events\AccountCreatedEvent;
use App\Events\AccountCreation;
use App\Events\AccountEdited;
use App\Mail\Confirmation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use App\Traits\Encryptable;

class Account extends Authenticatable implements MustVerifyEmailContract
{
    
    use Notifiable;
    use Encryptable;

    protected $fillable = ['firstName', 'middleName', 'lastName', 'dateOfBirth', 'email', 'password','gender', 'avatar', 'api_token','followerVisibility','followingVisibility','infoVisibility','eventsVisibility','participatingVisibility'];
    protected $encryptable = ['firstName', 'middleName', 'lastName'];

    protected $dispatchesEvents = [

        'created' => AccountCreation::class,
        'updating' => AccountEdited::class
    ];

    public function getAvatarAttribute($key)
    {
        $avatar = $this->attributes['avatar'];

        if ($avatar == null) {
            $filePath = public_path() . "/images/avatar.png";

            return fread(fopen($filePath, "r"), filesize($filePath));
        }
        else
        {
            return $avatar;
        }
    }

    public function gender()
    {
       return $this->belongsTo(Gender::class);
	}

	public function participates()
    {
        return $this->belongsToMany('App\Event', 'event_has_participants', 'account_id', 'event_id');
    }

    public function messages() {
        return $this->hasMany('App\Message');
    }

    public function settings(){
        return $this->hasOne('App\AccountSettings');
	}

    public function followers(){
        return $this->hasMany('App\AccountHasFollowers');
    }

    public function blockedUsers()
    {
        return $this->hasMany('App\BlockedUser');
    }

    public function following()
    {
    	return $this->belongsToMany('App\Account', 'account_has_followers', 'follower_id', 'account_id');        
    }
}
