function validate_register() {
  var mail_exp = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
  var error = false;

  if (document.getElementById('username').value.length === 0) {
    document.getElementById('error_username').innerHTML = "Tienes que escribir el usuario";
    error = true;
  } else {
    if (document.getElementById('username').value.length < 1) {
      document.getElementById('error_username').innerHTML = "El username tiene que tener 8 caracteres como minimo";
      error = true;
    } else {
      document.getElementById('error_username').innerHTML = "";
    }
  }

  if (document.getElementById('email').value.length === 0) {
    document.getElementById('error_email').innerHTML = "Tienes que escribir un correo";
    error = true;
  } else {
    if (!mail_exp.test(document.getElementById('email').value)) {
      document.getElementById('error_email').innerHTML = "El formato del mail es invalido";
      error = true;
    } else {
      document.getElementById('error_email').innerHTML = "";
    }
  }

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

  if (error == true) {
    return 0;
  }
}

function register() {
  if (validate_register() != 0) {
    var data = $('#register__form').serialize();
    ajaxPromise("?page=login&op=register",
      'POST', 'JSON', data)
      .then(function (data) {
        console.log(data);
        if (data == "errorusr") {
          document.getElementById('error_username').innerHTML = "User ya creado";
        }
        if (data == "errorem") {
          document.getElementById('error_email').innerHTML = "Email ya creado";
        }
        if (data == "ok") {
          toastr['warning']("Please verify your email");
          toastr['success']("User registered successfully");
          setInterval('location.href = "?page=home&op=list";', 3000);
        }
      });
  }
}

function clicking() {
  $('#register__form').on("click", "#register", function () {
    register();
  });
  $("#register__form").keypress(function (e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    if (code == 13) {
      e.preventDefault();
      register();
    }
  });
}



$(document).ready(function () {
  // $("html, body").animate({scrollTop: $('#scroll').offset().top }, 1000);
  clicking();
  // registerform();

});
