var QuestionView = Backbone.View.extend({
    el: '.question.jumbotron',
    events: {
        'click .cloturer': 'clearLocalStorage',
        'click a.linkQuestionRecap': 'createNewPagination'
    },

    initialize: function(options) {
        this.question = this.model;
        this.page = options.page;
        this.collection = this.model.collection;
        this.route = options.route;
        this.routeResultatTest = options.routeResultatTest;
        this.data = options.data;
        this.previousPageQuestion = options.previousPageQuestion;
        this.question.bind('change', this.render, this);
        this.question.bind('destroy', this.remove, this);
    },
    render: function() {
        var self = this;
        if (self.question.attributes.type == "simple") {
            self.template = self.constructor.templateQuestionSimple;
        } else {
            self.template = self.constructor.templateQuestionMultiple;
        }

        this.$el.html(self.template({
            question: self.question.toJSON()
        }));

        // On test si il y a des réponses de sauvegarder dans le localStorage
        if (localStorage.getItem(self.question.attributes.idQuestionTirage)) {
            var storage = JSON.parse(localStorage.getItem(self.question.attributes.idQuestionTirage)),
                reponsesId = storage['reponses'];

            _.each(reponsesId, function(id) {
                $('#' + id).prop('checked', true);
            });
            if (storage.estMarquee) {
                $('.inputQuestionMarquee').prop('checked', true);
            }
        }
        return this;
    },

    clearLocalStorage: function() {
        localStorage.clear();
    },

    createNewPagination: function(e) {
        e.stopImmediatePropagation();
        var $target = $(e.target),
            self = this;

        switch ($target.data('question')) {
            case 'allQuestions':

                var paginatedCollection = new QuestionPaginatedCollection(
                    self.data, {
                        displayPerPage: 1
                    });
                var paginationView = new QuestionPaginationView({
                    collection: paginatedCollection,
                    route: self.route,
                    routeResultatTest: self.routeResultatTest
                });
                var questionsAppView = new QuestionAppView({
                    collection: paginatedCollection,
                    route: self.route,
                    routeResultatTest: self.routeResultatTest,
                    data: self.data
                });

                paginatedCollection.pager();

                break;
            case 'questionsNonRep':

                // Récupération des questions sans réponses
                self.questionNonRep = new Array();
                _.each(self.collection.origModels, function(model) {
                    if (!model.attributes.reponsesStagiaire.length) {
                        self.questionNonRep.push(model);
                    }
                });

                var paginatedCollection = new QuestionPaginatedCollection(
                    self.questionNonRep, {
                        displayPerPage: 1
                    });
                var paginationView = new QuestionPaginationView({
                    collection: paginatedCollection,
                    route: self.route,
                    routeResultatTest: self.routeResultatTest
                });
                var questionsView = new QuestionAppView({
                    collection: paginatedCollection,
                    route: self.route,
                    routeResultatTest: self.routeResultatTest
                });
                paginatedCollection.pager();
                break;
            case 'questionsMarquees':
                break;
            case 'questionsNonRepMarquees':
                break;
        }
    }

}, {

    templateQuestionSimple: _.template('\
        <div class="enonceQuestion"><%= question.enonce %></div>\
        <div class="reponsesQuestion">\
            <% _.each(question.reponses, function(reponse) { %>\
                <input type="radio" name="reponse" id="<%= reponse.id %>" class="elementReponse" value="<%= reponse.id %>"/> <label for="<%= reponse.id %>"><%= reponse.libelle %></label><br />\
            <% }); %>\
        </div>\
    '),

    templateQuestionMultiple: _.template('\
        <div class="enonceQuestion"><%= question.enonce %></div>\
        <div class="reponsesQuestion">\
            <% _.each(question.reponses, function(reponse) { %>\
                <input type="checkbox" name="reponse" id="<%= reponse.id %>" class="elementReponse" value="<%= reponse.id %>"/> <label for="<%= reponse.id %>"><%= reponse.libelle %></label><br />\
            <% }); %>\
        </div>\
    ')
});