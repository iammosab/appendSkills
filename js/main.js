$(document).ready(() => {

    for (let i = 0; i <$('.items-container').length ; i++) {
        contents = document.getElementsByClassName('items-container')[i].getElementsByClassName('contents')[0];
        items = contents.getElementsByClassName('item');
        itemsLength = items[0].scrollWidth*items.length;
        if (contents.scrollLeft == 0)
            $('.items-container').eq(i).find('.il').addClass('hide');

        if (contents.offsetWidth == itemsLength || contents.offsetWidth+10 >= itemsLength  )
            $('.items-container').eq(i).find('.ir').addClass('hide');

    }

    $('.ir').click(function () {
        var contents = $(this).closest('.items-container').find('.contents').eq(0);
        var item = $(this).closest('.items-container').find('.contents').eq(0).find('.item').eq(0);
        var newscroll =  contents.scrollLeft() + item.width() +10;
        contents.scrollLeft(newscroll);
        scrollchange(contents);
    });
    $('.il').click(function () {
        var contents = $(this).closest('.items-container').find('.contents').eq(0);
        var item = $(this).closest('.items-container').find('.contents').eq(0).find('.item').eq(0);
        var newscroll =  contents.scrollLeft() - item.width() -10;
        contents.scrollLeft(newscroll);
        scrollchange(contents);
    });

    $(window).resize(function() {
        for (let i = 0; i <$('.items-container').length ; i++) {
            contents = document.getElementsByClassName('items-container')[i].getElementsByClassName('contents')[0];
            items = contents.getElementsByClassName('item');
            itemsLength = items[0].scrollWidth*items.length;
            if (contents.scrollLeft == 0)
                $('.items-container').eq(i).find('.il').addClass('hide');
            else
                $('.items-container').eq(i).find('.il').removeClass('hide');

            if (contents.offsetWidth == itemsLength || contents.offsetWidth+10 >= itemsLength  )
                $('.items-container').eq(i).find('.ir').addClass('hide');
            else
                $('.items-container').eq(i).find('.ir').removeClass('hide');

        }
    });

    var scrollchange = function(contents){
        if(contents.scrollLeft() > 0)
            contents.closest('.items-container').eq(0).find('.il').removeClass('hide');
        else
            contents.closest('.items-container').eq(0).find('.il').addClass('hide');
        if (contents.width()%contents.scrollLeft()==0 || contents.scrollLeft() == contents.width()*2 )
            contents.closest('.items-container').eq(0).find('.ir').addClass('hide');
        else
            contents.closest('.items-container').eq(0).find('.ir').removeClass('hide');
    }




    $('#exampleModalCenter').on('hidden.bs.modal', function(e) {
        var video = document.getElementById('modalvideo');
        video.pause();
    });
    $('#intro_modal').on('show.bs.modal', function(e) {
        $('nav').css('width', '102%');
        $('main').css('width', '102%');
        $('footer').css('width', '102%');
        $('#intro_Email').val('');
        $('#intro_Password').val('');

    });
    $('#intro_modal').on('hide.bs.modal', function(e) {
        $('nav').css('width', '100%');
        $('main').css('width', '100%');
        $('footer').css('width', '100%');

    });



    $('#intro_submit').click(function () {

        if($('#intro_Email').val() == "" && $('#intro_Password').val() == "")
            message('danger','Vous devez remplir les champs');
        else{
            if($(this).hasClass('inscrire')){

                $.ajax({
                    url: '../controllers/UserController.php',
                    async: false,
                    method: 'POST',
                    data:{ op:'login', email : $('#intro_Email').val(), passe: $('#intro_Password').val()},
                    success: function (data, textStatus, jqXHR) {
                        if (data == '0' || data == '-1')
                            message('danger','Saisie invalide');
                        else
                            window.location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        message('danger','Connexion erreur');
                    }
                });


            }else if ($(this).hasClass('connecter')){

                $.ajax({
                    url: '../controllers/UserController.php',
                    async: false,
                    method: 'POST',
                    data:{ op:'login', email : $('#intro_Email').val(), passe: $('#intro_Password').val()},
                    success: function (data, textStatus, jqXHR) {
                        if (data == '0' || data == '-1')
                            message('danger','Saisie invalide');
                        else
                            window.location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        message('danger','Connexion erreur');
                    }
                });

            }
        }


    });

});
$('#intro_connecter').on('click',function () {

    $('#intro_modal').on('show.bs.modal', function(e) {
        $('#intro_submit').addClass('connecter').removeClass('inscrire').text("Se connecter");
        $('#intro_modalTitle').text('Se connecter');
    });


});

$('#intro_inscrire').on('click',function () {

    $('#intro_modal').on('show.bs.modal', function(e) {
        $('#intro_submit').addClass('inscrire').removeClass('connecter').text("S'inscrire");
        $('#intro_modalTitle').text("S'inscrire");

    });


});
var message = function (type, message) {
    var c = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' + message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    $('.message').html(c);
    $('.alert').delay(3000).fadeOut('slow');
}
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