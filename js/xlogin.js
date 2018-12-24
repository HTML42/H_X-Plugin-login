var Xtreme_startup_calls = Xtreme_startup_calls || [];
Xtreme_startup_calls.push(function () {
    $('form[data-xlogin]').each(function() {
        $(this).submit(function(event) {
            event.preventDefault();
            var data = $(this).serialize();
            console.log('LOGIN', data);
            return false;
        });
    });
});
