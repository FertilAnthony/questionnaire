var UtilisateurView = Backbone.View.extend({
    el: '.utilisateur',

    initialize: function() {
        this.user = this.model;
        this.user.bind('change', this.render, this);
        this.user.bind('destroy', this.remove, this);
    },
    render: function() {
        this.template = _.template($('#utilisateur-list-template').html());
        this.$el.append(this.template({
            user: this.user.toJSON()
        }));

        return this;
    }
});