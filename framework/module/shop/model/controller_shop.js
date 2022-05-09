function loadListCars() {
    var filters = localStorage.getItem('filters') || false;
    var marca = localStorage.getItem('marca') || false;
    var category = localStorage.getItem('category') || false;
    var type = localStorage.getItem('type') || false;
    var srchbrand = localStorage.getItem('marcasearch') || false;
    var srchcity = localStorage.getItem('city') || false;
    var srchdetail = localStorage.getItem('detail') || false;
    var srchkeyup = localStorage.getItem('keyup') || false;



    if (srchdetail != false) {
        var id = JSON.parse(localStorage.getItem('detail'));
        loadDetailCar(id);
    } else if (srchbrand != false | srchcity != false | srchkeyup != false) {
        search();
    } else if (category != false) {
        localStorage.removeItem('filters');
        filtcategory();
    } else if (type != false) {
        localStorage.removeItem('filters');
        filttype();
    } else if (marca != false) {
        localStorage.removeItem('filters');
        filtmarca();
    } else if (filters != false && marca == false && type == false && category == false) {
        all_lists_products();
        hightlight();
    } else {
        if (!localStorage.getItem('pag')) {
            localStorage.setItem('pag', 1);
        }
        console.log(localStorage.getItem('pag') * 5 - 5);
        ajaxForSearch('index.php?page=shop&op=allcars&num=' + (localStorage.getItem('pag') * 5 - 5));
        // ajaxForSearch('module/shop/controller/controller_shop.php?op=allcars&num=' + (localStorage.getItem('pag') * 5 - 5), localStorage.getItem('scroll'));
        bootpag();

    }

}

function loadDetailCar(id) {
    // $("html, body").animate({ scrollTop: $('#scroll').offset().top }, 1000);

    // ajaxPromise('module/shop/controller/controller_shop.php?op=details&id=' + id,
    //     'GET', 'JSON')
    ajaxPromise('index.php?page=shop&op=details&id=' + id,
        'GET', 'JSON')
        .then(function (data) {
            $('#page-selection').empty();
            $("#list").empty();
            $('<div></div>').attr('class', 'images').appendTo("#list");
            $('<div></div>').attr('class', "details").html(
                '<table class="conf">' +
                '<tr>' +
                '<td>' + data[0][0].marca + ' ' + data[0][0].modelo + '</td>' +
                '<td>Category: ' + data[0][0].estado + '</td>' +
                '</tr><tr>' +
                '<td>Type: ' + data[0][0].tipo + '</td>' +
                '<td>City: ' + data[0][0].city + '</td>' +
                '</tr><tr>' +
                '<td>Fecha Matriculacion: ' + data[0][0].fecha_matr + '</td>' +
                '<td>Color: ' + data[0][0].color + ' </td>' +
                '</tr><tr>' +
                '<td>Cv: ' + data[0][0].cv + '</td>' +
                '<td>Precio: ' + data[0][0].precio + '</td>' +
                '</tr>' +
                '<div class="like" id=' + data[0][0].id + '><i id=' + data[0][0].id + ' class="fa-regular fa-heart fa-xl right regular dtlike"></i></div>'
            ).appendTo("#list");
            loadMap("map_details");
            addmarker(data[0][0]);
            $('<div></div>').attr('class', 'related').html('<h3><b>More related</b></h3>').appendTo("#list");
            $('<div></div>').attr('class', 'morebtn').appendTo("#list");
            loadrelated(data[0][0]);

            for (row in data[1][0]) {
                $('<div></div>').attr('class', 'prueba').html('<img src="module/shop/view/productimg/' + data[1][0][row].img + '"></img>').appendTo(".images");
            }

            $('.images').slick({
                infinite: true,
                speed: 1000,
                slidesToShow: 1,
                autoplay: true,
                autoplaySpeed: 3000
            })

        });
}

function loadrelated(data, num = 0) {

    let limit = num;
    ajaxPromise('module/shop/controller/controller_shop.php?op=related&brand=' + data.marca + '&id=' + data.id + '&limit=' + limit,
        'GET', 'JSON')
        .then(function (data) {
            $('.morebtn').empty();
            if (data != null) {
                $('.related').empty()
                if (data.length != 2) {
                    console.log("menor");
                    for (row in data) {
                        $('<div></div>').attr({ 'class': 'relateds', 'id': data[row].id }).html(
                            '<div id= "' + data[row].id + '" class="relatedss">' +
                            '<img src="module/shop/view/productimg/' + data[row].img + '">' + data[row].marca + ' ' + data[row].modelo + '</img>' +
                            '</div>' +
                            '<div class="like" id=' + data[row].id + '><i id=' + data[row].id + ' class="fa-regular fa-heart fa-xl right regular"></i></div>'
                        ).appendTo(".related");
                    }
                } else {
                    for (row in data) {
                        $('<div></div>').attr({ 'class': 'relateds', 'id': data[row].id }).html(
                            '<div id= "' + data[row].id + '" class="relatedss">' +
                            '<img src="module/shop/view/productimg/' + data[row].img + '">' + data[row].marca + ' ' + data[row].modelo + '</img>' +
                            '</div>' +
                            '<div class="like" id=' + data[row].id + '><i id=' + data[row].id + ' class="fa-regular fa-heart fa-xl right regular"></i></div>'
                        ).appendTo(".related");
                    }
                    $('<br><input></input>').attr({ 'class': 'btonmore', 'type': 'button', 'value': 'More' }).appendTo('.morebtn')

                }
            } else {
                $('<h3></h3>').attr('class', 'more').html('No more').appendTo('.related')
                $('.morebtn').empty();
            }
            likeshighlight();
            $('#list').on("click", ".btonmore", function () {
                loadrelated(data, 3);

            })
        });


}

function clicking() {
    $('#list').on("click", ".clicklistcar", function () {
        var id = this.getAttribute('id');
        loadDetailCar(id);
        sumcount(id);
    });

    $('#list').on("click", ".fa-heart", function () {

        if (localStorage.getItem('token')) {
            var id = this.getAttribute('id');
            var prnlike = this.getAttribute('class').split(' ');

            $('#' + id + '.like').empty();
            if (prnlike[4] == 'regular') {

                $('<i id=' + id + ' class="fa-solid fa-heart fa-xl right solid"></i>').appendTo('#' + id + '.like');
                ajaxPromise("module/login/controller/controller_login.php?op=likeoption",
                    'POST', 'JSON', { 'token': localStorage.getItem('token'), 'idcar': id, 'op': 'like' })
                    .then(function (data) {
                        console.log(data);
                    });

            } else if (prnlike[4] == 'solid') {

                $('<i id=' + id + ' class="fa-regular fa-heart fa-xl right regular"></i>').appendTo('#' + id + '.like');
                ajaxPromise("module/login/controller/controller_login.php?op=likeoption",
                    'POST', 'JSON', { 'token': localStorage.getItem('token'), 'idcar': id, 'op': 'unlike' })
                    .then(function (data) {
                        console.log(data);
                    });
            }
        } else {
            localStorage.setItem('callback', 'index.php?page=controller_shop&op=list');
            var prnlike = this.getAttribute('class').split(' ');
            if (prnlike[5] == 'dtlike') {
                localStorage.setItem('detail', this.getAttribute('id'));
            }
            location.href = "index.php?page=controller_login&op=login_view";

        }
    });

    $(document).on("click", ".nav__item", function () {
        localStorage.removeItem('detail');
    });

    $('#list').on("click", ".relatedss", function () {
        $('.related').empty();
        var id = this.getAttribute('id');
        loadDetailCar(id);
    })

}

function sumcount(id) {
    ajaxPromise('?page=shop&op=sum_visit&id=' + id,
        'GET', 'JSON');
}

function loadfilter() {
    if (localStorage.getItem('marca') != null) {
        var marca = JSON.parse(localStorage.getItem('marca'));
        var marca1 = marca[0].marca[0];
    }
    if (marca1 == null) {
        marca1 = "Nada";
    }
    $('<div></div>').attr('class', 'filterlist').html(
        '<b style="margin-bottom: 100px;">Puertas</b>' +
        '<br>' +
        '<input type="radio" id="2" class="puertas" name="puertas" value="2"/>2' +
        '<br>' +
        '<input type="radio" id="3" class="puertas" name="puertas" value="3"/>3' +
        '<br>' +
        '<input type="radio" id="4" class="puertas" name="puertas" value="4"/>4' +
        '<br>' +
        '<input type="radio" id="5" class="puertas" name="puertas" value="5"/>5' +
        '<br>' +
        '<br>' +
        '<b>Color</b>' +
        '<br>' +
        '<input type="checkbox" class="color" id="White" value="White"/>White' +
        '<br>' +
        '<input type="checkbox" class="color" id="Black" value="Black"/>Black' +
        '<br>' +
        '<input type="checkbox" class="color" id="Blue" value="Blue"/>Blue' +
        '<br>' +
        '<input type="checkbox" class="color" id="Red" value="Red"/>Red' +
        '<br>' +
        '<input type="checkbox" class="color" id="Green" value="Green"/>Green' +
        '<br>' +
        '<input type="checkbox" class="color" id="Yellow" value="Yellow" style="margin-bottom: 30px;"/>Yellow' +
        '<br>' +
        '<br>' +
        '<br>' +
        '<span>Marca selected: </span>' +
        '<br>' +
        marca1 +
        '<br>' +
        '<br>' +
        '<input type="submit" id="submit" name="aplicar"/>'
    ).appendTo("#list");
    $('#list').on("click", "#submit", function () {
        filter();
    });
    $('#list').on("click", "#reset", function () {
        remove_filter();
    });
}


function filter() {
    var puertas = [];
    var color = [];
    var filters = [];

    localStorage.removeItem('filters');

    $.each($("input[class='puertas']:checked"), function () {
        puertas.push($(this).val());
    });
    if (puertas.length != 0) {
        filters.push({ "puertas": puertas });
    } else {
        filters.push({ "puertas": "all" });
    }

    $.each($("input[class='color']:checked"), function () {
        color.push($(this).val());
    });
    if (color.length != 0) {
        filters.push({ "color": color });
    } else {
        filters.push({ "color": "all" });
    }

    if (filters.length != 0) {
        localStorage.setItem('filters', JSON.stringify(filters));
    }
    all_lists_products();
}

function all_lists_products() {
    var todo = JSON.parse(localStorage.getItem('filters'));
    var marca = JSON.parse(localStorage.getItem('marca'));


    var puertas = todo[0].puertas[0];
    var color = todo[1].color;

    if (marca != null) {
        // ajaxForSearch('?Fs=shop&op=filter&puertas=' + puertas + '&color=' + colowr + '&marca=' + marca[0].marca[0]);
        ajaxForSearch('module/shop/controller/controller_shop.php?op=filters&puertas=' + puertas + '&color=' + color + '&marca=' + marca[0].marca[0]);
    } else {
        ajaxForSearch('?page=shop&op=filters&puertas=' + puertas + '&color=' + color + '&marca=' + 'a');

        // ajaxForSearch('module/shop/controller/controller_shop.php?op=ss&puertas=' + puertas + '&color=' + color + '&marca=a');

    }
}

function ajaxForSearch(durl, scrolling = null) {

    ajaxPromise(durl,
        'GET', 'JSON')
        .then(function (data) {
            $("#allcars").remove();
            $("#map").remove();
            loadMap("map");

            $('<div></div>').attr({ 'id': 'allcars', 'class': 'allcars' }).appendTo('#list');
            for (row in data) {
                $('<div></div>').attr({ 'id': data[row].id, 'class': 'listCar' }).html(
                    '<div class="like" id=' + data[row].id + '><i id=' + data[row].id + ' class="fa-regular fa-heart fa-xl right regular"></i></div>' +
                    '<div class="clicklistcar" id=' + data[row].id + '>' +
                    '<div class="title"><h3>' + data[row].marca + ' ' + data[row].modelo + '</h3>' +
                    '<ul><li>Estado: ' + data[row].estado + '</li>' +
                    '<li>Fecha Matriculacion: ' + data[row].fecha_matr + '</li>' +
                    '<li>Km: ' + data[row].km + '</li>' +
                    '<li>Price: ' + data[row].precio + '</li>' +
                    '<li>Cv: ' + data[row].cv + '</li>' +
                    '</ul>' +
                    '</div>' +
                    '<div class="listimg">' +
                    '<img class="imgdiv" src="module/shop/view/productimg/' + data[row].img + '"/>' +
                    '</div>' +
                    '</div>'
                ).appendTo('#allcars');
                addmarker(data[row], 0);
            }
            likeshighlight();
        })
        .catch(function () {
            $('#list').empty();
            loadfilter();
            hightlight();
            loadMap("map");
            $('<div></div>').attr({ 'id': 'noresult', 'class': 'noresult' }).html(
                '<h3>No results</h3>'
            ).appendTo('#list');
        })
    // $("html, body").animate({ scrollTop: $('#scroll').offset().top }, 1000);
}

function likeshighlight() {
    if (localStorage.getItem('token')) {
        console.log("token");
        ajaxPromise("module/login/controller/controller_login.php?op=likeoption",
            'POST', 'JSON', { 'token': localStorage.getItem('token'), 'op': 'like_select' })
            .then(function (data) {
                console.log(data);
                for (row in data) {
                    $('#' + data[row].id_car + '.like').empty();
                    $('<i id=' + data[row].id_car + ' class="fa-solid fa-heart fa-xl right solid"></i>').appendTo('#' + data[row].id_car + '.like');
                }
            });

    } else {
        console.log("notoken");
    }
}

function hightlight() {
    var todo = JSON.parse(localStorage.getItem('filters'));
    if (todo[0].puertas[0] != 'a') {
        document.getElementById(todo[0].puertas[0]).setAttribute('checked', true);
    }
    if (todo[1].color != 'all') {
        for (row in todo[1].color) {
            document.getElementById(todo[1].color[row]).setAttribute('checked', true);
        }
    }
}

function addmarker(data, opt) {
    const popup = new mapboxgl.Popup({ offset: 25 }).setHTML(
        '<div class=popmark>' +
        '<img src="module/shop/view/productimg/' + data.img + '">' +
        '<h2>' + data.marca + ' ' + data.modelo + '</h2>' +
        '<h3>Precio: ' + data.precio + '</h3>' +
        '</div>'
    )
    if (opt == '0') {

        const popup1 = new mapboxgl.Popup({ offset: 25 }).setHTML(
            '<div class=popmark>' +
            '<img src="module/shop/view/productimg/' + data.img + '">' +
            '<h2>' + data.marca + ' ' + data.modelo + '</h2>' +
            '<h3>Precio: ' + data.precio + '</h3>' +
            '<input class="data" id="' + data.id + '" type="button" value="View More" style="color: rgb(255, 110, 110)!important;"/>' +
            '</div>'
        );
        marker = new mapboxgl.Marker()
            .setLngLat([data.lng, data.lat])
            .setPopup(popup1)
            .addTo(map);

    } else {

        marker = new mapboxgl.Marker()
            .setLngLat([data.lng, data.lat])
            .setPopup(popup)
            .addTo(map);

    }


    if (opt == '0') {

        $('#map').on("click", "#" + data.id, function () {
            loadDetailCar(data.id);
        });

    }

}
function loadMap(container) {

    $('<div></div>').attr({ 'id': container, 'class': 'map' }).appendTo('#list');
    mapboxgl.accessToken = 'pk.eyJ1Ijoic2FudGlpbWFydGluZXoiLCJhIjoiY2t6eWZlYzk2MGIyOTJ2cDdxc2dmcDkxaSJ9.IhYesNObwvyMWu_nQQQoiw';
    map = new mapboxgl.Map({
        container: container, // container ID
        style: 'mapbox://styles/mapbox/streets-v11', // style URL
        center: [-0.491254, 38.848895], // starting position [lng, lat]
        zoom: 9 // starting zoom
    });
    map.addControl(new mapboxgl.FullscreenControl());
    map.addControl(new mapboxgl.NavigationControl(), 'top-left');

}

function remove_filter() {
    localStorage.removeItem('filters');
    localStorage.removeItem('marca');
    localStorage.removeItem('category');
    localStorage.removeItem('type');
    location.reload();
}

function filtmarca() {
    var todo = JSON.parse(localStorage.getItem('marca'));
    ajaxForSearch('module/shop/controller/controller_shop.php?op=filtbrand&marca=' + todo[0].marca[0] + '');
}

function filtcategory() {
    var todo = JSON.parse(localStorage.getItem('category'));
    ajaxForSearch('module/shop/controller/controller_shop.php?op=filtcategory&category=' + todo[0].category[0] + '');
}

function filttype() {
    var todo = JSON.parse(localStorage.getItem('type'));
    ajaxForSearch('module/shop/controller/controller_shop.php?op=filttype&type=' + todo[0].type[0] + '');
}
function search() {
    var auto = JSON.parse(localStorage.getItem('keyup'));
    if (auto == null) {
        auto = "";
    }
    var marca = JSON.parse(localStorage.getItem('marcasearch'));
    var city = JSON.parse(localStorage.getItem('city'));
    if (marca == null && city == null) {
        url = "module/search/controller/controller_search.php?op=autocomplete&auto=" + auto + "";
    } else if (marca != null && city == null) {
        url = "module/search/controller/controller_search.php?op=autocomplete&marca=" + marca[0].change + "&auto=" + auto + "";
    } else if (marca != null && city != null) {
        url = "module/search/controller/controller_search.php?op=autocomplete&marca=" + marca[0].change + "&city=" + city[0].change + "&auto=" + auto + "";
    } else {
        url = "module/search/controller/controller_search.php?op=autocomplete&city=" + city[0].change + "&auto=" + auto + "";
    }
    ajaxForSearch(url);
}

function loadorder() {
    $('<div></div>').attr({ 'id': 'orderby', 'class': 'orderby' }).html(

        '<b>Order</b>' +
        '<br>' +
        '<input type="radio" id="precio" name="order" value="precio">Precio</input>' +
        '<br>' +
        '<input type="radio" id="km" name="order" value="km">Km</input>' +
        '<br>' +
        '<input type="radio" id="cv" name="order" value="cv ">CV</input>' +
        '<br>' +
        '<input type="button" id="test" value="ASC">' +
        '<input type="submit" id="order" value="Aplicar"/>' +
        '<input type="button" id="reset" name="reset" value="Reset All"/>' +
        '<br>'
    ).appendTo('.filterlist');

    $('.filterlist').on("click", "#order", function () {
        var type = JSON.parse(localStorage.getItem('order'))
        $.each($("input[name='order']:checked"), function () {
            console.log(($(this).val()));
            var order = ($(this).val());
            localStorage.setItem('orderby', JSON.stringify(($(this).val())));
            ajaxForSearch('?page=shop&op=orderby&order=' + order + '&type=' + type);
            bootpag();

        });
    });
    $('.filterlist').on("click", "#test", function () {
        if (this.getAttribute('value') == 'ASC') {
            this.setAttribute('value', 'DESC');
        } else {
            this.setAttribute('value', 'ASC');
        }
        localStorage.setItem('order', JSON.stringify(this.getAttribute('value')));
    });

}


function bootpag() {
    ajaxPromise('module/shop/controller/controller_shop.php?op=count', 'POST', 'JSON')
        .then(function (data) {
            console.log(data);
            console.log(data.count.length);
            dataint = parseInt(data.count);
            cont = (cont) + (dataint);

            $('#page-selection').bootpag({
                total: Math.ceil(cont / 5),
                page: localStorage.getItem('pag')
            }).on("page", function (event, /* page number here */ num) {
                $('.allcars').remove();
                $('.map').remove();
                console.log(num * 5 - 5);
                localStorage.setItem('pag', num);
                ajaxForSearch('index.php?page=shop&op=allcars&num=' + (localStorage.getItem('pag') * 5 - 5));
            });
            // console.log(data[0]x.length);
        });
}

var cont = 0;
$(document).ready(function () {
    localStorage.setItem('order', JSON.stringify('ASC'));
    const map = null;
    loadfilter();
    loadorder();
    loadListCars();
    clicking();
});