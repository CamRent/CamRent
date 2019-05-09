app.component("login", {
    templateUrl: "components/login.html",
    controller: "LoginController"
});

app.controller("LoginController", function($http, $window, UserdataService){
    this.submit = () => {
        if(this.frm_email === undefined){
            this.info = "Bitte überprüfen Sie ihre Email-Adresse";
        }else if(this.frm_password === undefined){
            this.info = "Ihr Passwort muss mindestens 6 Zeichen lang sein";
        }
        else {
            let parameter = JSON.stringify({
                email: this.frm_email,
                password: this.frm_password
            });
            let url = "../../Backend/loginUser.php";

            $http({
                method: 'POST',
                url: url,
                data: parameter
            }).then(
                (response) => {

                    UserdataService.speichern(response.data.id, response.data.firstname, response.data.surname, response.data.priority, response.data.email);

                    if (response.data.id !== undefined) {
                        $window.location.href = 'profil.html';
                    }
                }, function (error) {
                    console.log(error);
                });
        }
    }
});