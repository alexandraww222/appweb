
$(document).ready(function () {
    $('#loginForm').submit(function (e) {
        e.preventDefault(); 
        var email = $('#email').val();
        var password = $('#password').val();
        alert('Inicio de sesión exitoso. Email: ' + email);
    });
});
$('.carousel').carousel();
