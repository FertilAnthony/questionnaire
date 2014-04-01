var ThemeAppView = Backbone.View.extend({
    el: '#theme-list',
    events: {

    },
    initialize: function(options) {
        var self = this,
            collection = this.collection;

        collection.on('change', this.render, this);
        collection.on('destroy', this.remove, this);

        this.template = _.template($('#themes-list-template').html());
    },
    render: function() {
        var self = this;
        console.log(self.collection);
        this.$el.html(self.template({
            themes: self.collection
        }));

        return this;
    }
});