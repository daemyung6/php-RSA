function encrypt(key, str) {
    const crypt = new JSEncrypt();
    crypt.setPrivateKey(key);
    var encryptedText = crypt.encrypt(str);
    return encryptedText;
}
function sendData(data) {
    let dataArr = [];
    let cutPoint = 0;
    const cutLength = 80;

    for (cutPoint = 0; cutPoint < Math.floor(data.length / cutLength); cutPoint++) {
        dataArr.push(data.substr(cutPoint * cutLength, cutLength));
    }
    dataArr.push(data.substr(cutPoint * cutLength, cutLength));

    fetch("./getKey.php", {
        method : "GET"
    })
    .then(json => json.json())
    .then(json => {
        console.log(json);
        if(json.public_key === false) {
            alert("public_key err");
            return;
        }
        let encryptedDataArr = [];
        for (let i = 0; i < dataArr.length; i++) {
            if(dataArr[i] === "") {continue}
            encryptedDataArr[i] = encrypt(json.public_key, dataArr[i]);
        }
        console.log("encryptedDataArr");
        console.log(encryptedDataArr);

        let formdata = new FormData();
        formdata.append('data', JSON.stringify(encryptedDataArr));

        return fetch("./submit.php", {
            method : "POST",
            body : formdata
        })
    })
    .then(json => json.json())
    .then(json => console.log(json))
    .catch(err => {
        alert(err);
    })
}

window.addEventListener("DOMContentLoaded", function() {
    const inputEl = document.getElementById("input");
    const bt = document.getElementById("sendBt");

    bt.onclick = function() {
        sendData(inputEl.value);
    }
});