<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Mail\ContactSendmail;

class ContactController extends Controller
{
    public function index()
    {
        $topImg = Image::where('VIEW_FLG', 'S105')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG', 'S005')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $sns = Company::first();

        return view('contact.index', compact('topImg', 'backImg', 'logoImg','sns'));
    }

    public function confirm(Request $request)
    {
        $topImg = Image::where('VIEW_FLG', 'S105')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG', 'S005')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $sns = Company::first();
        $contact = $request->all();
        return view('contact.confirm',compact('topImg', 'backImg', 'logoImg','sns','contact'));
    }

    public function send(Request $request)
    {
        //DBに登録する
        $contact = Contact::create($request->all());
        //ランダムなIDを生成し、問い合わせ番号とする
        $referenceId = "";
        for($i=0;$i<6;$i++){
            $referenceId.=mt_rand(0,9);
        }
        $referenceId = "C" . $contact->CNTACT_ID . $referenceId;
        $contact->update(["REFERENCE_NUMBER" => $referenceId]);

        //管理者に通知メールを知らせる(CompanyのSPARE1とSPARE2に入っているメールアドレスに送信)
        $sendMail = Company::select('SPARE1', 'SPARE2')->first();
        \Mail::send(new ContactSendmail($contact,'contact.mail_kanri', $sendMail));
        //入力されたメールに返信する
        \Mail::send(new ContactSendmail($contact,'contact.mail', null));

        $request->session()->regenerateToken();
        return redirect()->route('contact')
        ->with('message', 'フォームが送信されました。返答をお待ちください。');
    }
}