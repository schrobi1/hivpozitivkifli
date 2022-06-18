document.querySelector(".cikkkeszito .publikal").onclick = function(evt){
    evt.preventDefault();
    sendReqest({type: 7, Newname: document.getElementById("cikkname").value,topicName: document.querySelector('input[name="tema"]:checked').value, ShortPost: document.getElementById("Eloszo").value,Post: document.getElementById("Cikktext").value}, UploadCallback);
}

function UploadCallback(Data) {
    var dataArray = JSON.parse(Data);
    if (dataArray.error) {
        alert(dataArray.data);
        
    } else {
        alert(dataArray.data);
        location.reload();
    }
}