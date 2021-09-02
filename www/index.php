<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <input id="input" type="text"><br />
    <button id="sendBt">send</button>
</body>
<script type="text/javascript" src="./jsencrypt.min.js"></script>
<script>
    <?php 
        $public_key = file_get_contents('../key/public_key.pem');
        echo "const public_key = `$public_key`;"
    ?>

    window.addEventListener("DOMContentLoaded", function() {
        const inputEl = document.getElementById("input");
        const bt = document.getElementById("sendBt");

        bt.onclick = function() {
            var crypt = new JSEncrypt();

            crypt.setPrivateKey(public_key);
            var plainText = inputEl.value
            var encryptedText = crypt.encrypt(plainText);
            console.log(encryptedText);

            let formdata = new FormData();
            formdata.append('data', encryptedText);

            fetch("./submit.php", {
                method : "POST",
                body : formdata
            })
            .then(json => json.json())
            .then(json => {
                console.log(json);
            })
            .catch(err => {
                console.log(err);
            })
        }
    });
</script>
</html>