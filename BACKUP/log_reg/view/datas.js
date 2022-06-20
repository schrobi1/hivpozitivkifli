document.querySelector(".adatmodositas .namechange").onclick = function(evt){
    evt.preventDefault();
    sendReqest({type: 4, Username: document.getElementById("newname").value}, ChangeCallback);
}

document.querySelector(".adatmodositas .passwdchange").onclick = function(evt){
    evt.preventDefault();
    sendReqest({type: 5, Password: document.getElementById("newpasswd").value}, ChangeCallback);
}

document.querySelector(".adatmodositas .pubnamechange").onclick = function(evt){
    evt.preventDefault();
    sendReqest({type: 6, Pubname: document.getElementById("newpubname").value}, ChangeCallback);
}

function ChangeCallback(Data) {
    var dataArray = JSON.parse(Data);
    if (dataArray.error) {
        alert(dataArray.data);
        
    } else {
        alert(dataArray.data);
        location.reload();
    }
}