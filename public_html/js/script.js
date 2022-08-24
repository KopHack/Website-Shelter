$(document).ready(function() {
    $('.slider__main').slick({
        dots:true,
        speed: 1000,
        autoplay: true,
        autoplaySpeed: 5000,
    });
    $('.slider__product__switch').slick({
        infinite: false,
    });
    $('.slider__product__pop').slick({
        slidesToShow: 4,
        slidesToScroll : 1,
        autoplay:true,
        autoplaySpeed: 5000,
        centerMode: true,
    });
    $('.slider__product__new').slick({
        slidesToShow: 4,
        centerMode: true,
        autoplay:true,
        autoplaySpeed: 5000,
    });
    let button_class = document.body.getElementsByClassName('pn__product');
    let prev = button_class[0].getElementsByClassName('slick-prev');
    prev[0].innerHTML = "Популярные";
    let next = button_class[0].getElementsByClassName('slick-next');
    next[0].innerHTML = "Новые";

    
});
                    

