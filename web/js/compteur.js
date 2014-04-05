countdownManager = {
    // Configuration
    targetTime: null, // Date cible du compte à rebours (00:00:00)
    displayElement: { // Elements HTML où sont affichés les informations
        hour: null,
        min: null,
        sec: null
    },

    // Initialisation du compte à rebours (à appeler 1 fois au chargement de la page)
    init: function() {
        // Récupération des références vers les éléments pour l'affichage
        // La référence n'est récupérée qu'une seule fois à l'initialisation pour optimiser les performances
        this.displayElement.hour = $('#countdown_hour');
        this.displayElement.min = $('#countdown_min');
        this.displayElement.sec = $('#countdown_sec');
console.log(this.targetTime);
        // Lancement du compte à rebours
        this.tick(); // Premier tick tout de suite
        window.setInterval(function() {
            countdownManager.tick();
        }, 1000); // Ticks suivant, répété toutes les secondes (1000 ms)
    },

    // Met à jour le compte à rebours (tic d'horloge)
    tick: function() {
        // Instant présent
        var timeNow = new Date();

        // On s'assure que le temps restant ne soit jamais négatif (ce qui est le cas dans le futur de targetTime)
        if (timeNow > this.targetTime) {
            timeNow = this.targetTime;
        }

        // Calcul du temps restant 
        var diff = this.dateDiff(timeNow, this.targetTime),
            hour = '',
            min = '',
            sec = '';
        if (diff.hour >= 0 && diff.hour <= 9) {
            hour = '0' + diff.hour;
        } else {
            hour = diff.hour;
        }
        if (diff.min >= 0 && diff.min <= 9) {
            min = '0' + diff.min;
        } else {
            min = diff.min;
        }
        if (diff.sec >= 0 && diff.sec <= 9) {
            sec = '0' + diff.sec;
        } else {
            sec = diff.sec;
        }


        // On vérifie que le localStorage n'a pas été changé
        var time = JSON.parse(localStorage.getItem('time'));
        if ((time['hour'] > diff.hour) || ((time['hour'] == diff.hour) && (time['min'] > diff.min))) {
            alert("Temps modifié !!!");
            this.displayElement.hour.text(0);
            this.displayElement.min.text(0);
            this.displayElement.sec.text(0);
            // Mettre en place requete Ajax qui termine le questionnaire et envoie résultat au serveur

        } else {
            this.displayElement.hour.text(hour);
            this.displayElement.min.text(min);
            this.displayElement.sec.text(sec);

            localStorage.setItem('time', JSON.stringify(diff));
        }

    },

    // Calcul la différence entre 2 dates, en jour/heure/minute/seconde
    dateDiff: function(date1, date2) {
        var diff = {} // Initialisation du retour
        var tmp = date2 - date1;

        tmp = Math.floor(tmp / 1000); // Nombre de secondes entre les 2 dates
        diff.sec = tmp % 60; // Extraction du nombre de secondes
        tmp = Math.floor((tmp - diff.sec) / 60); // Nombre de minutes (partie entière)
        diff.min = tmp % 60; // Extraction du nombre de minutes
        tmp = Math.floor((tmp - diff.min) / 60); // Nombre d'heures (entières)
        diff.hour = tmp % 24; // Extraction du nombre d'heures

        return diff;
    }
};