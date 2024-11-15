<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyAdminController extends Controller
{
    public function mail(Request $request)
    {
        $company = Company::all()->first();
        $company->update([
            "SPARE1" => $request->SPARE1,
            "SPARE2" => $request->SPARE2
        ]);

        return redirect()->route('admin')
        ->with('message', '問い合わせのお知らせ先メールアドレスが登録されました。')
        ->with('activeTab', 'company-info');
    }

    public function update(Request $request)
    {
        $company = Company::all()->first();
        $company->update($request->all());
        return redirect()->route('admin')
        ->with('message', '会社情報が更新されました。')
        ->with('activeTab', 'company-info');
    }


}