/**
 * Created by milos on 3.10.16..
 */
document.getElementById("myForm").addEventListener("click", function (event) {
    event.preventDefault()
});


function register() {

    var usernameInput = $('#UsernameInput').val();
    var passwordInput = $('#PasswordInput').val();
    var repeatPasswordInput = $('#RepeatPasswordInput').val();
    var emailInput = $('#EmailInput').val();
    var firstNameInput = $('#FirstNameInput').val();
    var lastNameInput = $('#LastNameInput').val();

    if (usernameInput == ''
        || passwordInput == ''
        || repeatPasswordInput == ''
        || emailInput == ''
        || firstNameInput == ''
        || lastNameInput == ''
    ) {
        bootbox.alert("Fill all fields");
        return;
    }

    if (passwordInput != repeatPasswordInput) {
        bootbox.alert("The entered passwords do not match.");
        return;
    }

    globalProgressBarStart();

    $.ajax({
        type: 'POST',
        url: "/register_new_user",
        data: {
            username: usernameInput,
            password: passwordInput,
            repeatPassword: repeatPasswordInput,
            email: emailInput,
            firstName: firstNameInput,
            lastName: lastNameInput
        },
        dataType: 'json',
        success: function (data) {
            globalProgressBarEnd();
            bootbox.alert(data.msg, function () {
                if (data.success) {
                    window.location.href = window.location.origin;
                }
            });

        },
        error: function (e) {
            globalProgressBarEnd();
            bootbox.alert(e.responseText);

        }
    });
}

function resetForm() {

    $("#myForm").find("input[type=text], input[type=password], textarea").val("");

}