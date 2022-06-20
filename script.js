function ShowLoginForm() {
    $('#LoginForm').modal('show');
    document.getElementById("ShowRegForm").onclick = function (evt) {evt.preventDefault();$('#LoginForm').modal('hide');$('#RegForm').modal('show');};
    document.getElementById("LogButton").onclick = function () {Login();};
    document.getElementById("RegButton").onclick = function () {Reg();};
}

function Login () {
    document.getElementById("LogButton").disabled = true;
    document.getElementById("LogButton").innerHTML = "<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>  Bejelentkezés...";
    sendRequest({type: 0, Email: document.getElementById("EmailInput").value, Password: document.getElementById("JelszoInput").value}, LoginCallback);
}

function LoginCallback(Data) {
    var dataArray = JSON.parse(Data);
    if (dataArray.error) {
        document.getElementById("LoginErrorPlaceholder").innerHTML = '<div class="alert alert-danger alert-dismissible m-3" role="alert">' + dataArray.data + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        document.getElementById("LogButton").disabled = false;
        document.getElementById("LogButton").innerHTML = "Bejelentkezés";
    } else {
        location.reload();
    }
        
}

function logOut() {
    sendRequest({type: 1}, function(Data) {location.reload();});
}

function Reg() {
    if (document.getElementById("JelszoRInput").value != document.getElementById("JelszoCoInput").value) {
        document.getElementById("RegErrorPlaceholder").innerHTML = '<div class="alert alert-danger alert-dismissible m-3" role="alert">A két jelszó nem egyezik!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        return;
    }
    if (!document.getElementById("EULACheck").checked) {
        document.getElementById("RegErrorPlaceholder").innerHTML = '<div class="alert alert-danger alert-dismissible m-3" role="alert">El kell fogadni az EULA-t<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        return;
    }
    document.getElementById("RegButton").disabled = true;
    document.getElementById("RegButton").innerHTML = "<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>  Regisztrálás...";
    sendRequest({type: 2, Username: document.getElementById("UserInput").value,Email: document.getElementById("EmailRInput").value, Password: document.getElementById("JelszoRInput").value}, RegCallback);
}

function RegCallback(Data) {
    var dataArray = JSON.parse(Data);
    if (dataArray.error) {
        document.getElementById("RegErrorPlaceholder").innerHTML = '<div class="alert alert-danger alert-dismissible m-3" role="alert">' + dataArray.data + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        document.getElementById("RegButton").disabled = false;
        document.getElementById("RegButton").innerHTML = "Regisztrálás";
    } else {
        document.getElementById("RegErrorPlaceholder").innerHTML = '<div class="alert alert-success alert-dismissible m-3" role="alert">Sikeres regisztráció<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        document.getElementById("RegButton").innerHTML = "Regisztrálás";
    }
}

function ShowNews(Id) {
    document.getElementById("News").innerHTML = "";
    document.getElementById("NewsDetails").innerHTML = "";
    document.getElementById("NewsPopupLabel").innerHTML = "Betöltés...";
    document.getElementById("Comments").innerHTML = "";
    if (document.getElementById("SendComment") != null) {
        document.getElementById("SendComment").onclick = function () {SendComment(Id)};
    }
    
    
    $('#NewsPopup').modal('show');
    sendRequest({type: 3, id: Id}, NewsCallback);
    sendRequest({type: 10, id: Id}, NewsCommentCallback);
}

function NewsCommentCallback(Data) {
    var dataArray = JSON.parse(Data);
    if (dataArray.error) {
        alert("Error: Kommentek nem tölthetőek be!");
    } else {
        var html = "";
        var Counter = 0;

        dataArray.data.forEach(Comment => {
            Counter++;
            html += '<div class="card border-secondary mb-3"><div class="card-header">Komment #' + Counter + '</div><div class="card-body text-secondary"><h5 class="card-title">' + Comment.username + '</h5><p class="card-text">' + Comment.txt + '</p></div></div>'
        });

        document.getElementById("Comments").innerHTML = html;
    }
}

function NewsCallback(Data) {
    var dataArray = JSON.parse(Data);
    if (dataArray.error) {
        alert("Error: Hír nem található!");
    } else {
        document.getElementById("News").innerHTML = dataArray.data.Post;
        document.getElementById("NewsPopupLabel").innerHTML = dataArray.data.newsName;
        document.getElementById("NewsDetails").innerHTML = "Írta: " + dataArray.data.pubname + " (" + dataArray.data.topicName + ") " + IsoDateToString(dataArray.data.datum,false);
    }
}

function showSettingsForm() {
    document.getElementById("ChUsername").value = "";
    document.getElementById("ChPass1").value = "";
    document.getElementById("ChPass2").value = "";
    if (document.getElementById("ChPName") != null) {
        document.getElementById("ChPName").value = "";
    }


    document.getElementById("ChangeUSername").onclick = function () {ChangeUsername();};
    document.getElementById("ChangePassword").onclick = function () {ChangePassword();};
    if (document.getElementById("ChangePName") != null) {
        document.getElementById("ChangePName").onclick = function () {ChangePName();};
    }
    
    $('#SettingaForm').modal('show');

    sendRequest({type: 8}, SettingsCallback);
}

function ChangeUsername() {
    document.getElementById("ChangeUSername").disabled = true
    document.getElementById("ChangeUSername").innerHTML = "<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>  Módosítás...";

    sendRequest({type: 4, Username: document.getElementById("ChUsername").value}, SettingsChangeCallback);
}

function ChangePassword() {
    if (document.getElementById("ChPass1").value != document.getElementById("ChPass2").value) {
        document.getElementById("ChangeErrorPlaceholder").innerHTML = '<div class="alert alert-danger alert-dismissible m-3" role="alert">A két jelszó nem egyezik<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        return;
    }

    document.getElementById("ChangePassword").disabled = true
    document.getElementById("ChangePassword").innerHTML = "<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>  Módosítás...";

    sendRequest({type: 5, Password: document.getElementById("ChPass1").value}, SettingsChangeCallback);
}

function ChangePName() {
    document.getElementById("ChangePName").disabled = true
    document.getElementById("ChangePName").innerHTML = "<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>  Módosítás...";

    sendRequest({type: 6, Pubname: document.getElementById("ChPName").value}, SettingsChangeCallback);
}

function SettingsChangeCallback(Data) {
    document.getElementById("ChangeUSername").disabled = false;
    document.getElementById("ChangePassword").disabled = false;
    if (document.getElementById("ChangePName") != null) {
        document.getElementById("ChangePName").disabled = false;
    }
    

    document.getElementById("ChangeUSername").innerHTML = "Módosít";
    document.getElementById("ChangePassword").innerHTML = "Módosít";
    if (document.getElementById("ChangePName") != null) {
        document.getElementById("ChangePName").innerHTML = "Módosít";
    }

    var dataArray = JSON.parse(Data);
    if (dataArray.error) {
        document.getElementById("ChangeErrorPlaceholder").innerHTML = '<div class="alert alert-danger alert-dismissible m-3" role="alert">' + dataArray.data + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    } else {
        document.getElementById("ChangeErrorPlaceholder").innerHTML = '<div class="alert alert-success alert-dismissible m-3" role="alert">Sikeres módosítás<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
}

function SettingsCallback(Data) {
    var dataArray = JSON.parse(Data);
    if (dataArray.error) {
        document.getElementById("ChangeErrorPlaceholder").innerHTML = '<div class="alert alert-danger alert-dismissible m-3" role="alert">' + dataArray.data + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    } else {
        document.getElementById("ChUsername").value = dataArray.data.Username;
        if (document.getElementById("ChPName") != null) {
            document.getElementById("ChPName").value = dataArray.data.PName;
        }
    }
}

var CurrentNewsId = -1;

function SendComment(Id) {
    document.getElementById("SendComment").disabled = true;
    document.getElementById("SendComment").innerHTML = "<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>  Közzététel...";
    CurrentNewsId = Id;
    sendRequest({type: 9, NewsId: Id,Comment: document.getElementById("CommentInput").value}, SendCommentCallback);
}

function SendCommentCallback(Data) {
    var dataArray = JSON.parse(Data);
    if (dataArray.error) {
        alert("Error: " + dataArray.data)
    } else {
        document.getElementById("SendComment").disabled = false;
        document.getElementById("SendComment").innerHTML = "Küldés";
        document.getElementById("CommentInput").value = "";
        ShowNews(CurrentNewsId);
    }
}

function NewArticle() {
    $('#NewsWrite').modal('show');

    document.getElementById("NewArticleSave").onclick = function () {SaveArticle();};

    document.getElementById("NewsTitleInput").value = "";
    document.getElementById("NewsInput").value = "";
    document.getElementById("NewsShortInput").value = "";
}

function SaveArticle() {
    document.getElementById("NewArticleSave").disabled = true;
    document.getElementById("SendComment").innerHTML = "<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>  Közzététel...";
    sendRequest({type: 7, Newname: document.getElementById("NewsTitleInput").value,topicName: document.getElementById("NewsCategoryInput").value,ShortPost: document.getElementById("NewsShortInput").value, Post: document.getElementById("NewsInput").value}, SaveArticleCallback);
}

function SaveArticleCallback(Data) {
    document.getElementById("NewArticleSave").disabled = false;
    document.getElementById("SendComment").innerHTML = "Mentés";

    var dataArray = JSON.parse(Data);
    if (dataArray.error) {
        document.getElementById("SendErrorPlaceholder").innerHTML = '<div class="alert alert-danger alert-dismissible m-3" role="alert">' + dataArray.data + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    } else {
        location.reload();
    }
}

function showUsers() {
    $('#UsersForm').modal('show');
    document.getElementById("UsersTable").innerHTML = "<tr><td>Betöltés...</td></tr>";
    sendRequest({type: 11}, UsersCallback);
}

function UsersCallback(Data) {
    var dataArray = JSON.parse(Data);
    if (dataArray.error) {
        alert(dataArray.data)
    } else {
        var Table = document.getElementById("UsersTable");

        var rowCount = Table.rows.length;
        for (var k = 0; k < rowCount; k++) {
            Table.deleteRow(0);
        }

        var row = Table.insertRow(0);
        var HeaderElements = ["Felhasználónév", "Email", "Jogosultság", ""];
        HeaderElements.forEach(function(Name) {
            var headerCell = document.createElement("TH");
            headerCell.innerHTML = Name;
            row.appendChild(headerCell);
        });

        for(var i = 0; i < dataArray.data.length; i++) {
            var row = Table.insertRow(i+1);
            
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);

            cell1.innerHTML = dataArray.data[i].username;
            cell2.innerHTML = dataArray.data[i].email;
            cell3.innerHTML = dataArray.data[i].level == 0 ? "Normál" : "Admin";
            cell4.innerHTML = "<button type=\"button\" class=\"btn btn-primary btn-sm\" onclick=\"SetPermissionLevel(" + dataArray.data[i].id + ", " + dataArray.data[i].level +")\">Admin/felhasználó</button>";
            
            cell4.style.textAlign = "center";
            cell4.style.width = '50px';
        }
    }
}

function SetPermissionLevel(Id, Level) {
    sendRequest({type: 12, Level: Level == 0 ? 1:0, UserId: Id}, SetPermissionCallback);
}

function SetPermissionCallback(Data) {
    var dataArray = JSON.parse(Data);
    if (dataArray.error) {
        alert(dataArray.data);
    } else {
        alert(dataArray.data);
    }
    sendRequest({type: 11}, UsersCallback);
}






function IsoDateToString(IsoDate, Time = true) {
    var date = new Date(IsoDate);
    var Month = date.getMonth()+1;
    var DateDay = date.getDate();
    var Hours = date.getHours();
    var Minutes = date.getMinutes();

    if (Month < 10) {
        Month = "0" + Month;
    }

    if (DateDay < 10) {
        DateDay = "0" + DateDay;
    }

    if (Hours < 10) {
        Hours = "0" + Hours;
    }

    if (Minutes < 10) {
        Minutes = "0" + Minutes;
    }

    var dateString;

    if (Time) {
        dateString = date.getFullYear()+'. ' + Month + '. '+ DateDay + ". " + Hours + ":" + Minutes;
    } else {
        dateString = date.getFullYear()+'. ' + Month + '. '+ DateDay + ".";
    }
    
    return dateString
}

function sendRequest(Data, Callback) {
    var RequestData = new FormData();

    for (var DataElementKey in Data) {
        RequestData.append(DataElementKey, Data[DataElementKey]);
    }

    $.ajax({
		url: '',
		type: 'POST',               
		data: function(){ 														
			return RequestData;
		}(),
		success: function (data) {
			Callback(data);
		},
		error: function (data) {
			alert("Szerver error");
		},
		complete: function () {                 

		},
		cache: false,
		contentType: false,
		processData: false
	});
}