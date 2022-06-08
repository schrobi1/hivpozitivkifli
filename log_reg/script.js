var aM = new AblakModel();
var ns = new News();
var lv = new LoginView();
var nM = new NewsModel();
login();

/*lv.addCikk(cikk =>
    {
      aM.add(cikk);  
    })*/
//var cikk = aM.getCikk();
//ns.beolvas(cikk);
hirek();

function login(){
    var login = document.querySelector('.btn');

    login.onclick = function(evt){
     evt.preventDefault();
     lv.felulet(LoginClick);

     register();
     close();
   }
   
   
}

function LoginClick() {
    var email = document.querySelector('#Username').value;
    var password = document.querySelector('#password').value;

    sendReqest({type: 0, Email: email, Password: password}, LoginCallback);
}

function LoginCallback(Data) {
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
         lv.register();

         
         close();
    }
               
}
        




   
    


