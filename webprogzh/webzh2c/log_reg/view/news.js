class News
{
    #container =  document.querySelector('#main .hir');
    #containerhir =  document.querySelector('#main .inside');

        
    constructor()
    {
       /* var cims = [];
        var szovs = [];
        var html = '';
        

        cims = ["alma","korte","szilva","kutya"];
        szovs = ["kalap","nyul","barack","macska"];

        for(var c = 0 ; c < cims.length ; c++){
            var cim = cims[c];
            var szov = szovs[c];
            console.log(cim);


        
        html += this.#NewsBasic(cim,szov);
    }
        this.#container.innerHTML = html;*/
        
    }
    beolvas(cikk){
        var html = "";
        for(var c = 0 ; c < cikk.length ; c++){
            var cim = cikk[c].cim;
            var szov = cikk[c].szov;
            console.log(cim);


        
        html += this.#NewsBasic(cim,szov);
    }
        this.#container.innerHTML = html;

    }
    
    reszlet(x,cikk){
        
        var cim = cikk[x].cim;
        var szov = cikk[x].szov;



        var ahir =this.#openNews(cim, szov);
        this.#containerhir.innerHTML = ahir;

    }

    #NewsBasic(cim,szov)
    {
       return `
        <h2>${cim}</h2>
        
        <p>
        ${szov}
        </p>
        <div class="pics">
            <img src="Ikonok/main01.gif">
            <img src="Ikonok/main11.gif">
        </div>
            <div class="CikkLink">
                <a class="reszlet">Részletek</a>
            </div>
        <div class="csik"></div>`;
    }
    #openNews(cim,szov){
        return `
        <div id="tart">
        <div class="kin">
        <h2>${cim}</h2>
        <button class="X">X</button>
        <div class="ben">
        <p>
            ${szov}
        </p>
        <div class="pics">
            <img src="Ikonok/main01.gif">
            <img src="Ikonok/main11.gif">
            </div>
        </div>
        </div>
        <style>
        .hir, header, footer, aside {
          opacity:0.5;
      }
      
      </style>
      </div>`
    }
}