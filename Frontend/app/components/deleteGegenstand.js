app.component("deleteGegenstand", {
    templateUrl: "components/deleteGegenstand.html",
    controller: "deleteGegenstandController"
});

app.controller("deleteGegenstandController", function ($http) {
    this.submit = () => {
        let parameter = JSON.stringify({
            itemId: this.frm_itemId
        });

        let url = "../../Backend/usefulFunctions.php";

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