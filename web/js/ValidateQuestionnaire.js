validateQuestionnaire = {

    // Define parameters
    route: null,
    responses: null,
    idQuestionTirage: null,
    estMarquee: null,

    init: function() {
        $.ajax({
            url: this.route,
            method: "POST",
            data: {
                responses: this.responses,
                idQuestionTirage: this.idQuestionTirage,
                estMarquee: this.estMarquee
            }
        }).done(function(msg) {

        }).fail(function(msg) {
            alert('Une erreur innatendue est survenue, veuillez prévenir le formateur');
        });
    }

};