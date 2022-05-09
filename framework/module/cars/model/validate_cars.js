function validate_matricula(texto){
    if (texto.length > 0){
        var reg=/^[0-9]{4}[BCDFGHJKLMNPRSTVWXYZ]{3}$/;
        return reg.test(texto);
    }
    return false;
}

function validate_modelo(texto){
    if (texto.length > 0){
        var reg=/^[a-zA-Z]*$/;
        return reg.test(texto);
    }
    return false;
}

function validate_marca(texto){
    if (texto.length > 0){
        var reg=/^[a-zA-Z]*$/;
        return reg.test(texto);
    }
    return false;
}

function validate_km(texto){
    if (texto.length > 0){
        var reg=/^[0-9]{1,6}$/;
        return reg.test(texto);
    }
    return false;
}

function validate_color(texto){
  //  if (texto.length > 0){
  //      var reg=/^[#0-9a-zA-Z]*$/;
  //      return reg.test(texto);
  //  }
  //  return false;
  return true;
}

function validate_tipo(texto){
    var i;
    var ok=0;
    for(i=0; i<texto.length;i++){
        if(texto[i].checked){
            ok=1
        }
    }
 
    if(ok==1){
        return false;
    }
    if(ok==0){
        return true;
    }
}

function validate_puertas(texto){
    if (texto.length > 0){
        var reg=/^[0-9]{1}$/;
        return reg.test(texto);
    }
    return false;
}

function validate_cv(texto){
    if (texto.length > 0){
        var reg=/^[0-9]{1,3}$/;
        return reg.test(texto);
    }
    return false;
}

function validate(){
    // console.log('hola validate js');
    // return true;

    var check=true;
    
    var v_matricula=document.getElementById('matricula').value;
    var v_modelo=document.getElementById('modelo').value;
    var v_marca=document.getElementById('marca').value;
    var v_km=document.getElementById('km').value;
    var v_color=document.getElementById('color').value;
    var v_tipo=document.getElementById('tipo').value;
    var v_puertas=document.getElementById('puertas').value;

    var r_matricula=validate_matricula(v_matricula);
    console.log(r_matricula);

    var r_modelo=validate_modelo(v_modelo);
    console.log(r_modelo);
    var v_marca=validate_marca(v_marca);
    console.log(v_marca);

    var r_km=validate_km(v_km);
    console.log(r_km);

    var r_color=true;
    //var r_color=validate_color(v_color);
    console.log(r_color);

    var r_tipo=validate_tipo(v_tipo);
    console.log(r_tipo);

    var r_puertas=validate_puertas(v_puertas);
    console.log(r_puertas);


    
    if(!r_matricula){
        document.getElementById('error_matricula').innerHTML = " * La matricula introducida no es valida";
        check=false;
    }else{
        document.getElementById('error_matricula').innerHTML = "";
    }
    if(!r_modelo){
        document.getElementById('error_modelo').innerHTML = " * El modelo introducido no es valido";
        check=false;
    }else{
        document.getElementById('error_modelo').innerHTML = "";
    }
    if(!v_marca){
        document.getElementById('error_marca').innerHTML = " * La marca introducida no es valida";
        check=false;
    }else{
        document.getElementById('error_marca').innerHTML = "";
    }
    if(!r_km){
        document.getElementById('error_km').innerHTML = " * El km introducido no es valido";
        check=false;
    }else{
        document.getElementById('error_km').innerHTML = "";
    }
    if(!r_color){
        document.getElementById('error_color').innerHTML = " * El color introducido no es valido";
        check=false;
    }else{
        document.getElementById('error_color').innerHTML = "";
    }
    if(!r_tipo){
        document.getElementById('error_tipo').innerHTML = " * No has seleccionado ningun tipo";
        check=false;
    }else{
        document.getElementById('error_tipo').innerHTML = "";
    }
    if(!r_puertas){
        document.getElementById('error_puertas').innerHTML = " * Las puertas introducidas no son validas";
        check=false;
    }else{
        document.getElementById('error_puertas').innerHTML = "";
    }
   return check;


}

function validate_update(){ 

    console.log("holaaaa");

    var check=true;
    check=validate();

    
    if (check==false) {
        return 0;
    } else {
        document.update_cars.submit();
        document.update_cars.action="index.php?page=controller_cars&op=update";
    }

}

function validate_create(){     

    var check=true;
    check=validate();

    
    if (check==false) {
        return 0;
    } else {
        document.alta_cars.submit();
        document.alta_cars.action="index.php?page=controller_cars&op=create";
    }


}
function showModal(carTitle, id) {
    $("#details_car").show();
    $("#modalcontent").dialog({
        title: carTitle,
        width : 850,
        height: 500,
        resizable: "false",
        modal: "true",
        hide: "fold",
        show: "fold",
        buttons : {
            Update: function() {
                        window.location.href = 'index.php?page=controller_cars&op=update&id=' + id;
                    },
            Delete: function() {
                        window.location.href = 'index.php?page=our-cars&op=delete&carPlate=' + id;
                    }
        }// end_Buttons
    }); // end_Dialog
}

function loadcontentcar() {

    $('.Button_blue').click(function () {
        var id = this.getAttribute('id');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "module/cars/controller/controller_cars.php?op=read_modal&id=" + id,
        })
         .done(function(data) {
             console.log(data);
            $('<div></div>').attr('id', 'detailsCars','type', 'hidden').appendTo('#carModal');
            $('<div></div>').attr('id', 'Div1').appendTo('#modalcontent');
            $('#Div1').html(function() {
                var content = "";
                for (row in data) {
                    if (data[row] != data['color']) {
                    content += '<br><span>' + row + ': <span id =' + row + '>' + data[row] + '</span></span>';
                    } else {
                    content += '<br><span>' + row + ': <input type="color" value="'+data[row]+'" disabled/></span></span>';
                    }
                }// end_for
                //////
                return content;
                });
                //////
                showModal(carTitle = data.marca + " " + data.modelo, data.id);
                //////
        }).fail(function(data) {
                     //window.location.href = 'module/exceptions/list_exceptions&op=503';

     });
});
}

$(document).ready(function () {
    // $('#table_crud').DataTable();
    loadcontentcar();
});