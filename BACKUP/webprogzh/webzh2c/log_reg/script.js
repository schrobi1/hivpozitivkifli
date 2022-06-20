var aM = new AblakModel();
var ns = new News();
var lv = new LoginView();
var nM = new NewsModel();
login();

/*lv.addCikk(cikk =>
    {
      aM.add(cikk);  
    })
var cikk = aM.getCikk();
ns.beolvas(cikk);*/
hirek();

function login(){
    var login = document.querySelector('.btn');

    login.onclick = function(evt){
     evt.preventDefault();
     lv.felulet();

     register();
     close();
   }
   
   
}

function close(){
    var X = document.querySelector('#main .X')

    X.onclick = function(evt){
        evt.preventDefault();
        const element = document.getElementById("tart");
        element.remove();
      
  
    }
}

function hirek(){
    var buttons = document.querySelectorAll('#main  a');

    for(var i =0; i<buttons.length;i++){
        var button = buttons[i];
        console.log(button);
        button.setAttribute('name',+i);
    
    button.onclick = function(evt){
        evt.preventDefault();
        var x = this.getAttribute('name');
        x = parseInt(x);
        console.log(x);
        ns.reszlet(x,cikk);
            
        close();
    }
}
           
}

function register(){
            
    var regist = document.querySelector('.regist');

    regist.onclick = function(evt){
         evt.preventDefault();
         lv.register();

         
         close();
    }
               
}
        




   
    


