var QuestionView = Backbone.View.extend({
    el: '.question.jumbotron',

    events: {
        'click #confirm-recapitulatif': 'gotoRecapitulatif'
    },

    initialize: function() {
        this.question = this.model;
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
        return self;
    },

    gotoRecapitulatif: function(e) {
        e.preventDefault();
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
    '),

    templateRecapitulatif: _.template('\
    ')
});