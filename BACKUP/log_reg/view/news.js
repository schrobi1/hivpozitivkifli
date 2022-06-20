class News
{
    #container =  document.querySelector('main .hir');
    #containerhir =  document.querySelector('main .inside');

        
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
    
    reszlet(cikkJSON){
        var cim = "";
        var szov = "";
        var author = "";
        var topc = "";
        var datum = "";

        var cikk = JSON.parse(cikkJSON);

        if (cikk.error) {
            cim = "Hiba történt:";
            szov = cikk.data;
        } else {
            cim = cikk.data.newsName;
            szov = cikk.data.Post;
            author = cikk.data.pubname
            topc = cikk.data.topik
            datum = cikk.data.datum
        }

       
        
        //keszito, topic



        var ahir =this.#openNews(cim, szov, author, datum);
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
    #openNews(cim,szov,szer, datum){
        return `
        <div id="tart">
        <div class="kin">
        <h2>${cim}</h2>
       
        <p>Szerző: ${szer}
        ${datum}</p>
        <div class="ben">
        <p>
        <button class="X">X</button>
            ${szov}
        </p>
        <div class="pics">
            <img src="Ikonok/main01.gif">
            <img src="Ikonok/main11.gif">
            </div>
        </div>
        </div>
      </div>`
    }
}