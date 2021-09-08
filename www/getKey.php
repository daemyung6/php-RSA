<?php
    header("Content-Type:application/json");
    $data = array();

    $public_key = file_get_contents('../key/public_key.pem');

    $data["public_key"] = $public_key;
    $json = json_encode($data, JSON_UNESCAPED_UNICODE);
    echo $json;
    die;
?>