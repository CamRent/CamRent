"use strict";

app.service("UserdataService", function ($log) {

    $log.debug("UserdataService()");

    this.array = {};

    /**
     * Speichert die Userdata im localStorage.
     */
    this.speichern = (id, firstname, surname, priority, email) => {
        localStorage.setItem("Id", id);
        localStorage.setItem("Firstname", firstname);
        localStorage.setItem("Surname", surname);
        localStorage.setItem("Priority", priority);
        localStorage.setItem("Email", email);
    };


    /**
     * Lädt die Userdata aus dem localStorage, wenn möglich
     */

    this.laden = () => {

        var array = [];
        array.push(localStorage.getItem("Id"));
        array.push(localStorage.getItem("Firstname"));
        array.push(localStorage.getItem("Surname"));
        array.push(localStorage.getItem("Priority"));
        array.push(localStorage.getItem("Email"));

        return array;
    }
});