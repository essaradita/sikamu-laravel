<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller {
    public function index() {
        $gurus = Guru::orderBy('nama')->get();
        return response()->json($gurus->map(function($g) {
            $user = User::where('id', $g->user_id)->first();
            $arr = $g->toApiArray();
            $arr['username'] = $user?->username ?? '-';
            $arr['userId']   = $user?->id ?? null;
            return $arr;
        }));
    }

    public function store(Request $request) {
        $guru = Guru::create(['nip'=>$request->nip,'nama'=>$request->nama,'mapel'=>$request->mapel,'jabatan'=>$request->jabatan,'no_hp'=>$request->noHp,'email'=>$request->email]);
        return response()->json(['success'=>true,'id'=>$guru->id]);
    }

    public function update(Request $request, $id) {
        Guru::findOrFail($id)->update(['nip'=>$request->nip,'nama'=>$request->nama,'mapel'=>$request->mapel,'jabatan'=>$request->jabatan,'no_hp'=>$request->noHp,'email'=>$request->email]);
        return response()->json(['success'=>true]);
    }

    public function destroy($id) {
        Guru::findOrFail($id)->delete();
        return response()->json(['success'=>true]);
    }

    // Reset password guru
    public function resetPassword(Request $request, $id) {
        $guru = Guru::findOrFail($id);
        if (!$guru->user_id) {
            return response()->json(['success'=>false,'message'=>'Guru ini belum punya akun login'], 400);
        }
        $newPassword = $request->password ?? 'guru123';
        User::where('id', $guru->user_id)->update([
            'password' => Hash::make($newPassword)
        ]);
        return response()->json(['success'=>true,'message'=>'Password berhasil direset']);
    }
}
