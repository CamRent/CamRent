app.component("createProject", {
    templateUrl: "components/create-project.html",
    controller: "createProjectController"
});

app.controller("createProjectController", function ($http) {
    this.submit = () => {
        let parameter = JSON.stringify({
            name: this.frm_name,
            available: ,
            teacherId: ,
            description:
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