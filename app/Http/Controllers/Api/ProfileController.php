<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller {

    public function show(Request $request) {
        $user = $request->user();
        $guru = Guru::where('user_id', $user->id)->first();
        return response()->json([
            'id'       => $user->id,
            'username' => $user->username,
            'name'     => $user->name,
            'role'     => $user->role,
            'mapel'    => $guru?->mapel ?? '-',
            'noHp'     => $guru?->no_hp ?? '-',
            'email'    => $guru?->email ?? '-',
            'jabatan'  => $guru?->jabatan ?? '-',
        ]);
    }

    public function update(Request $request) {
        $user = $request->user();

        // Update nama
        if ($request->name) {
            User::where('id', $user->id)->update(['name' => $request->name]);
        }

        // Update password
        if ($request->password) {
            if (!Hash::check($request->passwordLama, $user->password)) {
                return response()->json(['success' => false, 'message' => 'Password lama salah'], 400);
            }
            if (strlen($request->password) < 6) {
                return response()->json(['success' => false, 'message' => 'Password baru minimal 6 karakter'], 400);
            }
            User::where('id', $user->id)->update(['password' => Hash::make($request->password)]);
        }

        // Update data guru jika role guru
        if ($user->role === 'guru') {
            Guru::where('user_id', $user->id)->update([
                'nama'   => $request->name ?? $user->name,
                'no_hp'  => $request->noHp ?? '',
                'email'  => $request->email ?? '',
                'mapel'  => $request->mapel ?? '',
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Profil berhasil diperbarui']);
    }
}
