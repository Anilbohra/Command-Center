<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

trait SDK{
    private function koneksi_ke_mesin($ip,$command,$arg){
        if(empty($command) || empty($ip) || empty($arg)){return false;}
        switch($command){
            case "clearLogKehadiran":
                $command = "ClearData";
                $response = "Information";
                $array = false;
            break;

            case "getLogKehadiran":
                $command = "GetAttLog";
                $response = $command."Response";
                $array = true;
            break;

            case "addUser":
                $command = "SetUserInfo";
                $response = "Information";
                $array = false;
            break;

            case "deleteUser":
                $command = "DeleteUser";
                $response = "Information";
                $array = false;
            break;

            case "getUserInfo":
                $command = "GetUserInfo";
                $response = $command."Response";
                $array = true;
            break;
        }

        $Connect = fsockopen($ip, "80");
        $soap_request="<".$command."><ArgComKey Xsi:type=\"xsd:integer\">0</ArgComKey><Arg>".$arg."</Arg></".$command.">";
        $newLine="\r\n";
            
        fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
        fputs($Connect, "Content-Type: text/xml".$newLine);
        fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
        fputs($Connect, $soap_request.$newLine);
            
        $buffer="";
                
        while($Response=fgets($Connect)){
            $buffer=$buffer.$Response;
        }

        $response = $this->getStringBetween($buffer,"<".$result.">","</".$result.">");
        if($array){
            $response = explode($newLine,$response);
            $response = array_slice($response,1,-1);
        }

        return $response;
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