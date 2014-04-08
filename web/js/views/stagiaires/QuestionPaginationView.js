var QuestionPaginationView = Backbone.View.extend({
    el: '#question-pagination',
    events: {
        'click a.save': 'saveResponse',
        'click a.prev': 'gotoPrev',
        'click a.next': 'gotoNext',
        'click .recapitulatif': 'gotoRecapitulatif'
    },
    initialize: function(options) {
        var self = this;
        self.route = options.route;
        self.routeResultatTest = options.routeResultatTest;
        this.template = self.constructor.template;
        this.collection.on('reset', this.render, this);
        this.collection.on('add', this.render, this);
    },
    render: function() {
        this.$el.html(this.template(this.collection.info()));
        return this;
    },
    gotoPrev: function(e) {
        e.preventDefault();
        var self = this;
        self.collection.previousPage();
    },
    gotoNext: function(e) {
        e.preventDefault();
        var self = this;
        self.collection.nextPage();
    },

    saveResponse: function(e) {
        e.preventDefault();

        var self = this,
            responses = new Array(),
            idQuestionTirage = this.collection.models[0].attributes.idQuestionTirage,
            estMarquee = $('.inputQuestionMarquee').prop('checked') ? true : false;

        $('.elementReponse').each(function() {
            if ($(this).prop('checked')) {
                responses.push($(this).val());
            }
        });

        // TODO : tester le localStorage pour savoir si il faut faire une requete
        // Requète ajax pour sauvegarder les réponses en base
        $.ajax({
            url: self.route,
            method: "POST",
            data: {
                responses: responses,
                idQuestionTirage: idQuestionTirage,
                estMarquee: estMarquee
            }
        }).done(function(msg) {

        }).fail(function(msg) {
            alert('Une erreur innatendue est survenue, veuillez prévenir le formateur');
        });

        // On sauvegarde également dans le localStorage pour éviter de récupérer les réponses via une requète ajax
        localStorage.setItem(idQuestionTirage, JSON.stringify({
            'reponses': responses,
            'estMarquee': estMarquee
        }));

    },

    gotoRecapitulatif: function(e) {
        e.preventDefault();
        var self = this,
            idInscription = window.location.href.slice(window.location.href.indexOf('passage_test/') + 12).split('/');
        url = self.routeResultatTest + "/" + idInscription[1];

        self.template = self.constructor.templateRecapitulatif;
        $('#question-list').empty();
        $('.question').empty();
        $('#question-pagination').html(self.template(url));
    }

}, {

    template: _.template('\
        <% if (totalRecords != 0) { %>\
            <span class="paginationQuestion">\
                <% if (page != 1) { %>\
                    <a href="#" class="prev save btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span></a>\
                <% } %>\
                <% if (lastPage != page) { %>\
                    <a href="#" class="next save btn btn-default"><span class="glyphicon glyphicon-arrow-right"></span></a>\
                <% } %>\
            </span>\
            <span class="nbQuestion">\
                    Question&nbsp;<span class="perpage"><%= endRecord %></span>/<span class="total"><%= totalRecords %></span>\
            </span>\
            <span class="questionMarquee">\
                <input type="checkbox" name="questionMarquee" class="inputQuestionMarquee" value="questionMarquee"/> <label for="questionMarquee">Marquée cette question</label>\
            </span>\
            <span class="recapitulatif">\
                 <button type="button" class="btn btn-default recapitulatif" data-toggle="modal" data-target="#confirmationRecapitulatif">Récapitulatif</button>\
            </span>\
        <% } %>\
    '),

    templateRecapitulatif: _.template('\
        <div class="recapitulatifGlobal">\
            Retourner voir les questions:\
        </div>\
        <a href="<%= url %>" class="btn btn-default cloturer">Clôturer</button>\
    ')

});