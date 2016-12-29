$('.menu__link').click(function (){
    $('body').animate({scrollTop: $(this.hash).offset().top-40}, 800);
});
$('#to-top, #logo').click(function () {
    $('body').animate({scrollTop: $(this.hash).offset().top}, 800);
});