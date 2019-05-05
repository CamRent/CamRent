app.component("listGegenstand", {
    templateUrl: "components/listGegenstand.html",
    controller: "listGegenstandController"
});

app.controller("listGegenstandController", function ($http, $scope, $mdDialog) {

    let url = "../../Backend/overviewOfAllItems.php";
    this.items = {};
    this.fulldescription = {};

    $http({
        method: 'POST',
        url: url
    }).then(
        (response) => {
            console.log(response.data);
            for (let i = 0; i < response.data.length; i++) {
                if (response.data[i].available === 1) {
                    response.data[i].available = "Vergeben";
                } else {
                    response.data[i].available = "Frei";
                }

                if (response.data[i].description.length > 100) {
                    this.fulldescription[i] = response.data[i].description;
                    console.log(this.fulldescription[i]);
                    response.data[i].description = response.data[i].description.slice(0, 100) + " ...";
                } else {
                    this.fulldescription[i] = response.data[i].description;
                }
            }
            this.items = response.data;
        }, function (error) {
            console.log(error);
        });

    this.submit = (i) => {
        $mdDialog.show(
            $mdDialog.alert()
                .title(this.items[i].name)
                .content(this.fulldescription[i])
        );
    };
});