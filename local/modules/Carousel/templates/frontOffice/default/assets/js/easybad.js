$(document).ready(function(e) {
    var total = $('.item-carousel').length;
    var currentIndex = $('.item-carousel.active').index() + 1;
    
    $('#slidetext').html('<span id="currentActiveSlide">'+currentIndex + '</span>' + '/'  + total);

    $('.carousel').on('slid.bs.carousel', function () {
      currentIndex = $('.item-carousel.active').index() + 1;
      
    var text = '<span id="currentActiveSlide">'+currentIndex + '</span>' + '/' + total;
      $('#slidetext').html(text);
    });
});