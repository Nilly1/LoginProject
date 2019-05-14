$(document).ready(function () {
    "use strict";
    $("#submit").click(function () {

        var username = $("#username").val(), password = $("#password").val();
        username = username.trim();
        password = password.trim();

        if ((username === "") || (password === "")) {
            $("#message").html("<div class=\"alert alert-danger\">Please enter a username and a password</div>");
        } else if (!username.match("^[A-z0-9\_]+$") || !password.match("^[A-z0-9]+$")){
            $("#message").html("<div class=\"alert alert-danger\">Username and password contain only letters and numbers</div>");
        } else{
            $.ajax({
                type: "POST",
                url: "./php/checklogin.php",
                data: "username=" + username + "&password=" + password,
                dataType: 'json',
                success: function (response) {
                    if (response === true) {
                        location.href = '/LoginProject/php/connected.php'; // Login OK - display connected page
                    } else {
                        $("#message").html("<div class='alert alert-danger'>Incorrect username or password</div>");
                    }
                },
                error: function (textStatus, errorThrown) {
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });

        }
        return false;
    });
});
