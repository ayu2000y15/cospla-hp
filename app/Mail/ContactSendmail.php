<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSendmail extends Mailable
{
    use Queueable, SerializesModels;

    public $referenceNumber;
    public $contactCategoryName;
    public $name;
    public $age;
    public $mail;
    public $tel;
    public $subject;
    public $subject2;
    public $content;
    public $root;
    public $mailCC = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact, $root, $sendMail)
    {
        $this->root = $root;
        if($root == 'contact.mail'){
            $this->subject = '送信が完了しました 【' . $contact['SUBJECT'] . '】';
            $this->mail = $contact['MAIL'];
        }else{
            $this->subject = 'HPから問い合わせを受け付けました 【問い合わせ番号：' . $contact['REFERENCE_NUMBER'] . '】';
            if(isset($sendMail)){
                if(!is_null($sendMail['SPARE1']) || !empty($sendMail['SPARE1'])){
                    $this->mail = $sendMail['SPARE1'];
                }
                if(!is_null($sendMail['SPARE2']) || !empty($sendMail['SPARE2'])){
                    $this->mailCC = $sendMail['SPARE2'];
                }
            }
        }

        $this->referenceNumber = $contact['REFERENCE_NUMBER'];
        $this->contactCategoryName = $contact['CONTACT_CATEGORY_NAME'];
        $this->name = $contact['NAME'];
        $this->age = $contact['AGE'];
        $this->tel = $contact['TEL'];
        $this->subject2 = $contact['SUBJECT'];
        $this->content = $contact['CONTENT'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //ccがある場合はこっち
        if($this->mailCC == null){
            return $this
            ->to($this->mail)
            ->cc($this->mailCC)
            ->subject( $this->subject)
            ->text($this->root)
            ->with([
                'contactCategoryName' => $this->contactCategoryName,
                'name' => $this->name,
                'age' => $this->age,
                'email' => $this->mail,
                'tel' => $this->tel,
                'subject' => '【' . $this->subject2 . '】',
                'content' => $this->content
            ]);
        }
        return $this
        ->to($this->mail)
        ->subject( $this->subject)
        ->text($this->root)
        ->with([
            'contactCategoryName' => $this->contactCategoryName,
            'name' => $this->name,
            'age' => $this->age,
            'email' => $this->mail,
            'tel' => $this->tel,
            'subject' => '【' . $this->subject2 . '】',
            'content' => $this->content
        ]);
    }
}