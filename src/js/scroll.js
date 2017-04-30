$('.menu__link').click(function (){
    var margin = ($(document).width() <= 500 ? 90 : 40);
    $('body').animate({scrollTop: $(this.hash).offset().top-margin}, 800);
});
$('#to-top, #logo').click(function () {
    $('body').animate({scrollTop: $(this.hash).offset().top}, 800);
});