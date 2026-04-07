<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller {
    public function index() {
        return response()->json(Notifikasi::orderByDesc('created_at')->get()->map->toApiArray());
    }

    public function store(Request $request) {
        $n = Notifikasi::create(['judul'=>$request->judul,'pesan'=>$request->pesan,'penerima'=>$request->penerima,'no_hp'=>$request->noHp,'tanggal'=>$request->tanggal,'status'=>$request->status ?? 'terkirim']);
        return response()->json(['success'=>true,'id'=>$n->id]);
    }

    public function update(Request $request, $id) {
        Notifikasi::findOrFail($id)->update(['status'=>$request->status]);
        return response()->json(['success'=>true]);
    }

    public function destroy($id) {
        Notifikasi::findOrFail($id)->delete();
        return response()->json(['success'=>true]);
    }
}
