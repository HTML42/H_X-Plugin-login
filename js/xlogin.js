var Xtreme_startup_calls = Xtreme_startup_calls || [];
Xtreme_startup_calls.push(function () {
    $('form[data-xlogin="login"]').each(function () {
        $(this).submit(function (event) {
            event.preventDefault();
            $.post(_xl_url('login'), $(this).serialize(), function (response) {
                if (response.status == 200) {
                    X_LOGIN_ID = response.response.userid;
                    X_LOGIN_USER = response.response.user
                    if (typeof window.xlogin_callback_login == 'function') {
                        window.xlogin_callback_login(response);
                    }
                } else {
                    alert(response.errors.join("\n"));
                }
            }, "json");
            return false;
        });
        $(this).find('.xlogin_logoutlink').click(function () {
            $.get(_xl_url('logout'), function () {
                if (typeof window.xlogin_callback_logout == 'function') {
                    window.xlogin_callback_logout();
                }
            });
        });
    });
    $('form[data-xlogin="signup"]').each(function () {
        $(this).submit(function (event) {
            event.preventDefault();
            $.post(_xl_url('signup'), $(this).serialize(), function (response) {
                if (response.status == 200) {
                    X_LOGIN_ID = response.response.userid;
                    X_LOGIN_USER = response.response.user
                    if (typeof window.xlogin_callback_signup == 'function') {
                        window.xlogin_callback_signup(response);
                    }
                } else {
                    alert(response.errors.join("\n"));
                }
            }, "json");
            return false;
        });
    });
});

function _xl_url(filename) {
    return 'plugins/login/ajax/' + filename + '.php';
}
