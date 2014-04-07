var QuestionPaginationView = Backbone.View.extend({
    el: '#question-pagination',
    events: {
        'click a.prev': 'gotoPrev',
        'click a.next': 'gotoNext',
        'click a.save': 'saveResponse'
    },
    initialize: function() {
        var self = this;
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
        var self = this;

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
    ')

});