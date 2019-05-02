app.component("listGegenstand", {
    templateUrl: "components/listGegenstand.html",
    controller: "listGegenstandController"
});

app.controller("listGegenstandController", function ($http) {

    let url = "../../Backend/overviewOfAllItems.php";
    this.items = {};

    $http({
        method: 'POST',
        url: url
    }).then(
        (response) => {
            console.log(response.data);
            this.items = response.data;
        }, function (error) {
            console.log(error);
        });
});