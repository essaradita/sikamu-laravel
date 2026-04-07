<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller {
    public function index(Request $request) {
        $q = Siswa::query();
        if ($request->kelas) $q->where('kelas', $request->kelas);
        return response()->json($q->orderBy('nama')->get()->map->toApiArray());
    }

    public function store(Request $request) {
        $siswa = Siswa::create([
            'nisn'          => $request->nisn,
            'nama'          => $request->nama,
            'kelas'         => $request->kelas,
            'jenis_kelamin' => $request->jenisKelamin,
            'alamat'        => $request->alamat,
            'no_hp'         => $request->noHp,
            'wali'          => $request->wali,
        ]);
        return response()->json(['success' => true, 'id' => $siswa->id]);
    }

    public function update(Request $request, $id) {
        Siswa::findOrFail($id)->update([
            'nisn'          => $request->nisn,
            'nama'          => $request->nama,
            'kelas'         => $request->kelas,
            'jenis_kelamin' => $request->jenisKelamin,
            'alamat'        => $request->alamat,
            'no_hp'         => $request->noHp,
            'wali'          => $request->wali,
        ]);
        return response()->json(['success' => true]);
    }

    public function destroy($id) {
        Siswa::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
