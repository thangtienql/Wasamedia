jQuery(function(){
  $(document).scroll(function(){
    var headerHeight = $('.header').innerHeight();
    var positionTop = $(document).scrollTop();
    if(positionTop > headerHeight){
      $('.header').addClass('scroll');
    }else {
      $('.header').removeClass('scroll');
    }
  });
})
