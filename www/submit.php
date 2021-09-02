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

        $inputStr = base64_decode($_POST["data"]);

        $privateKey = file_get_contents('../key/private.key');
        $decrypted = null;
        
        openssl_private_decrypt($inputStr, $decrypted, $privateKey, OPENSSL_PKCS1_PADDING);

        $data["success"] = true;
        $data["decrypted"] = $decrypted;
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        echo $json;
        die;
    }
    returnError(true);
?>