app.component("listGegenstand", {
    templateUrl: "components/listGegenstand.html",
    controller: "listGegenstandController"
});

app.controller("listGegenstandController", function ($http, $scope, $mdDialog, UserdataService, $window) {

    let url = "../../Backend/overviewOfAllItems.php";
    this.items = {};
    this.fulldescription = {};

    $http({
        method: 'POST',
        url: url
    }).then(
        (response) => {
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

        let url = "../../Backend/isLoggedIn.php";

        $http({
            method: 'POST',
            url: url
        }).then(
            (response) => {

                if (response.data.isLoggedIn === false) {
                    $mdDialog.show(
                        $mdDialog.confirm()
                            .clickOutsideToClose(true)
                            .title(this.items[i].name)
                            .textContent(this.fulldescription[i])
                            .targetEvent(ev)
                            .cancel("Abbrechen")
                    ).then();
                } else {

                    let url = "../../Backend/switchBorrowDelete.php";

                    $http({
                        method: 'POST',
                        url: url,
                        data: parameter
                    }).then(
                        (response) => {
                            if (response.data.bool === true) {
                                $mdDialog.show(
                                    $mdDialog.confirm()
                                        .clickOutsideToClose(true)
                                        .title(this.items[i].name)
                                        .textContent(this.fulldescription[i])
                                        .targetEvent(ev)
                                        .ok("Löschen")
                                        .cancel("Abbrechen")
                                ).then(
                                    this.delete = () => {
                                        let parameter = JSON.stringify({
                                            itemId: itemId
                                        });

                                        let url = "../../Backend/deleteItem.php";

                                        $http({
                                            method: 'POST',
                                            url: url,
                                            data: parameter
                                        }).then(
                                            (response) => {
                                                if (response.data.status === "201") {
                                                    $window.location.reload();
                                                }
                                            }, function (error) {
                                                console.log(error);
                                            });
                                    }
                                )

                            } else if (response.data.bool === false) {

                                console.log(itemId);

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
                                        console.log(response.data);

                                        if (response.data.notAvailable === true) {
                                            $mdDialog.show(
                                                $mdDialog.confirm()
                                                    .clickOutsideToClose(true)
                                                    .title(this.items[i].name)
                                                    .textContent(this.fulldescription[i])
                                                    .targetEvent(ev)
                                                    .ok("Zurückgeben")
                                                    .cancel("Abbrechen")
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
                                        } else {
                                            $mdDialog.show(
                                                $mdDialog.confirm()
                                                    .clickOutsideToClose(true)
                                                    .title(this.items[i].name)
                                                    .textContent(this.fulldescription[i])
                                                    .targetEvent(ev)
                                                    .ok("Ausborgen")
                                                    .cancel("Abbrechen")
                                            ).then(
                                                this.ausleihen = () => {

                                                    this.Userdata = UserdataService.laden();
                                                    this.UserId = parseInt(this.Userdata[0]);

                                                    console.log(this.UserId);
                                                    console.log(itemId);

                                                    let parameter = JSON.stringify({
                                                        userId: this.UserId,
                                                        itemId: itemId
                                                    });

                                                    let url = "../../Backend/rentItem.php";

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
                            }
                        });
                }
            });

        this.Userdata = UserdataService.laden();
        this.UserId = parseInt(this.Userdata[0]);

        let parameter = JSON.stringify({
            userId: this.UserId,
            itemId: itemId
        });
    };
});