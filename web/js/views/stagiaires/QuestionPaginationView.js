var QuestionPaginationView = Backbone.View.extend({
    el: '#question-pagination',
    events: {
        'click a.prev': 'gotoPrev',
        'click a.next': 'gotoNext',
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
    }
}, {

    template: _.template('\
        <% if (totalRecords != 0) { %>\
            <span class="cell last pages">\
                <% if (page != 1) { %>\
                    <a href="#" class="prev">Page Précédente</br></a>\
                <% } %>\
                <% if (lastPage != page) { %>\
                    <a href="#" class="next">Page Suivante </a>\
                <% } %>\
            </span>\
            <span class="nbQuestion">\
                    Question&nbsp;<span class="perpage"><%= endRecord %></span>/<span class="total"><%= totalRecords %></span>\
            </span>\
        <% } %>\
    ')

});