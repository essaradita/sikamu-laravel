<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller {
    public function index(Request $request) {
        $q = Nilai::query();
        if ($request->kelas) $q->where('kelas', $request->kelas);
        return response()->json($q->orderBy('nama')->get()->map->toApiArray());
    }

    public function store(Request $request) {
        $n = Nilai::create(['siswa_id'=>$request->siswaId,'nama'=>$request->nama,'kelas'=>$request->kelas,'mapel'=>$request->mapel,'uts'=>$request->uts,'uas'=>$request->uas,'tugas'=>$request->tugas,'nilai'=>$request->nilai]);
        return response()->json(['success'=>true,'id'=>$n->id]);
    }

    public function update(Request $request, $id) {
        Nilai::findOrFail($id)->update(['mapel'=>$request->mapel,'uts'=>$request->uts,'uas'=>$request->uas,'tugas'=>$request->tugas,'nilai'=>$request->nilai]);
        return response()->json(['success'=>true]);
    }

    public function destroy($id) {
        Nilai::findOrFail($id)->delete();
        return response()->json(['success'=>true]);
    }
}
