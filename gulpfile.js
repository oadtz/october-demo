var elixir = require('laravel-elixir');

elixir.config.assetsPath = 'themes/reader/assets';
elixir.config.publicPath = 'themes/reader/assets'

elixir(function(mix) {
    mix
        .styles([ 
            'bootstrap.min.css',
            'flaticon.css',
            'mediaelementplayer.css',
            'reader.css',
            'colors/nephritis.css',
            'responsive.css'
        ], 'themes/reader/assets/css/style.css')
        .scripts([
            'jquery.1.9.1.min.js',
            'bootstrap.min.js',
            'mediaelement-and-player.min.js',
            'jquery.fitvids.js',
            'jquery.jscroll.min.js',
            'custom.js'
        ], 'themes/reader/assets/js/script.js');
});