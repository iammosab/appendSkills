$(document).ready(() => {
    contents = $('.contents').eq(0).find('.item');
    nbrContents = 6;
    if (!contents.eq(0).hasClass('hide'))
        $('#rs').addClass('hide');
    $('#ls').on('click', () => {
        var j = -1;
        var c = 1;
        for (var i = 0; i < contents.length; i++) {
            if (!contents.eq(i).hasClass('hide') && c >= 1 && c <= nbrContents) {
                contents.eq(i).addClass('hide');
                c++;
                j = i + 1;
            }
        }
        c = 1;
        if (j != -1 && j < contents.length) {
            for (var i = j; i < contents.length; i++) {
                if (contents.eq(i).hasClass('hide') && c >= 1 && c <= nbrContents) {
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
            if (!contents.eq(i).hasClass('hide') && c >= 1 && c <= nbrContents) {
                for (var s = i - nbrContents; s < contents.length; s++) {
                    if (c == nbrContents + 1)
                        break;
                    if (contents.eq(s).hasClass('hide') && c >= 1 && c <= nbrContents) {
                        contents.eq(s).removeClass('hide');
                        c++;
                    }
                }
                j = i;
                if (c == nbrContents + 1)
                    break;
            }
        }
        c = 1;
        if (j != -1 && c < contents.length) {
            for (var i = j; i < contents.length; i++) {
                if (!contents.eq(i).hasClass('hide') && c >= 1 && c <= nbrContents) {
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