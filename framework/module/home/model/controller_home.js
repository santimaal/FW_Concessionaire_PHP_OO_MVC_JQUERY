function loadSlider() {
  $.ajax({
    url: '?page=home&op=homePageBrand',
    type: 'GET',
    dataType: 'json',
  })
    .done(function (data) {
      for (row in data) {
        $('<div></div>').attr('class', "carousel__elements").attr('id', data[row].id).appendTo(".carousel__list").html(
          "<img class='carousel__img' id='' src='module/home/view/marimg/" + data[row].img + "' alt='' style = 'max-width: 100%; max-height: 150px;'>"
        )
      }

      new Glider(document.querySelector('.carousel__list'), {
        slidesToShow: 3,
        slidesToScroll: 2,
        draggable: true,
        dots: '.carousel__indicator',
        arrows: {
          prev: '.prev',
          next: '.next'
        }
      });

    })
}


function loadCategory() {
  $.ajax({
    url: '?page=home&op=homePageCat',
    type: 'GET',
    dataType: 'json',
  })
    .done(function (data) {
      for (row in data) {
        let id = data[row].id.replace(/ /g, "_");
        // console.log(data[row].img);
        $('<div></div>').attr({ 'id': id, 'class': 'col-md-4 single-service-2' }).appendTo('#containerCategories');
        $('<div></div>').attr({ 'class': 'inner', 'id': data[row].id })
          .html("<img class='carousel__img' id='' src='module/home/view/category/" + data[row].img + "' alt='' style = 'max-width: 290px; height: 200px;'><h3 align=center style = ''>" + data[row].id + "</h3></img>")
          .appendTo('#' + id);
      }
    }).fail(function () {
      console.log("eerror");


      window.location.href = 'module/exceptions/view/inc/error503.php';
    });
}

function loadType() {
  $.ajax({
    // url: 'module/home/controller/controller_home.php?op=homePageType',
    url: '?page=home&op=homePageType',
    type: 'GET',
    dataType: 'json',
  })
    .done(function (data) {
      for (row in data) {
        let id = data[row].id.replace(/ /g, "_");
        // console.log(data[row].img);
        $('<div></div>').attr({ 'id': id, 'class': 'col-md-4 single-service-2' }).appendTo('#containerTypes');
        $('<div></div>').attr({ 'class': 'inner3', 'id': data[row].id })
          .html("<img class='carousel__img' id='' src='module/home/view/type/" + data[row].img + "' alt='' style = 'max-width: 290px; height: 200px;'><h3 align=center style = ''>" + data[row].id + "</h3></img>")
          .appendTo('#' + id);
      }
    }).fail(function () {
      console.log("eerror");


      window.location.href = 'module/exceptions/view/inc/error503.php';
    });
}

function loadDivs() {
  $('<div></div>').attr({ 'id': "titles", 'class': 'row' }).html('<h3>Categories<h3>').appendTo('#homePage');
  $('<div></div>').attr({ 'id': "containerCategories", 'class': 'row' }).appendTo('#homePage');
  $('<div></div>').attr({ 'id': "titles", 'class': 'row' }).html('<h3>Types<h3>').appendTo('#homePage');
  $('<div></div>').attr({ 'id': "containerTypes", 'class': 'row' }).appendTo('#homePage');


  loadSlider();
  loadCategory();
  loadType();
}

function clicking() {
  $(document).on("click", '.carousel__elements', function () {
    localStorage.removeItem('marca');
    localStorage.removeItem('category');
    localStorage.removeItem('type');
    var marca = [];
    marca.push({ "marca": [this.getAttribute('id')] });
    localStorage.setItem('marca', JSON.stringify(marca));
    setTimeout(function () {
      window.location.href = 'index.php?page=controller_shop&op=list';
    }, 500);
  });
  $(document).on("click", '.inner', function () {
    localStorage.removeItem('marca');
    localStorage.removeItem('category');
    localStorage.removeItem('type');
    console.log("click");
    console.log(this.getAttribute('id'));
    var category = [];
    category.push({ "category": [this.getAttribute('id')] });
    localStorage.removeItem('category')
    localStorage.setItem('category', JSON.stringify(category));
    setTimeout(function () {
      window.location.href = 'index.php?page=controller_shop&op=list';
    }, 500);
  });
  $(document).on("click", '.inner3', function () {
    localStorage.removeItem('marca');
    localStorage.removeItem('category');
    localStorage.removeItem('type');
    console.log("click");
    console.log(this.getAttribute('id'));
    var type = [];
    type.push({ "type": [this.getAttribute('id')] });
    localStorage.removeItem('type')
    localStorage.setItem('type', JSON.stringify(type));
    setTimeout(function () {
      window.location.href = 'index.php?page=controller_shop&op=list';
    }, 500);
  });

}

function loadnews() {

  $.ajax({
    type: "GET",
    url: "https://www.googleapis.com/books/v1/volumes?q=Vehicles",
    // url: "https://rickandmortyapi.com/api/character/?page=2",
    crossDomain: true,
    contentType: "application/json",

    success: function (data) {
      news = data;
      $('<h3><b>BOOKS</b></h3>').attr({ 'class': 'newtitle' }).appendTo('#homePage');
      newsfor();
    },
    error: function () {
      alert("ERROR NEWS");
    }
  });
}

function newsfor(num = 4) {
  let limit = num;
  let btton = 0;

  $('.news').remove();
  $('<div></div>').attr({ 'class': 'news' }).appendTo('#homePage');
  for (i = 0; i < limit; i++) {
    if (news.items[i] != undefined) {
      $('<div></div>').attr({ 'class': 'new', 'id': i }).html('<img src="' + news.items[i].volumeInfo.imageLinks.smallThumbnail + '">' +
        '</img>' + news.items[i].volumeInfo.title).appendTo('.news')
    } else {
      i = limit - 1;
      btton = 1;
    }
  }
  if (btton == 0) {
    $('<br><input></input>').attr({ 'class': 'btonmore', 'type': 'button', 'value': 'More' }).appendTo('.news');
  } else {
    $('.btonmore').remove();
  }
  $('#homePage').on("click", ".btonmore", function () {
    newsfor((limit + 4));
  })
  $('#homePage').on("click", ".new", function () {
    var id = this.getAttribute('id');
    window.open(news.items[id].volumeInfo.infoLink)
  })
}

var news = null;
$(document).ready(function () {
  loadDivs();
  clicking();
  loadnews();
  localStorage.removeItem('scroll');
});
