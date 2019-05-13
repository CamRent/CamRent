app.component("dialogBorrow", {
    templateUrl: "components/Dialog_Borrow.html",
    controller: "dialogBorrowController"
});

app.controller("dialogBorrowController", function ($http, $scope) {

    let url = "../../Backend/overviewOfAllItems.php";
    this.fulldescription = {};

    $http({
        method: 'POST',
        url: url
    }).then(
        (response) => {



        }, function (error) {
            console.log(error);
        });
});