<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = ['npp','nama','divisi','nomor_kartu','imported'];
    protected $table = 'pegawai';

    public function divisi(){
        return $this->hasOne('App\Divisi');
    }
}
