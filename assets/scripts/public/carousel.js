
var startingItem = 1;

$(document).ready(function () {
    $('.carousel_data .carousel_item').each(function () {
        $('#carousel').append($(this).find('.image').html());
    });
    createCarousel(0.45);
    showCaption();

    $(window).resize(function () {
        createCarousel(1);
    });
});

function createCarousel(minScale) {
    $('div#carousel').roundabout({
        startingChild: window.startingItem,
        childSelector: 'img',
        tilt: -5.5,
        minOpacity: 1,
        minScale: minScale,
        duration: 900,
        clickToFocus: true,
        clickToFocusCallback: showCaption
    });
    createCustomButtons();
}

function createCustomButtons() {

    $('.nextItem').click(function () {
        hideCaption();
        $('div#carousel').roundabout('animateToNextChild', showCaption);
    });

    $('.prevItem').click(function () {
        hideCaption();
        $('div#carousel').roundabout('animateToPreviousChild', showCaption);
    });

    $('div#carousel img').click(function () {

        if (!$(this).hasClass('roundabout-in-focus')) hideCaption();
    });
}

function hideCaption() {
    $('#captions').animate({ 'opacity': 0 }, 100);
}

function showCaption() {
    var childInFocus = $('div#carousel').data('roundabout').childInFocus;
    var setCaption = $('.carousel_data .carousel_item .caption:eq(' + childInFocus + ')').html();
    $('#captions').html(setCaption);
    var newHeight = ($('#captions').height()/2.5) + 'px';
    $('.caption_container').animate({ 'height': newHeight }, 150, function () {
        $('#captions').animate({ 'opacity': 1 }, 150);
    });

}

