function load_menu() {
    $('<li></li>').attr({ 'class': 'nav__item' }).html('<a href="index.php?page=home&op=list" data-tr="Inicio">Home</a>').appendTo('#nav_op');
    $('<li></li>').attr({ 'class': 'nav__item' }).html('<a href="index.php?page=shop&op=list" data-tr="Shop">Shop</a>').appendTo('#nav_op');
    $('<li></li>').attr({ 'class': 'nav__item' }).html('<a href="index.php?page=contact&op=view" data-tr="Contact">Contact</a>').appendTo('#nav_op');

    if (localStorage.getItem('token') == null) {
        $('<li></li>').attr({ 'class': 'nav__item' }).html('<a href="index.php?page=login&op=viewreg" data-tr="Sign in">Sign in</a>').appendTo('#nav_op');
        $('<li></li>').attr({ 'class': 'nav__item login' }).html('<a href="index.php?page=login&op=viewlog" data-tr="Login">Login</a>').appendTo('#nav_op');
    } else {
        logged();
        // $('<li></li>').attr({'class' : 'nav__item', 'id' : 'logout'}).html('<a href="#" data-tr="Logout">Logout</a>').appendTo('#nav_op');
    }
    // ajaxPromise('module/login/controller/controller_logIn.php?op=data_user', 'POST', 'JSON',{token: localStorage.getItem('token')})
    // .then(function(data) {
    //     if (data.type === 'admin') {
    //         menu_admin();
    //     }else if (data.type === 'client') {
    //         menu_client();
    //     }
    // }).catch(function() {
    //     $('<li></li>').attr({'class' : 'nav__item'}).html('<a href="index.php?page=controller_login&op=login_view" class="nav__link">Log in</a>').appendTo('.nav__list');
    //     $('<li></li>').attr({'class' : 'nav__item'}).html('<a href="index.php?page=controller_cart&op=view" class="nav__link">Cart</a>').appendTo('.nav__list');
    // });
}

function logged() {
    ajaxPromise('?page=login&op=data_user', 'POST', 'JSON', { token: localStorage.getItem('token') })
        .then(function (data) {

            $('<li></li>').attr({ 'class': 'nav__item' }).html('<img src="' + data[0].avatar + '" class="avatar"></img>').appendTo('#nav_op');
            $('<li></li>').attr({ 'class': 'nav__item' }).html('<a class="user">' + data[0].username + '</a>').appendTo('#nav_op');
            $('<li></li>').attr({ 'class': 'nav__item', 'id': 'logout' }).html('<a href="#" data-tr="Logout">Logout</a>').appendTo('#nav_op');

        })
}

function clicks() {
    $(document).on('click', '#logout', function () {
        localStorage.removeItem('token');
        location.reload();
    });

    $(document).on('click', '.user', function () {
        toastr["error"]("No se puede ver el profile", "ERROR");
    });

    $(document).on('click', '.login', function () {
        localStorage.removeItem('callback')
    });
}

$(document).ready(function () {
    load_menu();
    clicks();
});