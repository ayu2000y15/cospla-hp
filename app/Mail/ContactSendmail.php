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
    public $category;
    public $name;
    public $mail;
    public $tel;
    public $subject;
    public $subject2;
    public $content;
    public $root;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact, $root)
    {
        $this->root = $root;
        if($root == 'contact.mail'){
            $this->subject = '送信が完了しました 【' . $contact['SUBJECT'] . '】';
        }else{
            $this->subject = 'HPから問い合わせを受け付けました 【問い合わせ番号：' . $contact['REFERENCE_NUMBER'] . '】';

        }
        $this->referenceNumber = $contact['REFERENCE_NUMBER'];
        $this->category = $contact['CATEGORY'];
        $this->name = $contact['NAME'];
        $this->mail = $contact['MAIL'];
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
        return $this
        ->to($this->mail)
        ->subject( $this->subject)
        ->text($this->root)
        ->with([
            'questionCategory' => $this->category,
            'name' => $this->name,
            'email' => $this->mail,
            'tel' => $this->tel,
            'subject' => '【' . $this->subject2 . '】',
            'content' => $this->content
        ]);
    }
}

