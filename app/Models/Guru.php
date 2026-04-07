<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model {
    protected $table = 'tb_guru';
    public $timestamps = false;
    protected $fillable = ['nip','nama','mapel','jabatan','no_hp','email','user_id'];

    public function toApiArray(): array {
        return [
            'id'      => $this->id,
            'nip'     => $this->nip,
            'nama'    => $this->nama,
            'mapel'   => $this->mapel,
            'jabatan' => $this->jabatan,
            'noHp'    => $this->no_hp,
            'email'   => $this->email,
        ];
    }
}
