function logout() {
    ajaxPromise('?page=login&op=logout', 'POST', 'JSON')
    // setInterval(function(){
    localStorage.removeItem('token');
    location.reload();
    // },3000);

}

function refresh() {
    ajaxPromise('?page=login&op=refresh_token',
        'POST', 'JSON', { 'token': localStorage.getItem('token') })
        .then(function (data) {
            localStorage.setItem('token', data);
        });
    ajaxPromise('?page=login&op=refresh_cookie',
        'POST', 'JSON')
        .then(function (data) {
            console.log(data);
        })
}

function protecturl() {
    ajaxPromise('?page=login&op=controluser',
        'POST', 'JSON', { 'token': localStorage.getItem('token') })
        .then(function (data) {
            if (data == 'nookay') {
                toastr['error']("Ha habido algun problema con el usuario");
                setInterval(function () {
                    logout();
                }, 3000);
            } else if (data == 'okay') {
                console.log("okay");
            }
        }).catch(function () {
            toastr['error']("Ha habido algun problema con el usuario");
            setInterval(function () {
                logout();
            }, 3000);
        })
}

function activity() {
    ajaxPromise('?page=login&op=actividad',
        'GET', 'JSON')
        .then(function (response) {
            if (response == 'timepo') {
                logout();
            }
            else if (response == "inactivo") {
                toastr['warning']("Se ha cerrado la cuenta por inactividad");
                //setTimeout('window.location.href = "index.php?page=controller_login&op=logout";',1000);
                setInterval(function () {

                    logout();
                }, 1000);
            }
        });
}

$(document).ready(function () {

    if (localStorage.getItem('token')) {
        protecturl();
        setInterval(function () {
            activity();
            protecturl();
        }, 10000);
        setInterval(function () {
            refresh();
        }, 60000);

    }

});