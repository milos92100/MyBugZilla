/**
 * Created by milos on 3.10.16..
 */
document.getElementById("myForm").addEventListener("submit", function (event) {
    event.preventDefault()
});

var $uploadCrop;
var imageSelected = false;

function register() {

    if (imageSelected == true) {

        $uploadCrop.croppie('result', {
            type: 'base64',
            size: 'viewport',
            circle: true,
        }).then(function (resp) {
            executeRequest(resp);

        });
    } else {
        executeRequest(null);
    }

}

function executeRequest(image) {

    if (image == null) {
        image = '';
    } else {
        image = image.split(',')[1];
    }

    var usernameInput = $('#UsernameInput').val();
    var passwordInput = $('#PasswordInput').val();
    var repeatPasswordInput = $('#RepeatPasswordInput').val();
    var emailInput = $('#EmailInput').val();
    var firstNameInput = $('#FirstNameInput').val();
    var lastNameInput = $('#LastNameInput').val();
    var phoneInput = $('#PhoneInput').val();
    var workPositionInput = $('#WorkPositionInput').val();

    if (usernameInput == ''
        || passwordInput == ''
        || repeatPasswordInput == ''
        || emailInput == ''
        || firstNameInput == ''
        || lastNameInput == ''
        || phoneInput == ''
        || workPositionInput == ''
    ) {
        bootbox.alert("Please fill all fields.");
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
            lastName: lastNameInput,
            phone: phoneInput,
            workPosition: workPositionInput,
            image: image
        },
        dataType: 'json',
        success: function (data) {
            globalProgressBarEnd();
            bootbox.alert(data.msg, function () {
                if (data.success) {
                    window.location.href = window.location.origin + "/admin_panel/users";
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
    $("#myForm").find("input[type=text], input[type=password], input[type=file], textarea").val("");

    imageSelected = false;
    $uploadCrop.croppie('bind', {
        url: "",
    }).then(function () {
        console.log('jQuery bind complete');
    });
}


function previewFile() {

    var file = document.querySelector('input[type=file]').files[0]; //sames as here
    var reader = new FileReader();

    reader.onloadend = function () {

        $uploadCrop.croppie('bind', {
            url: reader.result
        }).then(function () {
            imageSelected = true;
            console.log('jQuery bind complete');
        });
    }

    if (file) {
        reader.readAsDataURL(file); //reads the data as a URL
    } else {
        preview.src = "";
    }
}

$(document).ready(function () {

    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 200,
            height: 200,
            type: 'circle'
        },

        enableExif: true
    });


});
