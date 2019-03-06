"use strict";

app.service("StorageService", function ($log) {

    $log.debug("StorageService()");

    this.key = "storage";

    this.speichern = (array) => {
        localStorage.setItem(this.key, JSON.stringify(array))
    };

    this.laden = () => {
        this.array = JSON.parse(localStorage.getItem(this.key));
        if (this.array === null) {
            this.array = []
        }

        this.array.sort();

        this.erg = [];
        for(let i = 0; i < this.array.length; i++) {
            this.erg.push({ "prio":this.array[i].prio, "text": this.array[i].text })
        }
        return this.erg;
    };

});
