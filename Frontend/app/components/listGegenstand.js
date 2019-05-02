app.component("listGegenstand", {
    templateUrl: "components/listGegenstand.html",
    controller: "listGegenstandController"
});

app.controller("listGegenstandController", function ($http) {
    this.submit = () => {
        let parameter = JSON.stringify({
            name: this.frm_name,
            description: this.frm_description
        });

        let url = "../../Backend/overviewOfAllItems.php";

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