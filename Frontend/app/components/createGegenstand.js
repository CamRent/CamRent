app.component("createGegenstand", {
    templateUrl: "components/createGegenstand.html",
    controller: "createGegenstandController"
});

app.controller("createGegenstandController", function ($http, $mdDialog, UserdataService, $window) {
    this.submit = () => {

        this.itemname = undefined;
        this.description = undefined;


        $mdDialog.show(
            $mdDialog.prompt()
                .title('Geben Sie eine Itemnamen ein!')
                .placeholder('Itemname')
                .required(true)
                .ok('Weiter')
                .cancel('Abbrechen')
        ).then(
            function (result) {
                this.itemname = result;

                $mdDialog.show(
                    $mdDialog.prompt()
                        .title('Geben Sie eine Beschreibung ein!')
                        .placeholder('Beschreibung')
                        .required(true)
                        .ok('Erstellen')
                        .cancel('Abbrechen')
                ).then(function (result) {

                        this.description = result;

                        this.Userdata = UserdataService.laden();

                        let parameter = JSON.stringify({
                            name: this.itemname,
                            description: this.description,
                            teacherId: parseInt(this.Userdata[0])
                        });

                        let url = "../../Backend/addItem.php";

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
            }
        )
    };
});