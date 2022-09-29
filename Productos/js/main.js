'use strict'

window.addEventListener('load',function(){

    let boxFiltrar = this.document.querySelectorAll("#filtrar");

    if(boxFiltrar.length == 1){
        let filtrar = this.document.querySelector("#btnFiltrar");
        let cancelar = this.document.querySelector("#btnCancelarFiltro");
        
        filtrar.addEventListener('click',function(){
            boxFiltrar[0].style.display="flex";
        });
        cancelar.addEventListener("click",function(){
            boxFiltrar[0].style.display="none";
        });
        
    }
});