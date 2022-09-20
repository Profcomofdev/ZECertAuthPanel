<?php

namespace zengine\base;

use Jajo\JSONDB;

abstract class Openssl{

    public $path = OPENSSL;

    public function __construct(){
        
    }

    public function execute($function){
        $info = exec($function, $output, $result);
        if (!$result){
            return [0, $output];
        }else{
            return [1,'Error executing command!']; 
        }
    }

    public function parseCnf(){
        $myfile = file_get_contents(OPENSSL . '/openssl.cnf');
        $pcnf = explode('[ req_distinguished_name ]', $myfile);
        $pcnf_r = explode('[ req_attributes ]', $pcnf[1])[0];
        $cfg = [];
        $arr = explode("\n", $pcnf_r);
        foreach ($arr as $r){
            if ((count(explode('=', $r)) > 1)  and !(count(explode('#', $r)) > 1)){
                $cfg[str_replace("\t", '',str_replace('.','_',explode('=', $r)[0]))] = trim(explode('=', $r)[1]);
            }
        }
        return $cfg;
    }

    public function createReq($hostname, $username, $days='', $type=''){
        $json_db = new JSONDB(APP . '/db');
        if (is_file(OPENSSL . '/csr/'.$hostname.'.csr')){
            return [1, 'Cannot create such request, because csr already exists'];
        }else{
            $key_path = OPENSSL . '/key/' . $hostname . '.key';
            $csr_path = OPENSSL . '/csr/' . $hostname . '.csr';
            $key_result = $this->execute('openssl genrsa -out "' . $key_path . '" 2048 && echo Success');
            $config = $this->parseCnf();
            if ($key_result[0] == 0){
                $csr_result = $this->execute('openssl req -new -key ' . $key_path . '  -out ' . $csr_path . ' -subj "/C='.$config["countryName_default"].'/ST='.$config["stateOrProvinceName_default"].'/L='.$config["localityName"].'/O='.$config["0_organizationName_default"].'/OU='.$config["organizationalUnitName_default"].'/CN='.$hostname.'/emailAddress='.EMAIL.'" && echo "Success"');
                if ($csr_result[0] == 0){
                    $json_db->insert( 'certificates.json', 
                        [ 
                            'hostname' => $hostname, 
                            'csr' => $csr_path, 
                            'key' => $key_path,
                            'crt' => '',
                            'user' => $username,
                        ]
                    );
                    return [0, 'Successfully created certificate request'];
                }else{
                    return $csr_result;
                }
            }else{
                return $key_result;
            }
        }
    }

    public function genCrt($hostname){
        $json_db = new JSONDB(APP . '/db');
        $key_path = OPENSSL . '/key/' . $hostname . '.key';
        $csr_path = OPENSSL . '/csr/' . $hostname . '.csr';
        $crt_path = OPENSSL . '/crt/' . $hostname . '.crt';
        $cnf = OPENSSL . '/openssl.cnf';
		file_put_contents(OPENSSL . '/extfile.cnf', 'subjectAltName=DNS:'.$hostname);
        $try = $this->execute('openssl ca -in "' . $csr_path . '"' . ' -out "' . $crt_path . '" --config="' . $cnf . '" -extfile ' . OPENSSL . '/extfile.cnf --batch && echo Success');
        if ($try[0] == 0){
            $json_db->update( [ 'crt' => $crt_path ] )
            ->from( 'certificates.json' )
            ->where( [ 'hostname' => $hostname ] )
            ->trigger();
            return [0, 'Successfully issued certificate'];
        }else{
            return $try;
        }
    }

    public function renewCrt($hostname, $username){
        $json_db = new JSONDB(APP . '/db');
        $key_path = OPENSSL . '/key/' . $hostname . '.key';
        $csr_path = OPENSSL . '/csr/' . $hostname . '.csr';
        $crt_path = OPENSSL . '/crt/' . $hostname . '.crt';
        $cnf = OPENSSL . '/openssl.cnf';
        $this->removeFromIndex($hostname);
        $json_db->delete()
        ->from( 'certificates.json' )
        ->where( [ 'hostname' => $hostname ] )
        ->trigger();
        try{
            unlink($key_path);
        }catch (Exception $ex){
            debug($ex);
        }
        try{
            unlink($csr_path);
        }catch (Exception $ex){
            debug($ex);
        }
        try{
            unlink($crt_path);
        }catch (Exception $ex){
            debug($ex);
        }
        $rresult = $this->createReq($hostname, $username);
        $cresult = $this->genCrt($hostname);
        if ($rresult[0] == 0){
            if ($cresult[0] == 0){
                return [0, 'Successfully renewes certificate'];
            }else{
                return $cresult;
            }
        }else{
            return $rresult;
        }
    }

    public function removeHostCertificate($hostname){
        $json_db = new JSONDB(APP . '/db');
        $key_path = OPENSSL . '/key/' . $hostname . '.key';
        $csr_path = OPENSSL . '/csr/' . $hostname . '.csr';
        $crt_path = OPENSSL . '/crt/' . $hostname . '.crt';
        $cnf = OPENSSL . '/openssl.cnf';
        $this->removeFromIndex($hostname);
        $json_db->delete()
        ->from( 'certificates.json' )
        ->where( [ 'hostname' => $hostname ] )
        ->trigger();
        try{
            unlink($key_path);
        }catch (Exception $ex){
            debug($ex);
        }
        try{
            unlink($csr_path);
        }catch (Exception $ex){
            debug($ex);
        }
        try{
            unlink($crt_path);
        }catch (Exception $ex){
            debug($ex);
        }
        return 'Successfully deleted certificate';
    }

    public function removeFromIndex($hostname){
        $index_path = OPENSSL . '/index.txt';
        $index = file_get_contents($index_path);
        $new_index = "";
        foreach (explode("\n", $index) as $i){
            if (!count(explode($hostname, $i)) > 1){
                $new_index .= $i . "\n";
            }
        }
        file_put_contents($index_path, $new_index);
    }

    public function getCrtInfo($hostname){
        $crt_path = OPENSSL . '/crt/' . $hostname . '.crt';
        $try = $this->execute('openssl x509 -in "' . $crt_path . '" -noout -text');
        return $try;
    }

    public function getAllIndex(){
        $index_path = OPENSSL . '/index.txt';
        $index = file_get_contents($index_path);
        return file_get_contents($index);
    }

    public function getAllDatabase(){
        $json_db = new JSONDB(APP . '/db');
        $certificates = $json_db->select( '*' )
        ->from( 'certificates.json' )
        ->get();
        return $certificates;
    }

    public function getAllUDatabase($username){
        $json_db = new JSONDB(APP . '/db');
        $certificates = $json_db->select( '*' )
        ->from( 'certificates.json' )
        ->where( [ 'user' => $username ] )
        ->get();
        return $certificates;
    }

    public function getCertFiles($hostname, $type){
        if ($type == 'crt'){
            return file_get_contents(OPENSSL . '/crt/' . $hostname . '.crt');
        }
        if ($type == 'key'){
            return file_get_contents(OPENSSL . '/key/' . $hostname . '.key');
        }
        if ($type == 'csr'){
            return file_get_contents(OPENSSL . '/csr/' . $hostname . '.csr');
        }
    } 

}
