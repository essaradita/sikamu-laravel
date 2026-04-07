<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens;

    protected $table = 'tb_users';
    public $timestamps = false;
    protected $fillable = ['username','password','name','role'];
    protected $hidden   = ['password'];
}
