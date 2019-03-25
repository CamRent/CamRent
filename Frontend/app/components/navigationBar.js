app.component("navigationBar", {
    templateUrl: "components/navigationBar.html",
    controller: "navigationBarController"
});

app.controller("navigationBarController", function ($log) {

    this.currentNavItem = 'page1';

    this.goto = function(page) {
        this.status = "Goto " + page;
    };


});












