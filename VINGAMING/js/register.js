$('input[type="button"]').mousedown(function () {
    $(this).css('background', '#2ecc71');
});
$('input[type="button"]').mouseup(function () {
    $(this).css('background', '#1abc9c');
});

$('#registerForm').click(function () {
    $('.register').fadeToggle('slow');
    $(this).toggleClass('loginGreen');
});

$(document).mouseup(function (e) {
    var container = $(".register");

    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.hide();
        $('#registerForm').removeClass('loginGreen');
    }
});