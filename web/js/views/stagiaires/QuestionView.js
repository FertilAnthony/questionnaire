var QuestionView = Backbone.View.extend({
    el: '.questions.jumbotron',
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

        // On parcours la collection pour savoir si il y a des réponses à des questions
        _.each(self.collection.origModels, function(model) {
            if ((self.question.attributes.idQuestionTirage == model.attributes.idQuestionTirage) && (model.attributes.estMarquee)) {
                $('.inputQuestionMarquee').prop('checked', true);
            }

            _.each(model.attributes.reponsesStagiaire, function(idReponse) {
                $('#' + idReponse).prop('checked', true);
            });
        });

        return this;
    },

    clearLocalStorage: function() {
        localStorage.clear();
    },

    createNewPagination: function(e) {
        e.stopImmediatePropagation();
        var $target = $(e.target),
            self = this;

        //self.firstModels = _.clone(self.collection.origModels);

        switch ($target.data('question')) {
            case 'allQuestions':

                self.collection.reset(self.collection.firstModels);
                self.collection.origModels = self.collection.firstModels;
                self.collection.page = 1;
                self.collection.pager();

                break;
            case 'questionsNonRep':

                // Récupération des questions sans réponses
                self.questionNonRep = new Array();
                _.each(self.collection.firstModels, function(model) {
                    if (!model.attributes.reponsesStagiaire.length) {
                        self.questionNonRep.push(model);
                    }
                });

                self.collection.reset(self.questionNonRep);
                self.collection.origModels = self.questionNonRep;
                self.collection.page = 1;
                self.collection.pager();

                break;
            case 'questionsMarquees':
                // Récupération des questions marquées
                self.questionMarquee = new Array();
                _.each(self.collection.firstModels, function(model) {
                    if (model.attributes.estMarquee) {
                        self.questionMarquee.push(model);
                    }
                });

                self.collection.reset(self.questionMarquee);
                self.collection.origModels = self.questionMarquee;
                self.collection.page = 1;
                self.collection.pager();

                break;
            case 'questionsNonRepMarquees':
                // Récupération des questions marquées/non rep
                self.questionMarqueeNonRep = new Array();
                _.each(self.collection.firstModels, function(model) {
                    if ((model.attributes.estMarquee) || (!model.attributes.reponsesStagiaire.length)) {
                        self.questionMarqueeNonRep.push(model);
                    }
                });

                self.collection.reset(self.questionMarqueeNonRep);
                self.collection.origModels = self.questionMarqueeNonRep;
                self.collection.page = 1;
                self.collection.pager();

                break;
        }
    },

    createPagination: function(collection) {
        var paginatedCollection = new QuestionPaginatedCollection(
            collection, {
                displayPerPage: 1
            });
        var paginationView = new QuestionPaginationView({
            collection: paginatedCollection,
            route: this.route,
            routeResultatTest: this.routeResultatTest
        });
        var questionsView = new QuestionAppView({
            collection: paginatedCollection,
            route: this.route,
            routeResultatTest: this.routeResultatTest
        });
        paginatedCollection.pager();
    }

}, {

    templateQuestionSimple: _.template('\
        <div class="question">\
            <div class="enonceQuestion"><%= question.enonce %></div>\
            <div class="reponsesQuestion">\
                <% _.each(question.reponses, function(reponse) { %>\
                    <input type="radio" name="reponse" id="<%= reponse.id %>" class="elementReponse" value="<%= reponse.id %>"/> <label for="<%= reponse.id %>"><%= reponse.libelle %></label><br />\
                <% }); %>\
            </div>\
        </div>\
    '),

    templateQuestionMultiple: _.template('\
        <div class="question">\
            <div class="enonceQuestion"><%= question.enonce %></div>\
            <div class="reponsesQuestion">\
                <% _.each(question.reponses, function(reponse) { %>\
                    <input type="checkbox" name="reponse" id="<%= reponse.id %>" class="elementReponse" value="<%= reponse.id %>"/> <label for="<%= reponse.id %>"><%= reponse.libelle %></label><br />\
                <% }); %>\
            </div>\
        </div>\
    ')
});