function signout() {
    $.ajax({
        type: 'POST',
        url: "/logout",
        data: {},
        dataType: 'json',
        success: function (data) {
            window.location.href = window.location.origin;
        },
        error: function (e) {
            window.location.href = window.location.origin;
        }
    });
}