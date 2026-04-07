<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model {
    protected $table = 'tb_absensi';
    public $timestamps = false;
    protected $fillable = ['siswa_id','nama','kelas','tanggal','jam','status'];

    public function toApiArray(): array {
        return [
            'id'      => $this->id,
            'siswaId' => $this->siswa_id,
            'nama'    => $this->nama,
            'kelas'   => $this->kelas,
            'tanggal' => $this->tanggal,
            'jam'     => $this->jam ? substr($this->jam, 0, 5) : '',
            'status'  => $this->status,
        ];
    }
}
