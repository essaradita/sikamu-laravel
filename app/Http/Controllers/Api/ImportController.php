<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Http\Request;

class ImportController extends Controller {

    public function importSiswa(Request $request) {
        if (!$request->hasFile('file')) {
            return response()->json(['success' => false, 'message' => 'File tidak ditemukan'], 400);
        }

        $file    = $request->file('file');
        $path    = $file->getRealPath();
        $reader  = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $sheet   = $reader->getActiveSheet()->toArray(null, true, true, true);

        $inserted = 0;
        $skipped  = 0;
        $errors   = [];

        foreach ($sheet as $i => $row) {
            if ($i === 1) continue; // skip header

            $nisn  = trim($row['A'] ?? '');
            $nama  = trim($row['B'] ?? '');
            $kelas = trim($row['C'] ?? '');
            $jk    = strtoupper(trim($row['D'] ?? 'L'));
            $alamat = trim($row['E'] ?? '');
            $noHp  = trim($row['F'] ?? '');
            $wali  = trim($row['G'] ?? '');

            if (!$nisn || !$nama || !$kelas) {
                $errors[] = "Baris $i: NISN, Nama, atau Kelas kosong";
                $skipped++;
                continue;
            }

            // Skip jika NISN sudah ada
            if (Siswa::where('nisn', $nisn)->exists()) {
                $skipped++;
                continue;
            }

            Siswa::create([
                'nisn'          => $nisn,
                'nama'          => $nama,
                'kelas'         => $kelas,
                'jenis_kelamin' => in_array($jk, ['L','P']) ? $jk : 'L',
                'alamat'        => $alamat,
                'no_hp'         => $noHp,
                'wali'          => $wali,
            ]);
            $inserted++;
        }

        return response()->json([
            'success'  => true,
            'inserted' => $inserted,
            'skipped'  => $skipped,
            'errors'   => $errors,
            'message'  => "$inserted siswa berhasil diimport, $skipped dilewati",
        ]);
    }

    public function importGuru(Request $request) {
        if (!$request->hasFile('file')) {
            return response()->json(['success' => false, 'message' => 'File tidak ditemukan'], 400);
        }

        $file   = $request->file('file');
        $path   = $file->getRealPath();
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $sheet  = $reader->getActiveSheet()->toArray(null, true, true, true);

        $inserted = 0;
        $skipped  = 0;

        foreach ($sheet as $i => $row) {
            if ($i === 1) continue;

            $nip     = trim($row['A'] ?? '');
            $nama    = trim($row['B'] ?? '');
            $mapel   = trim($row['C'] ?? '');
            $jabatan = trim($row['D'] ?? 'Guru');
            $noHp    = trim($row['E'] ?? '');
            $email   = trim($row['F'] ?? '');

            if (!$nip || !$nama) { $skipped++; continue; }

            if (Guru::where('nip', $nip)->exists()) { $skipped++; continue; }

            Guru::create([
                'nip'     => $nip,
                'nama'    => $nama,
                'mapel'   => $mapel,
                'jabatan' => $jabatan,
                'no_hp'   => $noHp,
                'email'   => $email,
            ]);
            $inserted++;
        }

        return response()->json([
            'success'  => true,
            'inserted' => $inserted,
            'skipped'  => $skipped,
            'message'  => "$inserted guru berhasil diimport, $skipped dilewati",
        ]);
    }
}
