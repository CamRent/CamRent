app.component("firstRegister", {
    templateUrl: "components/firstRegister.html",
    controller: "FirstRegisterController"
});

app.controller("FirstRegisterController", function ($http) {
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
                console.log(response);
                this.info = response.data.infotext;
            }, function (error) {
                console.log(error);
            });
    };
});