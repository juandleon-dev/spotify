'use strict';

(function(window, $, Routing) {
    window.SpotifyApp = function ($wrapper) {
        this.$wrapper = $wrapper;
        this.albums = [];

        this.loadLastReleases();
    };

    $.extend(window.SpotifyApp.prototype, {

        loadLastReleases: function() {
            var self = this;
            $.ajax({
                url: Routing.generate('last_releases'),
            }).then(function(data) {
                $.each(data, function(key, album) {
                    self._addRow(album)
                });
            })
        },

        _addRow(album) {
            var tplText = $('#js-album-template').html();
            var tpl = _.template(tplText);
            var html = tpl(album);
            this.$wrapper.find('#card-container').append($.parseHTML(html));
        },
    });

})(window, jQuery, Routing);
