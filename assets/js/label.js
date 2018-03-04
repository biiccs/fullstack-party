function colorValues(color) {
    if (color === '')
        return;
    if (color.toLowerCase() === 'transparent')
        return [0, 0, 0, 0];
    if (color[0] === '#') {
        if (color.length < 7) {
            color = '#' + color[1] + color[1] + color[2] + color[2] + color[3] + color[3] + (color.length > 4 ? color[4] + color[4] : '');
        }
        return [parseInt(color.substr(1, 2), 16),
            parseInt(color.substr(3, 2), 16),
            parseInt(color.substr(5, 2), 16),
            color.length > 7 ? parseInt(color.substr(7, 2), 16) / 255 : 1];
    }
    if (color.indexOf('rgb') === -1) {
        var temp_elem = document.body.appendChild(document.createElement('fictum'));
        var flag = 'rgb(1, 2, 3)';
        temp_elem.style.color = flag;
        if (temp_elem.style.color !== flag)
            return;
        temp_elem.style.color = color;
        if (temp_elem.style.color === flag || temp_elem.style.color === '')
            return;
        color = getComputedStyle(temp_elem).color;
        document.body.removeChild(temp_elem);
    }
    if (color.indexOf('rgb') === 0) {
        if (color.indexOf('rgba') === -1)
            color += ',1';
        return color.match(/[\.\d]+/g).map(function (a) {
            return +a
        });
    }
}

var brightness = function (r, g, b) {
    return (r * 299 + g * 587 + b * 114) / 1000
};

var brighterThan = function (r, g, b, x) {
    return (brightness(r, g, b) > x);
};

var textColor = function (r, g, b, x) {
    return brighterThan(r, g, b, x) ?
        "rgb(51,51,51)" :
        "rgb(255,255,255)";
};

$(document).ready(function () {
    $('.label-link .label').each(function () {
        var rgb = colorValues($(this).css('background-color'));
        $(this).css(
            'color',
            textColor(rgb[0], rgb[1], rgb[2], 123)
        );
    });
});