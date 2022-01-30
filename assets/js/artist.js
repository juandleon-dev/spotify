'use strict';

(function(window, $, Routing) {
    window.Artist = function ($wrapper, $id) {
        this.$wrapper = $wrapper;
        this.$id = $id;
        this.albums = [];

        this.loadArtist();
        this.loadTopTracks();
    };

    $.extend(window.Artist.prototype, {

        loadArtist: function() {
            var self = this;
            $.ajax({
                url: Routing.generate('artist_detail', {
                    'id': this.$id
                }),
            }).then(function(data) {
                $('#artist').find('img').attr('src', data.image)
                $('#artist').find('h2').html(data.name)
            })
        },

        loadTopTracks: function() {
            var self = this;
            $.ajax({
                url: Routing.generate('artist_top_tracks', {
                    'id': this.$id
                }),
            }).then(function(data) {
                $.each(data, function(key, track) {
                    self._addRow(track)
                });
            })
        },

        _addRow(track) {
            var tplText = $('#js-artist-template').html();
            var tpl = _.template(tplText);
            var html = tpl(track);
            this.$wrapper.find('#top-track-list').append($.parseHTML(html));
        },
    });

})(window, jQuery, Routing);
