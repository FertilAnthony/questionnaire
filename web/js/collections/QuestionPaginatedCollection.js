var QuestionPaginatedCollection = Backbone.Paginator.clientPager.extend({
    // As usual, let's specify the model to be used
    // with this collection
    model: Model,
    // current page to query from the service
    page: 1,
    // how many results to display per 'client page'
    displayPerPage: 1,

    initialize: function(models, options) {
        options = _.defaults(options || {}, {
            displayPerPage: 1
        });
        this.displayPerPage = options.displayPerPage;
        this.previousPageQuestion = this.page;
    },
    nextPage: function(e) {
        e.stopImmediatePropagation();
        var self = this;
        self.previousPageQuestion = self.page;
        self.page = ++self.page;
        self.pager();
    },
    previousPage: function(e) {
        e.stopImmediatePropagation();
        var self = this;
        self.previousPageQuestion = self.page;
        self.page = --self.page || 1;
        self.pager();
    },
    pager: function(sort, direction) {
        if (!_.isNumber(this.page)) {
            this.page = 1;
        }

        if (this.origModels === undefined) {
            this.origModels = _.clone(this.models);
        }

        if (this.firstModels === undefined) {
            this.firstModels = _.clone(this.models);
        }

        var start,
            stop,
            models = _.clone(this.origModels);

        this.totalRecords = models.length;
        this.totalPages = Math.ceil(this.totalRecords / this.displayPerPage);
        this.maxRecords = this.firstModels.length;

        start = parseInt(this.page) - 1;
        this.models = models[start];
        this.reset(this.models);

    },
    info: function() {
        var self = this,
            info = {};

        info = {
            totalRecords: self.totalRecords,
            page: self.page,
            previousPageQuestion: self.previousPageQuestion,
            perPage: self.displayPerPage,
            totalPages: self.totalPages,
            lastPage: self.totalPages,
            lastPagem1: self.totalPages - 1,
            previous: false,
            next: false,
            page_set: [],
            startRecord: (self.page - 1) * self.displayPerPage + 1,
            endRecord: Math.min(self.totalRecords, self.page * self.displayPerPage)
        };

        if (self.page > 1) {
            info.prev = self.page - 1;
        }

        if (self.page < info.totalPages) {
            info.next = self.page + 1;
        }

        info.pageSet = self.setPagination(info);

        self.information = info;
        return info;
    },
    more: function() {
        // console.log('more');
        this.pager(this.page + 1);
    }

});