<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pegawai;
use File;
use Excel;

class CloneController extends Controller
{
    public function clone(Request $request){
        $data_construct = "";

        $Connect = fsockopen($request->input('mesin_sumber'), "80");
        $soap_request="<GetUserInfo><ArgComKey Xsi:type=\"xsd:integer\">0</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetUserInfo>";
        $newLine="\r\n";
            
        fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
        fputs($Connect, "Content-Type: text/xml".$newLine);
        fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
        fputs($Connect, $soap_request.$newLine);
            
        $buffer="";
                
        while($Response=fgets($Connect)){
            $buffer=$buffer.$Response;
        }

        $data_dari = $this->getStringBetween($buffer,"<GetUserInfoResponse>","</GetUserInfoResponse>");
        $data_dari = explode("\r\n",$data_dari);
        $data_dari = array_slice($data_dari, 1, -1);

        foreach($data_dari as $no => $data){
            $Connect = fsockopen($request->input('mesin_tujuan'), "80");
            $soap_request="<SetUserInfo><ArgComKey Xsi:type=\"xsd:integer\">0</ArgComKey><Arg><PIN>".$this->getStringBetween($data,"<PIN>","</PIN>")."</PIN><Name>ABCDEF</Name><Password></Password><Group>1</Group><Privilege>0</Privilege><Card>".$this->getStringBetween($data,"<Card>","</Card>")."</Card><PIN2>".$this->getStringBetween($data,"<PIN2>","</PIN2>")."</PIN2><TZ1>0</TZ1><TZ2>0</TZ2><TZ3>0</TZ3></Arg></SetUserInfo>";
            $newLine="\r\n";
                    
            fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
            fputs($Connect, "Content-Type: text/xml".$newLine);
            fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
            fputs($Connect, $soap_request.$newLine);
                    
            $buffer="";
                        
            while($Response=fgets($Connect)){
                $buffer=$buffer.$Response;
            }

            print_r($buffer);
            echo"\r\n";
        }
    }

    public function compare(Request $request){
        $Connect = fsockopen($request->input('mesin_sumber'), "80");
        $soap_request="<GetUserInfo><ArgComKey Xsi:type=\"xsd:integer\">0</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetUserInfo>";
        $newLine="\r\n";
            
        fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
        fputs($Connect, "Content-Type: text/xml".$newLine);
        fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
        fputs($Connect, $soap_request.$newLine);
            
        $buffer="";
                
        while($Response=fgets($Connect)){
            $buffer=$buffer.$Response;
        }

        $data_dari = $this->getStringBetween($buffer,"<GetUserInfoResponse>","</GetUserInfoResponse>");
        $data_dari = explode("\r\n",$data_dari);

        foreach($data_dari as $key => $pin){
            $data_dari[$key]=$this->getStringBetween($pin,"<Card>","</Card>");
        }

        $Connect = fsockopen($request->input('mesin_tujuan'), "80");
        $soap_request="<GetUserInfo><ArgComKey Xsi:type=\"xsd:integer\">0</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetUserInfo>";
        $newLine="\r\n";
            
        fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
        fputs($Connect, "Content-Type: text/xml".$newLine);
        fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
        fputs($Connect, $soap_request.$newLine);
            
        $buffer="";
                
        while($Response=fgets($Connect)){
            $buffer=$buffer.$Response;
        }

        $data_tujuan = $this->getStringBetween($buffer,"<GetUserInfoResponse>","</GetUserInfoResponse>");
        $data_tujuan = explode("\r\n",$data_tujuan);

        foreach($data_tujuan as $key => $pin){
            $data_tujuan[$key]=$this->getStringBetween($pin,"<Card>","</Card>");
        }

        $diff = array_diff($data_dari,$data_tujuan);
        $diff2 = array_diff($data_tujuan, $data_dari);
        $get = array_merge($diff,$diff2);
        $pegawai = Pegawai::all()->toArray();

        return view('compare_table',['dari' => $diff,'tujuan' => $diff2,'pegawai' => $pegawai]);
    }

    public function get(Request $request){
        $Connect = fsockopen($request->input('mesin'), "80");
        $soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">0</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">".ltrim($request->input('npp'),'0')."</PIN></Arg></GetAttLog>";
        $newLine="\r\n";
            
        fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
        fputs($Connect, "Content-Type: text/xml".$newLine);
        fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
        fputs($Connect, $soap_request.$newLine);
            
        $buffer="";
                
        while($Response=fgets($Connect)){
            $buffer=$buffer.$Response;
        }

        $data = $this->getStringBetween($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
        $data = explode("\r\n",$data);

        $result = array();

        foreach($data as $key => $parse){
            $result[$key]['npp'] = $this->getStringBetween($parse,"<PIN>","</PIN>");
            $result[$key]['waktu'] = $this->getStringBetween($parse,"<DateTime>","</DateTime>");
        }

        $pegawai = Pegawai::where('npp',$request->input('npp'))->first();

        return view('attLogRes',['data' => $result,'nama'=>$pegawai]);
    }

    public function input_to_mesin(Request $request){
        $npp = $request->input("npp");
        $mesin = $request->input("mesin");

        $pegawai = Pegawai::where("npp",$npp)->first();

        $Connect = fsockopen($mesin, "80");
        $soap_request="<SetUserInfo><ArgComKey Xsi:type=\"xsd:integer\">0</ArgComKey><Arg><PIN>".$pegawai->npp."</PIN><Name>".$pegawai->nama."</Name><Card>".ltrim($pegawai->nomor_kartu, '0')."</Card></Arg></SetUserInfo>";
        $newLine="\r\n";
                    
        fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
        fputs($Connect, "Content-Type: text/xml".$newLine);
        fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
        fputs($Connect, $soap_request.$newLine);
                    
        $buffer="";
                        
        while($Response=fgets($Connect)){
            $buffer=$buffer.$Response;
        }
            
        $buffer = $this->getStringBetween($buffer,"<Information>","</Information>");

        return back();
    }

    public function act(Request $request){
        $npp = $request->input('npp');
        $mesin = $request->input('mesin');

        $Connect = fsockopen($mesin, "80");
        $soap_request="<GetUserInfo><ArgComKey Xsi:type=\"xsd:integer\">0</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">".$npp."</PIN></Arg></GetUserInfo>";
        $newLine="\r\n";
            
        fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
        fputs($Connect, "Content-Type: text/xml".$newLine);
        fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
        fputs($Connect, $soap_request.$newLine);
            
        $buffer="";
                
        while($Response=fgets($Connect)){
            $buffer=$buffer.$Response;
        }

        $group = $this->getStringBetween($buffer,"<Group>","</Group>");
        if($group == 1){
            $Connect = fsockopen($mesin, "80");
            $soap_request="<SetUserInfo><ArgComKey Xsi:type=\"xsd:integer\">0</ArgComKey><Arg><PIN>".$npp."</PIN><Group>9</Group></Arg></SetUserInfo>";
            $newLine="\r\n";
                    
            fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
            fputs($Connect, "Content-Type: text/xml".$newLine);
            fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
            fputs($Connect, $soap_request.$newLine);
                    
            $buffer="";
                        
            while($Response=fgets($Connect)){
                $buffer=$buffer.$Response;
            }
            
            $buffer = $this->getStringBetween($buffer,"<Information>","</Information>");
            print_r($buffer);
        }else{
            $Connect = fsockopen($mesin, "80");
            $soap_request="<SetUserInfo><ArgComKey Xsi:type=\"xsd:integer\">0</ArgComKey><Arg><PIN>".$npp."</PIN><Group>1</Group></Arg></SetUserInfo>";
            $newLine="\r\n";
                    
            fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
            fputs($Connect, "Content-Type: text/xml".$newLine);
            fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
            fputs($Connect, $soap_request.$newLine);
                    
            $buffer="";
                        
            while($Response=fgets($Connect)){
                $buffer=$buffer.$Response;
            }
            
            $buffer = $this->getStringBetween($buffer,"<Information>","</Information>");
            print_r($buffer);
        }

        return back();
    }

    public function input_to_db(Request $request){
        $npp = $request->input("npp");
        $nama = $request->input("nama");
        $kartu = $request->input("kartu");
        $divisi = $request->input("divisi");

        $pegawai = new Pegawai();
        $pegawai->npp = $npp;
        $pegawai->nama = $nama;
        $pegawai->nomor_kartu = $kartu;
        $pegawai->divisi = $divisi;

        $pegawai->save();
        return back();
    }

    public function import_pegawai_to_db(Request $request){
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
                echo"Failed!\r\n";
            }
        }
    }

    public function import_kartu_to_db(Request $request){
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
                echo"Failed!\r\n";
            }
        }
    }

    private function getStringBetween($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
