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

$(".login-page h3 span").click( function () {
    $('this').addClass('selected').siblings().removeClass("selected");
    $('.login-page form').hide();
    $('.' + $('this').data('class')).fadeIn(150);
});

});// end of on ready