app.component("listAvailableGegenstand", {
    templateUrl: "components/listAvailableGegenstand.html",
    controller: "listAvailableGegenstandController"
});

app.controller("listAvailableGegenstandController", function ($http) {

    let url = "../../Backend/AllAvailableItems.php";
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