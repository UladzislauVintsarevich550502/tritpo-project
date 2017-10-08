$('input[type="loginSubmit"]').mousedown(function () {
    $(this).css('background', '#2ecc71');
});
$('input[type="loginSubmit"]').mouseup(function () {
    $(this).css('background', '#1abc9c');
});

$('#loginForm').click(function () {
    $('.login').fadeToggle('slow');
    $(this).toggleClass('loginGreen');
});

$(document).mouseup(function (e) {
    var container = $(".login");

    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.hide();
        $('#loginForm').removeClass('loginGreen');
    }
});