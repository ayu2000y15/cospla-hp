<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Image;
use App\Models\Acmail;

use Illuminate\Support\Facades\Session;



class AcmailAdminController extends Controller
{
    public function entry(Request $request)
    {
        $count = Acmail::where('MAIL', $request->MAIL)->count();
        if($count > 0){
            return redirect()->route('admin')
            ->with('error', 'このメールアドレスは登録済みです。')
            ->with('activeTabAc', 'ac-entry');
        }
        Acmail::create($request->all());

        return redirect()->route('admin')
        ->with('message', 'メールアドレスが新しく登録されました。')
        ->with('activeTabAc', 'ac-entry');
    }

    public function csvOutput(Request $request)
    {
        $temps = [];
        foreach($request->SELECTED_ITEM as $item){
            $acmail = Acmail::findOrFail($item);
            $temp = [
                $acmail->MAIL,
                $acmail->COL1,
                $acmail->COL2,
                $acmail->COL3,
                $acmail->COL4,
                $acmail->COL5,
                $acmail->COL6,
                $acmail->COL7,
                $acmail->COL8,
                $acmail->COL9,
                $acmail->COL10,
                $acmail->DELIVERY_FLG,
            ];
            array_push($temps, $temp);
        }

        $filename = "acメーラー_" . date("Ymd_His"). ".csv";

        // Content-Typeを設定
        header('Content-Type: text/csv; charset=SJIS-win');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // 出力バッファリングを開始
        ob_start();

        // ファイルポインタを作成
        $output = fopen('php://output', 'w');

        $removeQuotes = function($str) {
            return str_replace('"', '', $str);
        };

        foreach ($temps as $temp) {
            // ダブルクォーテーションを削除し、SJISに変換
            $encodedTemp = array_map(function($str) use ($removeQuotes) {
                return mb_convert_encoding($removeQuotes($str), 'SJIS-win', 'UTF-8');
            }, $temp);

            // fputcsvの代わりにfputs使用してカンマ区切りの文字列を直接書き込む
            fputs($output, implode(',', $encodedTemp) . "\r\n");
        }

        fclose($output);

        $csv = ob_get_clean();

        echo $csv;

        exit();
    }

    public function edit(Request $request)
    {
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $access_view = Session::get('access_view');

        $acmailEdit = Acmail::findOrFail($request->AC_ID);

        //Acmail一覧取得
        $acmail = Acmail::all()->sortByDesc('AC_ID');
        if (!Session::has('activeTabAc')) {
            session()->flash('activeTabAc', 'ac-entry');
        }

        return view('admin.ac.index-acmail', compact(
        'logoImg',  'acmail', 'acmailEdit'
        ));

    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'AC_ID' => 'required|integer',
            'MAIL' => 'required|string',
            'COL1' => 'nullable|string',
            'COL2' => 'nullable|string',
            'COL3' => 'nullable|string',
            'COL4' => 'nullable|string',
            'COL5' => 'nullable|string',
            'COL6' => 'nullable|string',
            'COL7' => 'nullable|string',
            'COL8' => 'nullable|string',
            'COL9' => 'nullable|string',
            'COL10' => 'nullable|string',
            'DELIVERY_FLG' => 'nullable|string',
        ]);
        Acmail::where('AC_ID',$request->AC_ID)
        ->update($validatedData);

        return redirect()->route('admin')
        ->with('message', '情報が更新されました。')
        ->with('activeTabAc', 'ac-list');
    }

    public function delete(Request $request)
    {
        Acmail::where('AC_ID',$request->AC_ID)->delete();
        return redirect()->route('admin')
        ->with('message', '削除されました。')
        ->with('activeTabAc', 'ac-list');
    }

}
