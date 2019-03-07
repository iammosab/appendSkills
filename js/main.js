$(document).ready(() => {
    nbrContents = 6;

    for (var t = 0; t < $('.contents').length; t++) {
        var contents = $('.contents').eq(t).find('.item');
        var btnr = $('.contents').eq(t).find('.ir');
        var btnl = $('.contents').eq(t).find('.il');
        if (!contents.eq(0).hasClass('hide'))
            btnr.addClass('hide');
    }

    $('.il').click(function() {
        var contents = $(this).closest('.contents').find('.item');
        console.log(contents);
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
            $(this).addClass('hide');
            $(this).closest('.contents').find('.ir').removeClass('hide');
        }
    });
    $('.ir').click(function() {
        var contents = $(this).closest('.contents').find('.item');
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
            $(this).addClass('hide');
            $(this).closest('.contents').find('.il').removeClass('hide');
        }
    });
});