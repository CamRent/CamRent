app.component("listBorrowedItems", {
    templateUrl: "components/listBorrowedItems.html",
    controller: "listBorrowedItemsController"
});

app.controller("listBorrowedItemsController", function ($http, $scope, $mdDialog, UserdataService, $window) {

    this.Userdata = UserdataService.laden();
    this.UserId = parseInt(this.Userdata[0]);

    let parameter = JSON.stringify({
        userId: this.UserId
    });

    let url = "../../Backend/profileList.php";
    this.items = {};
    this.fulldescription = {};

    $http({
        method: 'POST',
        url: url,
        data: parameter
    }).then(
        (response) => {

            console.log(response);

            for (let i = 0; i < response.data.length; i++) {
                if (response.data[i].available === 1) {
                    response.data[i].available = "Ausgeborgt";
                } else {
                    response.data[i].available = "Frei";
                }

                if (response.data[i].description.length > 100) {
                    this.fulldescription[i] = response.data[i].description;
                    response.data[i].description = response.data[i].description.slice(0, 100) + " ...";
                } else {
                    this.fulldescription[i] = response.data[i].description;
                }
            }
            this.items = response.data;
        }, function (error) {
            console.log(error);
        });

    this.submit = (i, itemId, ev) => {
        let parameter = JSON.stringify({
            itemId: itemId
        });

        let url = "../../Backend/returnTrueNotAvailable.php";

        $http({
            method: 'POST',
            url: url,
            parameter: parameter
        }).then(
            (response) => {
                console.log(response.data)

                if (response.data.notAvailable === true) {
                    $mdDialog.show(
                        $mdDialog.confirm()
                            .clickOutsideToClose(true)
                            .title(this.items[i].name)
                            .textContent(this.fulldescription[i])
                            .targetEvent(ev)
                            .ok("Zurückgeben")
                    ).then(
                        this.zurückgeben = () => {
                            console.log(itemId);

                            let parameter = JSON.stringify({
                                itemId: itemId
                            });

                            let url = "../../Backend/returnItem.php";

                            $http({
                                method: 'POST',
                                url: url,
                                data: parameter
                            }).then(
                                (response) => {

                                    console.log(response.data);

                                    if (response.data.status === "201") {
                                        $window.location.reload();
                                    }
                                })
                        }
                    )
                }
            });
    };
});