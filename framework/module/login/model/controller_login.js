function login() {
    if (validate_login() != 0) {
        var data = $('#login__form').serialize();
        ajaxPromise("?page=login&op=login",
            'POST', 'JSON', data)
            .then(function (data) {
                console.log(data);
                if (data == "error_passwd") {
                    $("#error_password").html('La contraseña no es correcta');
                } else {
                    localStorage.setItem("token", data);
                    toastr['success']("User logged successfully");
                    if (localStorage.getItem('callback')) {
                        location.href = localStorage.getItem('callback');
                    } else {
                        location.href = "index.php?page=home&op=list";
                    }
                }
            })
        // .catch(function( textStatus ) {
        //     if ( console && console.log ) {
        //         console.log( "La solicitud ha fallado: " +  textStatus);
        //     }
        // });     
    }
}

function validate_login() {
    var error = false;

    if (document.getElementById('username').value.length === 0) {
        document.getElementById('error_username').innerHTML = "Tienes que escribir el usuario";
        error = true;
    } else {
        document.getElementById('error_username').innerHTML = "";
    }

    if (document.getElementById('password').value.length === 0) {
        document.getElementById('error_password').innerHTML = "Tienes que escribir la contraseña";
        error = true;
    } else {
        document.getElementById('error_password').innerHTML = "";
    }

    if (error == true) {
        return 0;
    }
}

function send_recover(email) {
    ajaxPromise("?page=login&op=recover",
        'POST', 'JSON', { 'email': email })
        .then(function (data) {
            console.log(data);
        });
}

function validate_email() {
    var mail_exp = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    var error = false;
    if (document.getElementById('recover_email').value.length === 0) {
        document.getElementById('error_recemail').innerHTML = "Tienes que escribir un correo";
        error = true;
    } else {
        if (!mail_exp.test(document.getElementById('recover_email').value)) {
            document.getElementById('error_recemail').innerHTML = "El formato del mail es invalido";
            error = true;
        } else {
            document.getElementById('error_recemail').innerHTML = "";
        }
    }
    return error;
}

function validate_password() {
    var error = false;
    if (document.getElementById('password').value.length === 0) {
        document.getElementById('error_password').innerHTML = "Tienes que escribir la contraseña";
        error = true;
    } else {
        if (document.getElementById('password').value.length < 8) {
            document.getElementById('error_password').innerHTML = "La password tiene que tener 8 caracteres como minimo";
            error = true;
        } else {
            document.getElementById('error_password').innerHTML = "";
        }
    }
    return error;
}

function recover() {
    $('#login__form').empty();
    $('<div></div>').attr('id', "recover").html(
        '<br/>' +
        '<br/>' +
        '<br/>' +
        '<h1>Enter your email</h1>' +
        '<input type="text" id="recover_email"></input>' +
        '<span id="error_recemail" class="error"></span>' +
        '<br/>' +
        '<input type="button" id="recover_btn" value="Recover"></input>'
    ).appendTo('#login__form')
}

function clicking() {
    $('#login__form').on("click", "#login", function () {
        login();
    });
    $("#login__form").keypress(function (e) {
        console.log("aaa");
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            e.preventDefault();
            login();

        }
    });

    $('#login__form').on("click", "#recover_btn", function () {
        $.each($("input[id='recover_email']"), function () {
            var em_val = validate_email();
            if (em_val == false) {
                send_recover($(this).val());
            }
        });
    });

    $('#login__form').on("click", ".recover", function () {
        recover();
    })
    $('#login__form').on("click", "#register", function () {
        location.reload();
        location.href = "index.php?page=login&op=viewreg";
    })

    $('#login__form').on("click", "#recoverpass_btn", function () {
        var pass1 = null;
        var pass2 = null;
        $.each($("input[id='password']"), function () {
            pass1 = $(this).val();
        });
        $.each($("input[id='password2']"), function () {
            pass2 = $(this).val();
        });
        if (pass1 == pass2) {
            var pass_val = validate_password(pass1);
            if (pass_val == false) {
                recover_password(pass1);
                // setTimeout('window.location.href = "?page=login&op=viewreg";', 1500);
            }
        } else {
            document.getElementById('error_password').innerHTML = "Not the same password";
        }
    });

    // $('#login__form').on("click", "#botonlogin", function () {
    //     sl_gmail();
    // });

    $('#login__form').on("click", "#botonl", function () {
        sl_github();
    });


}

function load_content() {
    let path = window.location.search.split('&');
    console.log(path);
    if (path[3] === 'recover') {
        console.log("recover");
        load_newpasswd();
    } else if (path[3] === 'verify') {
        console.log("verifyyy");
        ajaxPromise('?page=login&op=update_activate', 'POST', 'JSON', { token: path[2] })
            .then(function (data) {
                toastr['success']("Email verified");
            });
    }
}

function sl_gmail() {
    var config = {
        apiKey: "AIzaSyBTcYCXwCVU0TjnIQzmTUpEhtdijTvPtJY",
        authDomain: "concessionaire-santidaw.firebaseapp.com",
        databaseURL: "https://concessionaire-santidaw.firebaseio.com",
        projectId: "concessionaire-santidaw",
        storageBucket: "",
        messagingSenderId: "613764177727"
    };

    firebase.initializeApp(config);

    var provider = new firebase.auth.GoogleAuthProvider();
    provider.addScope('email');

    var authService = firebase.auth();

    // manejador de eventos para loguearse
    document.getElementById('botonsl_gmail').addEventListener('click', function () {
        authService.signInWithPopup(provider)
            .then(function (result) {
                console.log(result.user.uid);

                ajaxPromise("?page=login&op=sl_gmail",
                    'POST', 'JSON', { 'id': result.user.uid, 'username': result.user.displayName, 'avatar': result.user.photoURL })
                    .then(function (data) {
                        localStorage.setItem('token', data);
                        location.href = "index.php?page=home&op=list";
                    });
                // console.log('Hemos autenticado al usuario ', result.user);
                // console.log(result.user.displayName);
                // console.log(result.user.email);
                // console.log(result.user.photoURL);
            })
            .catch(function (error) {
                console.log('Se ha encontrado un error:', error);
            });
    })
}

function recover_password(pass) {
    let path = window.location.search.split('&');

    ajaxPromise("?page=login&op=recover_pass",
        'POST', 'JSON', { 'token_email': path[2], 'pass': pass })
        .then(function (data) {
            console.log(data);
        });
}

function sl_github() {
    // Initialize Firebase
    // var config = {
    //     apiKey: "AIzaSyBTcYCXwCVU0TjnIQzmTUpEhtdijTvPtJY",
    //     authDomain: "concessionaire-santidaw.firebaseapp.com",
    //     databaseURL: "https://concessionaire-santidaw.firebaseio.com",
    //     projectId: "concessionaire-santidaw",
    //     storageBucket: "",
    //     messagingSenderId: "613764177727"
    //   };
    //   console.log("apaa");

    //   firebasegh.initializeApp(config);

      var provider = new firebase.auth.GithubAuthProvider();
      var authService = firebase.auth();

      document.getElementById('botonsl_github').addEventListener('click', function() {
          authService.signInWithPopup(provider)
          .then(function(result) {
            ajaxPromise("?page=login&op=sl_github",
            'POST', 'JSON', { 'id': result.user.uid, 'username': result.user.displayName, 'avatar': result.user.photoURL })
            .then(function (data) {
                localStorage.setItem('token', data);
                location.href = "index.php?page=home&op=list";
            });
          })
        //   .catch(function(error) {
        //     var errorCode = error.code;
        //     console.log(errorCode);
        //     var errorMessage = error.message;
        //     console.log(errorMessage);
        //     var email = error.email;
        //     console.log(email);
        //     var credential = error.credential;
        //     console.log(credential);
        //   });
      })
}
function load_newpasswd() {
    $('#login__form').empty();
    console.log("neww");
    $('<div></div>').attr('class', 'recover_pass').html(
        '<div class="form__input">' +
        '<label for="password"><b>Password</b></label>' +
        '<input type="password" placeholder="Enter New Password" id="password" name="password" required>' +
        '<input type="password" placeholder="Re enter New Password" id="password2" name="password2" required>' +
        '<font color="red">' +
        '<span id="error_password" class="error"></span>' +
        '</font>' +
        '<br/>' +
        '<br/>' +
        '<input type="button" id="recoverpass_btn" value="Recover"></input>' +
        '</div>'
    ).appendTo('#login__form');
}

$(document).ready(function () {
    // $("html, body").animate({scrollTop: $('#scroll').offset().top }, 1000);
    clicking();
    load_content();
    sl_gmail();
    sl_github();

    // console.log("holaaa");

});