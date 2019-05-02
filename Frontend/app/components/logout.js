app.component("logout", {
    templateUrl: "components/logout.html",
    controller: "LogoutController"
});

app.controller("LogoutController", function ($log, $http, $window) {
    $log.debug("LogoutController()");


    this.$onInit = () => {
        this.getStatus();
    };


    this.getStatus = () => {
        $http
            .get('../../Backend/isLoggedIn.php')
            .then(response => {
                $log.debug("Response = ", response);

                this.data = response.data;
                this.status =  this.data.isLoggedIn;
                console.log(this.status  + "status set");
            })
            .catch(response => {
                $log.error("Da ist etwas nicht so gut gelaufen: " + response);
            });
    };






    this.submit = () => {

        this.getStatus();
        if (this.status)  {
            let url = "../../Backend/logoutUser.php";

            $http({
                method: 'POST',
                url: url
            });

            $window.location.href = "index.html";


        }
        else {
            $window.location.href = "login.html";
        }




    };



});