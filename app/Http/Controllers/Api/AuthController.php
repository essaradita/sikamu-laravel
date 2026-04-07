<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    public function login(Request $request) {
        $user = User::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Username atau password salah'], 401);
        }
        $token = $user->createToken('sikamu')->plainTextToken;
        return response()->json([
            'success' => true,
            'token'   => $token,
            'user'    => ['id' => $user->id, 'username' => $user->username, 'name' => $user->name, 'role' => $user->role],
        ]);
    }

    public function register(Request $request) {
        if (User::where('username', $request->username)->exists()) {
            return response()->json(['success' => false, 'message' => 'Username sudah digunakan'], 400);
        }
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name'     => $request->nama,
            'role'     => 'guru',
        ]);
        Guru::create([
            'nip'     => 'NIP' . time(),
            'nama'    => $request->nama,
            'mapel'   => $request->mapel,
            'jabatan' => 'Guru',
            'no_hp'   => $request->noHp ?? '-',
            'email'   => $request->email ?? '-',
            'user_id' => $user->id,
        ]);
        return response()->json(['success' => true, 'message' => 'Pendaftaran berhasil']);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => true]);
    }
}
