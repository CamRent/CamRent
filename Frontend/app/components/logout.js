app.component("logout", {
    templateUrl: "components/logout.html",
    controller: "LogoutController"
});

app.controller("LogoutController", function ($log, $http) {
    $log.debug("LogoutController()");

    this.submit = () => {

        let url = "../../Backend/logoutUser.php";

        $http({
            method: 'POST',
            url: url
        });

        location.reload();

    };
});