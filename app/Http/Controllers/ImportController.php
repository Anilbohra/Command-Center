<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportController extends Controller
{
    
    public function unggah_pegawai_ke_db(Request $request){
        $response = array();
        $insert = array();
        $path = $request->file('pegawai')->path();
        $data = Excel::load($path, function($reader){})->get();
        foreach($data as $item){
            $insert[] = ['npp'=>$item->npp,'nama'=>$item->nama_lengkap,'divisi'=>$item->kode_unit];
        }

        foreach($insert as $data){
            if(!$data['divisi']){
                $data['divisi'] = 0;
            }
            $pegawai = new Pegawai();
            $pegawai->npp = $data['npp'];
            $pegawai->nama = $data['nama'];
            $pegawai->divisi = $data['divisi'];
            if($pegawai->save()){
                echo"Success!\r\n";
            }else{
                echo"gagaled!\r\n";
            }
        }
    }

    public function unggah_kartu_ke_db(Request $request){
        $response = array();
        $insert = array();
        $path = $request->file('pegawai')->path();
        $data = Excel::load($path, function($reader){})->get();
        foreach($data as $item){
            $insert[] = ['npp'=>$item->npp,'nomor_kartu'=>$item->nomor_kartu];
        }

        foreach($insert as $data){
            $pegawai = Pegawai::where('npp',$data['npp'])->first();
            $pegawai->nomor_kartu = $data['nomor_kartu'];
            if($pegawai->save()){
                echo"Success!\r\n";
            }else{
                echo"gagaled!\r\n";
            }
        }
    }
}
