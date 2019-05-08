app.component("firstRegister", {
    templateUrl: "components/firstRegister.html",
    controller: "FirstRegisterController"
});

app.controller("FirstRegisterController", function ($http, $window) {
    this.submit = () => {
        let parameter = JSON.stringify({
            email: this.frm_email
        });

        let url = "../../Backend/firstRegister.php";

        $http({
            method: 'POST',
            url: url,
            data: parameter
        }).then(
            (response) => {
                this.info = "Es wurde Ihnen eine Email gesendet!";

            }, function (error) {
                console.log(error);
            });
    };
});