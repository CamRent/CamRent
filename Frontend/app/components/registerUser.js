app.component("registerUser", {
    templateUrl: "components/registerUser.html",
    controller: "registerUserController"
});

app.controller("registerUserController", function($http) {
    let url = document.URL.split("?")[1];
    let email = url.split("&")[0].split("=")[1];
    let activationCode = url.split("&")[1].split("=")[1];
    console.log(email);
    console.log(activationCode);

    this.submit = () => {
        if(this.frm_password !== this.frm_passwordcheck){
            this.info = "Ihre Passwörter stimmen nicht überein";
        }
        else {
            let parameter = JSON.stringify({
                firstname: this.frm_firstname,
                surname: this.frm_surname,
                password: this.frm_password,
                email: email,
                activationCode: activationCode
            });

            let url = "../../Backend/registerUser.php";

            $http({
                method: 'POST',
                url: url,
                data: parameter
            }).then(
                (response) => {
                    console.log(response);
                    this.info = response.data.infotext;
                }, function (error) {
                    console.log(error);
                });
        }
    };
});