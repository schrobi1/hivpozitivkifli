class AblakModel{
#data = [];
    constructor()
    {
      

    }
    add(cikk){

        cikk.id = 1;
        if(this.#data.length>0){
            cikk.id = this.#data[this.#data.length -1].id + 1;
        }
        this.#data.push(cikk);
        this.save();
    }

    save(){
        var stored = JSON.stringify(this.data);
        localStorage.setItem('cikk',stored)
    }

    getCikk(){

       var cikk = [
           
           {cim:"alma", szov:"bhehbergazgbviuehdquoavlhabv h erzqerv erhgo hwerv v hurvu akbr vk"},
           {cim:"körte", szov:"A bölcsésztanulók 90% -a a burger Kings-ben végzi diploma után - állítják a britt tudósok"},
           {cim:"szilva", szov:"Breaking news: A Pécsi Tudományegyetem Matematika és Informatikai tanszékén órát adó Farkas Gábor úgy döntött hohy kiváló munkájukért a HivPozitívKiflik csopot tanulóit 5-össel átengedi a tárgyból. "}
       ]

       return cikk;
    }



}