<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model {
    protected $table = 'tb_siswa';
    public $timestamps = false;
    protected $fillable = ['nisn','nama','kelas','jenis_kelamin','alamat','no_hp','wali'];

    protected function casts(): array {
        return ['id' => 'integer'];
    }

    public function toApiArray(): array {
        return [
            'id'           => $this->id,
            'nisn'         => $this->nisn,
            'nama'         => $this->nama,
            'kelas'        => $this->kelas,
            'jenisKelamin' => $this->jenis_kelamin,
            'alamat'       => $this->alamat,
            'noHp'         => $this->no_hp,
            'wali'         => $this->wali,
        ];
    }
}
