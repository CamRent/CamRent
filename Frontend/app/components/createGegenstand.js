app.component("createGegenstand", {
    templateUrl: "components/createGegenstand.html",
    controller: "createGegenstandController"
});

app.controller("createGegenstandController", function ($http) {
    this.submit = () => {
        let parameter = JSON.stringify({
            name: this.frm_name,
            description: this.frm_description
        });

        let url = "../../Backend/addItem.php";

        $http({
            method: 'POST',
            url: url,
            data: parameter
        }).then(
            (response) => {
                console.log(response);
            }, function (error) {
                console.log(error);
            });
    };
});