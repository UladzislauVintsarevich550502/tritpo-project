$('input[type="registerSubmit"]').mousedown(function () {
    $(this).css('background', '#2ecc71');
});
$('input[type="registerSubmit"]').mouseup(function () {
    $(this).css('background', '#1abc9c');
});

$('#registerForm').mouseenter(function () {
    $(".login").hide();
    $('#loginForm').removeClass('loginGreen');

    $('.register').fadeToggle('slow');
    $(this).toggleClass('loginGreen');
});

$('#regbar').mouseleave(function (e) {
    $(".register").hide();
    $('#registerForm').removeClass('loginGreen');
});