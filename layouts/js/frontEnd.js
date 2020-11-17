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

});// end of on ready