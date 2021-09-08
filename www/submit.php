<?php
    header("Content-Type:application/json");
    $data = array();
    
    function returnError($msg) {
        $data["error"] = $msg;
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        echo $json;
        die;
    }

    if(isset($_POST) and $_SERVER["REQUEST_METHOD"] == "POST") {
        if(!isset($_POST["data"])) {
            returnError("잘못된 쿼리 입니다.");
        }
        $privateKey = file_get_contents('../key/private.key');

        $json = json_decode($_POST["data"], true);
        $decrypted_json_str = "";
        
        for ($i=0; $i < count($json); $i++) { 
            $inputStr = base64_decode($json[$i]);
            $decrypted = null;
            openssl_private_decrypt($inputStr, $decrypted, $privateKey, OPENSSL_PKCS1_PADDING);
            $decrypted_json_str .= $decrypted;
        }

        $data["success"] = true;
        $data["decrypted"] = $decrypted_json_str;
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        echo $json;
        die;
    }
    returnError(true);
?>