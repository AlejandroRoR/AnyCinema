function crearHttp(){
    let objeto;
    if (window.XMLHttpRequest){ //Si el navegador soporta la tecnología AJAX
        objeto=new XMLHttpRequest(); //crear vínculo para la comunicación con el servidor
    }else if(window.ActiveXObject){ //navegador IE antiguo
        try{
            objeto=new ActiveXObject("MSXML2.XMLHTTP");
        }catch (e){
            objeto=new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return objeto;
}