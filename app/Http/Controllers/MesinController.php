<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MesinController extends Controller
{
    public function clone(Request $request){
        $mesin_sumber = $request->input('mesin_sumber');
        $mesin_tujuan = $request->input('mesin_tujuan');

        $user = $this->koneksi_ke_mesin($mesin_sumber,"getUserInfo","<PIN>All</PIN>");
        $success = 0;
        $gagal = array();
        $total = count($user);
        foreach($user as $data){
            $x = $this->getStringBetween($data,"<PIN2>","</PIN2>");
            $argumen = $this->getStringBetween($data,"<Row>","</Row>");
            $status = $this->koneksi_ke_mesin($mesin_tujuan,"addUser",$argumen);
            if($status == "Succesfully!"){
                $sukses = $sukses+1;
            }else{
                $gagal[$x]['npp'] = $this->getStringBetween($data,"<PIN>","</PIN>");
                $gagal[$x]['nama'] = $this->getStringBetween($data,"<Name>","</Name>");
                $gagal[$x]['nomor_kartu'] = $this->getStringBetween($data,"<Card>","</Card>");
            }
        }

        return view('status',['act' => 'cloneMesin', 'sukses' => $sukses, 'gagal' => $gagal, 'total' => $total]);
    }

    public function compare(Request $request){
        $mesin_sumber = $request->input('mesin_sumber');
        $mesin_tujuan = $request->input('mesin_tujuan');

        $data_mesin_sumber = $this->koneksi_ke_mesin($mesin_sumber,"getUserInfo","<PIN>All</PIN>");
        $data_mesin_tujuan = $this->koneksi_ke_mesin($mesin_tujuan,"getUserInfo","<PIN>All</PIN>");

        $data_sumber = array();
        foreach($data_mesin_sumber as $data){
            $data_sumber[$this->getStringBetween($data,"<PIN></PIN>")] = $this->getStringBetween($data,"<Card></Card>");
        }

        $data_tujuan = array();
        foreach($data_mesin_tujuan as $data){
            $data_tujuan[$this->getStringBetween($data,"<PIN></PIN>")] = $this->getStringBetween($data,"<Card></Card>");
        }

        $pada_mesin_sumber = array_diff($data_sumber,$data_tujuan);
        $pada_mesin_tujuan = array_diff($data_tujuan,$data_sumber);

        return view('status',['act' => 'compare', 'pada_mesin_sumber' => $pada_mesin_sumber, 'pada_mesin_tujuan' => $pada_mesin_tujuan]);
    }

    public function clearUser(Request $request){
        $mesin = $request->input('mesin');
        $user = $this->koneksi_ke_mesin($mesin,'getUserInfo','<PIN>All</PIN>');
        
        $sukses = 0;
        $gagal = array();
        $total = count($user);
        foreach($user as $data){
            $x = $this->getStringBetween($data,'<PIN2>','</PIN2>');
            $status = $this->koneksi_ke_mesin($mesin,'deleteUser','<PIN>'.$this->getStringBetween($data,'<PIN>','</PIN>').'</PIN>');
            if($status == "Succesfully!"){
                $sukses = $sukses + 1;
            }else{
                $gagal[$x]['npp'] = $this->getStringBetween($data,'<PIN>','</PIN>');
                $gagal[$x]['nama'] = $this->getStringBetween($data,'<Name>','</Name>');
                $gagal[$x]['nomor_kartu'] = $this->getStringBetween($data,'<Card>','</Card>');
            }
        }

        return view('status',['act' => 'clearUser', 'sukes' => $sukses, 'gagal' => $gagal, 'total' => $total]);
    }

    public function deleteUser(Request $request){
        $npp = ltrim($request->input('npp'),0);
        $mesin = $request->input('mesin');

        $status = $this->koneksi_ke_mesin($mesin,"deleteUser","<PIN>".$npp."</PIN>");
        if($status == "Succesfully!"){
            return view('status',['act' => 'deleteUser', 'success' => true]);
        }else{
            return view('status',['act' => 'deleteUser', 'success' => false]);
        }
    }

    public function addUser(Request $request){
        $pegawai = Pegawai::Where('npp',$request->input('npp'))->first();
        $mesin = $request->input('mesin');

        $argumen = "<PIN>".$pegawai->npp."</PIN><Name>".$pegawai->nama."</Name><Card>".$pegawai->nomor_kartu."</Card>";
        $status = $this->koneksi_ke_mesin($mesin,"addUser",$argumen);
        if($status == "Succesfully!"){
            return view('status',['act' => 'addUser', 'success' => true]);
        }else{
            return view('status',['act' => 'addUser', 'success' => false]);
        }
    }

    public function getLogKehadiran(Request $request){
        $mesin = $request->input('mesin');
        $result = $this->koneksi_ke_mesin($mesin,'getLogKehadiran','<PIN>All</PIN>');
        $response = array();
        foreach($result as $data){
            $response[$this->getStringBetween($data,"<PIN2>","</PIN2>")]['npp'] = $this->getStringBetween($data,"<PIN>","</PIN>");
            $response[$this->getStringBetween($data,"<PIN2>","</PIN2>")]['nama'] = $this->getStringBetween($data,"<Name>","</Name>");
            $response[$this->getStringBetween($data,"<PIN2>","</PIN2>")]['nomor_kartu'] = $this->getStringBetween($data,"<Card>","</Card>");
            $response[$this->getStringBetween($data,"<PIN2>","</PIN2>")]['waktu'] = $this->getStringBetween($data,"<DateTime>","</DateTime>");
        }

        return view('status',['act' => 'getLogKehadiran', 'response' => $response]);
    }
}
