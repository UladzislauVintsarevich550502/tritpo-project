$(document).ready(function () {
    $(document).on('click', '#button_auth', function () {
        var authentication = "authentication";
        var send_login;
        var send_password;
        var auth_remember_me;
        var auth_login = $("#loginEmail").val();
        var auth_password = $("#loginPassword").val();
        if (auth_login == "")
            send_login = 'no';
        else
            send_login = 'yes';
        if (auth_password == "")
            send_password = 'no';
        else
            send_password = 'yes';
        if ($("#remember_me").prop('checked'))
            auth_remember_me = 'yes';
        else
            auth_remember_me = 'no';
        if (send_login == 'yes' && send_password == 'yes') {
            $.ajax({
                type: "post",
                url: "../php_include/auth.php",
                data: "login=" + auth_login + "&password=" + auth_password + "&remember_me=" + auth_remember_me + "&authentication=" + authentication,
                dataType: "html",
                cache: false,
                success: function (data) {
                    if (data == 'yes_auth')
                        location.reload();
                }
            });
        }
    });

    $(document).on('click', '#logout', function () {
        var logout = "logout";
        $.ajax({
            type: "post",
            url: "../php_include/auth.php",
            data: "logout=" + logout,
            dataType: "html",
            cache: false,
            success: function (data) {
                if (data == 'logout')
                    location.reload();
            }
        });
    });
});