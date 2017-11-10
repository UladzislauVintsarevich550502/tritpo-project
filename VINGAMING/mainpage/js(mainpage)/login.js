$('input[type="loginSubmit"]').mousedown(function () {
    $(this).css('background', '#2ecc71');
});
$('input[type="loginSubmit"]').mouseup(function () {
    $(this).css('background', '#1abc9c');
});

$('#loginForm').mouseenter(function () {
    $(".register").hide();
    $('#registerForm').removeClass('loginGreen');

    $('.login').fadeToggle('slow');
    $(this).toggleClass('loginGreen');
});

$('#regbar').mouseleave(function (e) {
    $(".login").hide();
    $('#loginForm').removeClass('loginGreen');
});