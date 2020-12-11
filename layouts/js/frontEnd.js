$( function () {
    'use strict';

    // toggle placeholder
  $("[placeholder]").focus( function () {
      $(this).attr('data-placeholder',$(this).attr('placeholder')).attr('placeholder','');
  }).blur( function () {
      $(this).attr('placeholder',$(this).attr('data-placeholder'));
  });

    // confirm function before deleting
$("body").on('click','.confirm', function () {
        return confirm("Are You Sure That You Want To Delete This Row")
});


    // swap between login form and sign up form
$('.login-page span').click( function () {
    $(this).addClass('selected').siblings('span').removeClass('selected');
    $('.login-page form').hide();
    $('.' + $(this).attr('id')).fadeIn(200);
});


// live item name
    $(".live-name").keyup(function(){
        $(".preview-live .figure-caption h3").text($(this).val());
    });

// live item description
    $(".live-desc").keyup(function(){
        $(".preview-live .figure-caption p").text($(this).val());
    });


// live item price
    $(".live-price").keyup(function(){
        $(".preview-live .price-tag").text('$' + '' + $(this).val());
    });



});// end of on ready