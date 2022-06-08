class LoginView
{
    #container =  document.querySelector('main .inside');

    constructor()
    {
       
        
    }
    felulet(OnLoginButtonClick){
      var html = this.#loginFelulet();
        this.#container.innerHTML = html;

        var button =  document.querySelector('.ben .login');
        button.onclick = function(evt){
          OnLoginButtonClick();
     }
    }

    register(){

        var html = this.#registFelulet();
        this.#container.innerHTML = html;
    }
   
    addCikk(callback){
      var cim = "alma"
      var szov = "körte"

      var cikk =
      {
        cim: cim,
        szov: szov
      };
      callback(cikk);
    };


    
    #loginFelulet()
    {
       return `
       <div id="tart">
        <div class = "kin">
       
            <h1>Log in here</h1>
            <button class="X" >X</button>
                <div class = "ben">
                    <label for="Username">Username:</label>
                    <input type="text" id="Username" name="Username"><br><br>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password"><br><br>
                    <button class ="login">Login</button>
                    <button class ="regist">Register</button>
                </div>
               
                
        </div>
      </div>
    `;
    
    }
    #registFelulet(){
      return `
      <div id="tart">
      <div class="kin">
      <!-- <form method="POST" action="page-home.php"> -->
			<h1>Create an account here</h1>
      <button class="X" >X</button>
			<div class = "ben">
				<label for="username">Username:</label>
				<input type="text" id="rusername" name="rusername">
				<br><br>
				
				<label for="email">E-mail:</label>
				<input type="text" id="email" name="email"><br><br>
				<label for="coemail">Confirm E-mail:</label>
				<input type="text" id="coemail" name="coemail"><br><br>
				
				<label for="rpassword">Password:</label>
				<input type="password" id="rpassword" name="rpassword"><br><br>
				<label for="copassword">Confirm Password:</label>
				<input type="password" id="copassword" name="copassword"><br><br>
				<input type="checkbox" id="1check" name="1check">
				<label for="copassword">I am agree to the <a href="">EULA</label><br>
				
				<button class ="create">Create</button>
        
			</div>
		</div>
    </div>
    `;


    }
    
}
