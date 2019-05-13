app.component("dialogBorrow", {
    templateUrl: "components/Dialog_Borrow.html",
    controller: "dialogBorrowController"
});

app.controller("dialogBorrowController", function ($http, UserdataService) {

    this.array = UserdataService.loadDialogBorrow();

    console.log(this.array[0]);
});