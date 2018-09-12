$(document).ready(function(e) {
    var total = $('.item').length;
    var currentIndex = $('div.active').index() + 1;
    
    $('#slidetext').html(currentIndex + '/'  + total);

    $('.carousel').on('slid.bs.carousel', function () {
      currentIndex = $('div.active').index() + 1;

      
    var text = currentIndex + '/' + total;
      $('#slidetext').html(text);
    });
});