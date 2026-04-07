<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model {
    protected $table = 'tb_nilai';
    public $timestamps = false;
    protected $fillable = ['siswa_id','nama','kelas','mapel','uts','uas','tugas','nilai'];

    public function toApiArray(): array {
        return [
            'id'      => $this->id,
            'siswaId' => $this->siswa_id,
            'nama'    => $this->nama,
            'kelas'   => $this->kelas,
            'mapel'   => $this->mapel,
            'uts'     => (float)$this->uts,
            'uas'     => (float)$this->uas,
            'tugas'   => (float)$this->tugas,
            'nilai'   => (float)$this->nilai,
        ];
    }
}
