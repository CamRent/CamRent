"use strict";

app.component("footbar", {
    templateUrl: "components/footbar.html",
    controller: "FootbarController",
    bindings: {}
});


app.controller("FootbarController", function ($log) {

    $log.debug("FootbarController()");

});
