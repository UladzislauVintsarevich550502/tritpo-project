var $name = "default";

function setName($new_name) {
    $name = $new_name;
}

$('#scoreForm').mouseenter(function () {
    if($name!="default") {
        if ($name == "2048") {
            $.ajax({
                type: "post",
                url: "../php_include/getScore.php",
                data: "type=2048Score",
                dataType: "html",
                cache: false,
                success: function (data) {
                    var arr = data.split(" ");
                    $('#win').text(arr[0].toString());
                    $('#loose').text(arr[1].toString());
                }
            });
        }
        if ($name == "1") {
            $.ajax({
                type: "post",
                url: "../php_include/getScore.php",
                data: "type=SapperScore",
                dataType: "html",
                cache: false,
                success: function (data) {
                    var arr = data.split(" ");
                    $('#win').text(arr[0].toString());
                    $('#loose').text(arr[1].toString());
                }
            });
        }
        if (!$('.score').is(':visible')) {
            $('.score').fadeToggle('slow');
            $(this).toggleClass('scoreGreen');
        }
    }
});

$('#scoreForm').mouseleave(function () {
    if ($('.score').is(':visible')) {
        $('.score').fadeToggle('slow');
        $('#scoreForm').removeClass('scoreGreen');
    }
});