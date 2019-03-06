$(document).ready(() => {
    contents = $('.contents').eq(0).find('.item');
    if (!contents.eq(0).hasClass('hide'))
        $('#rs').addClass('hide');
    $('#ls').on('click', () => {
        var j = -1;
        var c = 1;
        for (var i = 0; i < contents.length; i++) {
            if (!contents.eq(i).hasClass('hide') && c >= 1 && c <= 3) {
                contents.eq(i).addClass('hide');
                c++;
                j = i + 1;
            }
        }
        c = 1;
        if (j != -1 && j < contents.length) {
            for (var i = j; i < contents.length; i++) {
                if (contents.eq(i).hasClass('hide') && c >= 1 && c <= 3) {
                    contents.eq(i).removeClass('hide');
                    c++;
                }
            }
        }
        if (!contents.eq(contents.length - 1).hasClass('hide')) {
            $('#ls').addClass('hide');
            $('#rs').removeClass('hide');
        }


    });
    $('#rs').on('click', () => {
        var j = -1;
        var c = 1;
        for (var i = 0; i < contents.length; i++) {
            if (!contents.eq(i).hasClass('hide') && c >= 1 && c <= 3) {
                for (var s = i - 3; s < contents.length; s++) {
                    if (c == 4)
                        break;
                    if (contents.eq(s).hasClass('hide') && c >= 1 && c <= 3) {
                        contents.eq(s).removeClass('hide');
                        c++;
                    }
                }
                j = i;
                if (c == 4)
                    break;
            }
        }
        c = 1;
        if (j != -1 && c < contents.length) {
            for (var i = j; i < contents.length; i++) {
                if (!contents.eq(i).hasClass('hide') && c >= 1 && c <= 3) {
                    contents.eq(i).addClass('hide');
                    c++;
                }
            }
        }
        if (!contents.eq(0).hasClass('hide')) {
            $('#rs').addClass('hide');
            $('#ls').removeClass('hide');
        }
    });
});