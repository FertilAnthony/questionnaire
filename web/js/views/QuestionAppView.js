var QuestionAppView = Backbone.View.extend({
    el: '#question-list',
    events: {},
    initialize: function(options) {
        var collection = this.collection;
        collection.on('add', this.addOne, this);
        collection.on('reset', this.addAll, this);
        collection.on('all', this.render, this);
    },
    addAll: function() {
        this.$el.empty();
        this.collection.each(this.addOne, this);
    },
    addOne: function(item) {
        var view = new QuestionView({
            model: item
        });

        // Appelle le render pour injecter le code HTML des utilisateurs
        view.render();
    },
    render: function() {
        return this;
    }
});