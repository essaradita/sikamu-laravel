<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller {
    public function index(Request $request) {
        $q = Absensi::query();
        if ($request->kelas)   $q->where('kelas', $request->kelas);
        if ($request->tanggal) $q->where('tanggal', $request->tanggal);
        if ($request->bulan)   $q->whereRaw("DATE_FORMAT(tanggal,'%Y-%m') = ?", [$request->bulan]);
        if ($request->limit)   $q->limit((int)$request->limit);
        return response()->json($q->orderByDesc('tanggal')->orderByDesc('jam')->get()->map->toApiArray());
    }

    public function store(Request $request) {
        $a = Absensi::create(['siswa_id'=>$request->siswaId,'nama'=>$request->nama,'kelas'=>$request->kelas,'tanggal'=>$request->tanggal,'jam'=>$request->jam,'status'=>$request->status]);
        return response()->json(['success'=>true,'id'=>$a->id]);
    }

    public function update(Request $request, $id) {
        Absensi::findOrFail($id)->update(['tanggal'=>$request->tanggal,'jam'=>$request->jam,'status'=>$request->status]);
        return response()->json(['success'=>true]);
    }

    public function destroy($id) {
        Absensi::findOrFail($id)->delete();
        return response()->json(['success'=>true]);
    }
}
