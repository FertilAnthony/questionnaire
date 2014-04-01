var PromoAppView = Backbone.View.extend({
    el: '#promo-list',
    events: {

    },
    initialize: function(options) {
        var self = this,
            collection = this.collection;

        collection.on('change', this.render, this);
        collection.on('destroy', this.remove, this);

        this.template = _.template($('#promos-list-template').html());
    },
    render: function() {
        var self = this;

        this.$el.html(self.template({
            promos: self.collection
        }));

        return this;
    }
});