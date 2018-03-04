var $ = require('jquery');
require('bootstrap-sass');
require('jquery.nicescroll');
require('./label.js');

$(document).ready(function () {
    $(".issues").niceScroll('.issues-content', {
        cursorcolor: "#bdbdbd",
        autohidemode: false,
        cursorborder: "none"
    });
});

