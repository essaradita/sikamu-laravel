<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model {
    protected $table = 'tb_notifikasi';
    public $timestamps = false;
    protected $fillable = ['judul','pesan','penerima','no_hp','tanggal','status'];

    public function toApiArray(): array {
        return [
            'id'       => $this->id,
            'judul'    => $this->judul,
            'pesan'    => $this->pesan,
            'penerima' => $this->penerima,
            'noHp'     => $this->no_hp,
            'tanggal'  => $this->tanggal,
            'status'   => $this->status,
        ];
    }
}
