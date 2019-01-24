function marcarMenuSelecionado(pagina){
    console.log(pagina);
    var menu = $('#menuCabecalho li')
    if(pagina == "Inicial"){
        menu.removeClass('active');
        var element = '';
        console.log(element);
        element.addClass('active');
        console.log(element.innerText);
        console.log(element.innerHTML);
        //console.log(element)



    }
}