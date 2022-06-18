
var ns = new News();
var lv = new LoginView();
login();

/*lv.addCikk(cikk =>
    {
      aM.add(cikk);  
    })*/
//var cikk = aM.getCikk();
//ns.beolvas(cikk);
hirek();

if (document.getElementById("logoutButton") != null) {
    document.getElementById("logoutButton").onclick = function(evt){
        evt.preventDefault();
        sendReqest({type: 1}, (Data) => { location.reload();});
    }
}

function login(){
    var login = document.querySelector('.btn');

    login.onclick = function(evt){
     evt.preventDefault();
     lv.felulet(LoginClick);

     register();
     close();
   }
   
   
}

/*function logout(){
    var logout = document.querySelector('.logout');

    logout.onclick = function(evt){
     evt.preventDefault();
     sendReqest({type:1})
   }
   
   
}*/

function LoginClick() {
    var email = document.querySelector('#Username').value;
    var password = document.querySelector('#password').value;

    sendReqest({type: 0, Email: email, Password: password}, LoginCallback);
}

function LoginCallback(Data) {
    var dataArray = JSON.parse(Data);
    if (dataArray.error) {
        alert(dataArray.data);
    } else {
        location.reload();
    }
        
}

function registerClick(){
    var username = document.querySelector('#rusername').value;
    var password = document.querySelector('#rpassword').value;
    var copassword = document.querySelector('#copassword').value;
    var email = document.querySelector('#email').value;
    var coemail = document.querySelector('#coemail').value;
    var eula = document.getElementById('1check').checked;

    if( username !=""  && password != "" && email != ""){
        if(password == copassword){
            if(email == coemail){
                if(eula){
                    sendReqest({type: 2, Email: email, Password: password, Username: username}, RegistCallback);
                } else {
                    alert("Fogadja el az EULA-t")
                }

            }else {
                alert("A két email cím nem egyezik meg")
            }

        } else {
            alert("A két jelszó nem egyezik meg")
        }
    }else {
        alert("Töltse ki a felhasználónevét, jelszavát és emailjét")
    }


   

    
}

function RegistCallback(Data) {

    var dataArray = JSON.parse(Data);
    if (dataArray.error) {
        alert(dataArray.data)
    } else {
        location.reload();
    
    }
}

function close(){
    var X = document.querySelector('main .X')

    X.onclick = function(evt){
        evt.preventDefault();
        const element = document.getElementById("tart");
        element.remove();
      
  
    }
}

function hirek(){
    var buttons = document.querySelectorAll('main  a');

    for(var i =0; i<buttons.length;i++){
        var button = buttons[i];
    
        button.onclick = function(evt){
            evt.preventDefault();
            var x = this.getAttribute('name');
            x = parseInt(x);
            getNews(x);
        }
    }
}

function getNews(id){
    sendReqest({type: 3, id: id}, getNewsCallback);
}

function getNewsCallback(Data) {
    ns.reszlet(Data);
    close();
}

function sendReqest(Data, Callback) {
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
			ServerError(data.status + ": " + data.statusText);
		},
		complete: function () {                 

		},
		cache: false,
		contentType: false,
		processData: false
	});
}



function register(){
            
    var regist = document.querySelector('.regist');

    regist.onclick = function(evt){
         evt.preventDefault();
         lv.register(registerClick);

         
         close();
    }
               
}


        




   
    


