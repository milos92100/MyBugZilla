console.log("login.js loaded");

function login() {


    var usernameInput = $('#inputUsername').val();
    var passwordInput = $('#inputPassword').val();

    if (usernameInput == "" || usernameInput == null || usernameInput == undefined) {
        bootbox.alert("Username not entered");
        return;
    }

    if (passwordInput == "" || passwordInput == null || passwordInput == undefined) {
        bootbox.alert("Password not entered");
        return;
    }

    globalProgressBarStart();

    $.ajax({
        type: 'POST',
        url: "/authenticate",
        data: {
            username: usernameInput,
            password: passwordInput
        },
        dataType: 'json',
        success: function (data) {
            globalProgressBarEnd();

            if (data.success) {
                bootbox.alert(data.data.message, function () {
                    if (data.data.accessGranted) {
                        window.location.href = window.location.origin + "/";
                    }
                });


            } else {
                bootbox.alert(data.msg);
            }

        },
        error: function (e) {
            globalProgressBarEnd();
            bootbox.alert(e.responseText);
        }
    });

}