<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CostumeClient;
use App\Models\CostumeClientImage;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class WorksAdminController extends Controller
{
    /**
     * works編集ページ表示
     */
    public function index()
    {
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $clients = CostumeClient::with('images')->orderBy('priority')->get();
        return view('admin.works-entry', compact('clients', 'logoImg'));
    }

    /**
     * 新規クライアント登録
     */
    public function storeClient(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_name_kana' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'homepage_url' => 'nullable|url',
            'sns_x' => 'nullable|url',
            'sns_instagram' => 'nullable|url',
            'sns_tiktok' => 'nullable|url',
        ]);

        CostumeClient::create($validated);

        return redirect()->route('admin.works.index')->with('message', '新しいグループを登録しました。');
    }

    /**
     * ★★★ 修正箇所 ★★★
     * 画像のアップロード処理を修正
     */
    public function uploadImages(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:costume_clients,client_id',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $clientId = $request->input('client_id');
        $storagePath = 'works/' . $clientId;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // storeメソッドでファイルを保存し、ユニークなパスを取得
                $path = $file->store($storagePath, 'public');

                CostumeClientImage::create([
                    'client_id' => $clientId,
                    'file_path' => 'storage/', // 固定
                    'file_name' => $path,      // storeが返すパスをそのまま保存
                    'alt_text' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                ]);
            }
        }

        return redirect()->route('admin.works.index')->with('message', '画像を追加しました。');
    }

    /**
     * クライアント情報の更新
     */
    public function updateClient(Request $request, CostumeClient $client)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_name_kana' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'homepage_url' => 'nullable|url',
            'sns_x' => 'nullable|url',
            'sns_instagram' => 'nullable|url',
            'sns_tiktok' => 'nullable|url',
        ]);

        $client->update($validated);
        return redirect()->route('admin.works.index')->with('message', 'グループ情報を更新しました。');
    }

    /**
     * クライアントの削除
     */
    public function destroyClient(CostumeClient $client)
    {
        // 関連する画像を先に削除
        foreach ($client->images as $image) {
            Storage::disk('public')->delete($image->file_name);
            $image->delete();
        }
        $client->delete();
        return redirect()->route('admin.works.index')->with('message', 'グループを削除しました。');
    }

    /**
     * 画像の削除
     */
    public function destroyImage(CostumeClientImage $image)
    {
        Storage::disk('public')->delete($image->file_name);
        $image->delete();
        return redirect()->route('admin.works.index')->with('message', '画像を削除しました。');
    }

    /**
     * グループの並び順を更新
     */
    public function reorderClients(Request $request)
    {
        $request->validate(['order' => 'required|array']);

        foreach ($request->order as $index => $clientId) {
            CostumeClient::where('client_id', $clientId)->update(['priority' => $index]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * 画像の情報を更新（現在は優先度のみ）
     */
    public function updateImage(Request $request, CostumeClientImage $image)
    {
        $request->validate(['priority' => 'required|integer']);

        $image->update(['priority' => $request->priority]);

        return redirect()->route('admin.works.index')->with('message', '画像の並び順を更新しました。');
    }
}
