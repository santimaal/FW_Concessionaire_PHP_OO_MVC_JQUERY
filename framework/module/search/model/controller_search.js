function load_marcas(){
    localStorage.removeItem('marcasearch');

    ajaxPromise("module/search/controller/controller_search.php?op=marcas",
        'GET', 'JSON')
        .then(function(data) {
            $('.marcassearch').empty();
            // $('<select></select>').attr({'class' : 'marcassearch'}).appendTo('#search');
            $('<option></option>').attr({'selected':'', 'disabled':'', 'hidden':''}).html('<option value = "Brand">Brand</option>').appendTo('.marcassearch');


            for (row in data) {
                $('.marcassearch').append('<option id="'+data[row].id+'"value = "' + data[row].id + '">' + data[row].id + '</option>');

                // $('<option></option>').attr({'id' : data[row].id}).html('<option value = "'+data[row].id+'">'+data[row].id+'</option>').appendTo('.marcassearch');
            }
                });

}
function load_ciudades(){
    localStorage.removeItem('city');

    var marca = JSON.parse(localStorage.getItem('marcasearch'));
    var url = null;
    if (marca!=null) {
        url= "module/search/controller/controller_search.php?op=ciudades&marca="+marca[0].change+"";
    }
    else {
        url="module/search/controller/controller_search.php?op=ciudades";
    }
    ajaxPromise(url,
        'GET', 'JSON')
        .then(function(data) {
            $('.ciudadsearch').empty();
            // $('<select></select>').attr({'class' : 'ciudadsearch', 'value' : 'Ciudad'}).appendTo('#search');
            $('<option></option>').attr({'selected':'', 'disabled':'', 'hidden':'' }).html('<option value = "City">City</option>').appendTo('.ciudadsearch');
            
            for (row in data) {
                $('<option></option>').attr({'id' : data[row].city}).html('<option value = "'+data[row].city+'">'+data[row].city+'</option>').appendTo('.ciudadsearch');
            }
            });
            

}

function autocomplete() {
    localStorage.removeItem('keyup');

    $(document).on('keyup', '#autocom',  function(){
        localStorage.setItem('keyup', JSON.stringify($('#autocom').val()));
        var marca = JSON.parse(localStorage.getItem('marcasearch'));
        var city = JSON.parse(localStorage.getItem('city'));
        var auto=$('#autocom').val();
        var url=null;
         if (marca==null && city==null)  {
             url= "module/search/controller/controller_search.php?op=autocomplete&auto="+auto+"";
         } else if (marca!=null && city==null) {
            url= "module/search/controller/controller_search.php?op=autocomplete&marca="+marca[0].change+"&auto="+auto+"";
         } else if (marca!=null && city!=null){
            url= "module/search/controller/controller_search.php?op=autocomplete&marca="+marca[0].change+"&city="+city[0].change+"&auto="+auto+"";
         } else {
            url= "module/search/controller/controller_search.php?op=autocomplete&city="+city[0].change+"&auto="+auto+"";
         }
        
         ajaxPromise(url,
            'GET', 'JSON')
            .then(function(data) {
                localStorage.removeItem('data');
                $('#search_auto').empty();
                $('#search_auto').fadeIn(10000000);
                for (row in data) {
                    $('<div></div>').appendTo('#search_auto').html(data[row].marca+' '+data[row].modelo).attr({'class': 'searchElement', 'id': data[row].id});
                }
                localStorage.setItem('search', JSON.stringify(data));
            });
        });
            
}
function changes() {

    // var test;
$(document).on('change', '.marcassearch',  function(){
    // test = $(this).val();
    var change=[];
    change.push({'change': $(this).val()});
    localStorage.setItem('marcasearch', JSON.stringify(change));
    load_ciudades();
    autocomplete();
});
$(document).on('change', '.ciudadsearch',  function(){
    // test = $(this).val();
    var changecty=[];
    changecty.push({'change': $(this).val()});
    localStorage.setItem('city', JSON.stringify(changecty));
});
$(document).on('click', '.searchElement',  function(){
    localStorage.setItem('detail', JSON.stringify(this.getAttribute('id')));
    setTimeout(function(){ 
        window.location.href = 'index.php?page=controller_shop&op=list';
      }, 500);  
});
$(document).on('click', '.searchimg',  function(){
    localStorage.removeItem('detail');
    setTimeout(function(){ 
        window.location.href = 'index.php?page=controller_shop&op=list';
      }, 500);  
});
}

$(document).ready(function () {
// localStorage.removeItem('marcasearch');
// localStorage.removeItem('city');
$('<select></select>').attr({'class' : 'marcassearch'}).appendTo('#search');
$('<select></select>').attr({'class' : 'ciudadsearch', 'value' : 'Ciudad'}).appendTo('#search');
$('<div></div>').attr({'id' : 'autosearch', 'class' : 'autosearch'}).appendTo('#search');
$('<input></input>').attr({'id' : 'autocom', 'class' : 'autocom', 'type' : 'text'}).appendTo('#autosearch');
$('<div></div>').attr({'id' : 'search_auto', 'class' : 'search_auto'}).appendTo('#autosearch');
$('<img></img>').attr({'id' : 'searchimg', 'class' : 'searchimg', 'src': 'view/img/search.png'}).appendTo('#autosearch');


// $('<div></div>').attr({ 'id': 'testeo'})
//           .html("opaaa"
//           ).appendTo('#search');
          load_marcas();
          load_ciudades();
          autocomplete();
          changes();
        });