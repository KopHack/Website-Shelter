$(document).ready(function() {
    $('.item-photo-main').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.item-photo-all'
    });
    $('.item-photo-all').slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        asNavFor: '.item-photo-main',
        arrows: false,
        vertical: true,
        verticalSwiping: true,
        focusOnSelect: true,
    });
    $('.info-container-slider').slick({
        arrows: false,
        slidesToShow:1,
        asNavFor: '.item-info-switch',
        infinite: false,
    });
    $('.item-info-switch').slick({
        infinite: false,
        slidesToShow:6,
        slidesToScroll: 6,
        arrows: false,
        asNavFor: '.info-container-slider',
        focusOnSelect: true,
    });
});