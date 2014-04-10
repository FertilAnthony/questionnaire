var QuestionAppView = Backbone.View.extend({
    el: '#question-list',
    events: {},
    initialize: function(options) {
        var collection = this.collection;

        self.route = options.route;
        self.routeResultatTest = options.routeResultatTest;
        self.data = options.data;
        collection.on('add', this.addOne, this);
        collection.on('reset', this.addAll, this);
        collection.on('all', this.render, this);
    },
    addAll: function() {
        //this.$el.empty();
        this.collection.each(this.addOne, this);
    },
    addOne: function(item) {

        var view = new QuestionView({
            model: item,
            page: this.collection.page,
            previousPageQuestion: this.collection.previousPageQuestion,
            route: self.route,
            routeResultatTest: self.routeResultatTest,
            data: self.data
        });

        view.render();
    },
    render: function() {
        return this;
    }
});