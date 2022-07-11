<?php

namespace App\Mail\Account;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;

class AccountEdited extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $account;
    public function __construct($account)
    {
        $this->account = $account;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $bodyText = '';
        if($this->account->password != $this->account->getOriginal('password')){
            $bodyText = Lang::get('mail.changedPassword');
        }else  if($this->account->email != $this->account->getOriginal('email')){
            $bodyText = Lang::get('mail.changedEmail');
        }else{
            $bodyText = Lang::get('mail.changedPersonalInfo');
       }

        return $this->markdown('mail/shortInformationMail')
            ->subject($this->account->firstName ." ".  Lang::get('mail.subjectAccountEdited'))
            ->with([
            'headText' =>  $this->account->firstName ." ".  Lang::get('mail.editAccountHeader'),
            'salutation'=> Lang::get('mail.salutation'),
            'name'=>$this->account->firstName . ",",
            'bodyText' => $bodyText
        ]);
    }
}
