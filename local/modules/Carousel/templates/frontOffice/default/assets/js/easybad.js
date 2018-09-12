$(document).ready(function(e) {
    var total = $('.item-carousel').length;
    var currentIndex = $('.item-carousel.active').index() + 1;
    console.log("outside " + currentIndex);
    $('#slidetext').html(currentIndex + '/'  + total);

    $('.carousel').on('slid.bs.carousel', function () {
      currentIndex = $('.item-carousel.active').index() + 1;
      console.log("inside" + currentIndex);
      
    var text = currentIndex + '/' + total;
      $('#slidetext').html(text);
    });
});