<?php

namespace App\Mail;

use App\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

class Follow extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $followRequest;
    public $currentLocale;
    public function __construct($user,$followRequest)
    {
        $this->currentLocale = app()->getLocale();
        $this->user = $user;
        $this->followRequest = $followRequest;
        $accountToFollow = Account::where('id',$followRequest->account_id)->first();
        self::switchLang($accountToFollow);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->markdown('mail/follow')
            ->subject($this->user->firstName . ' ' .  Lang::get('profile.follow_request'))
            ->with([
            'ownerId'=>$this->followRequest->verification_string,
            'ownerName'=>$this->user->firstName . ' ' .  Lang::get('profile.follow_request'),
            'acceptButtonText' => Lang::get('profile.follow_request_accept'),
            'declineButtonText' => Lang::get('profile.follow_request_decline'),
        ]);
        App::setLocale($this->currentLocale);
        return $mail;
    }

    private function switchLang($user){
        switch($user->settings->LanguagePreference){
            case 'eng': App::setLocale('eng');
                break;
            case 'nl': App::setLocale('nl');
                break;
            default: App::setLocale('eng');
                break;
        }
    }
}
