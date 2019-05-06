app.component("login", {
    templateUrl: "components/login.html",
    controller: "LoginController"
});

app.controller("LoginController", function($http, $window, $rootScope){
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
                    console.log(response.data);
                    $rootScope.id = response.data.id;
                    $rootScope.firstname = response.data.firstname;
                    $rootScope.surname = response.data.surname;
                    $rootScope.priority = response.data.priority;
                    $rootScope.email = response.data.email;
                    if($rootScope.id !== undefined){
                        $window.location.href = 'profil.html';
                    }
                }, function (error) {
                    console.log(error);
                });
        }
    }
});