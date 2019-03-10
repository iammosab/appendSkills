$(document).ready(() => {

    if (document.body.offsetWidth >= 992)
        slideContents(6);
    else if (document.body.offsetWidth >= 720)
        slideContents(3);
    else if (document.body.offsetWidth >= 540)
        slideContents(2);
    for (var t = 0; t < $('.contents').length; t++) {
        var contents = $('.contents').eq(t).find('.item');
        var btnr = $('.contents').eq(t).find('.ir');
        var btnl = $('.contents').eq(t).find('.il');
        if (!contents.eq(0).hasClass('hide'))
            btnr.addClass('hide');
    }

    $(window).resize(function() {
        var width = document.body.offsetWidth;
        if (width >= 992)
            slideContents(6);
        else if (width >= 720)
            slideContents(3);
        else if (width >= 540)
            slideContents(2);
    });
    $('#exampleModalCenter').on('shown.bs.modal', function(e) {
        var video = document.getElementById('modalvideo');
        video.currentTime = 0;
        video.play();
    });
    $('#exampleModalCenter').on('hidden.bs.modal', function(e) {
        var video = document.getElementById('modalvideo');
        video.pause();
    });
    $('#exampleModalCenter').on('show.bs.modal', function(e) {
        $('nav').css('width', '102%');
        $('main').css('width', '102%');
        $('footer').css('width', '102%');
    });
    $('#exampleModalCenter').on('hide.bs.modal', function(e) {
        $('nav').css('width', '100%');
        $('main').css('width', '100%');
        $('footer').css('width', '100%');

    });

});

function itemsToShow(nbr) {
    for (var t = 0; t < $('.contents').length; t++) {
        var contents = $('.contents').eq(t).find('.item');
        for (var j = 0; j < contents.length; j++) {
            if (j < nbr) {
                contents.eq(j).removeClass('hide');
            } else {
                contents.eq(j).addClass('hide');
            }
        }
        var btnr = $('.contents').eq(t).find('.ir');
        var btnl = $('.contents').eq(t).find('.il');
        if (!contents.eq(0).hasClass('hide')) {
            btnr.addClass('hide');
            btnl.removeClass('hide');
        }

    }
}

function slideContents(nbr) {
    itemsToShow(nbr);
    var nbrContents = nbr;
    $('.il').click(function() {
        var contents = $(this).closest('.contents').find('.item');
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
        if (contents.eq(0).hasClass('hide')) {
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
        if (contents.eq(contents.length - 1).hasClass('hide')) {
            $(this).closest('.contents').find('.il').removeClass('hide');
        }
    });
}