$( function () {
    'use strict';
    // animate login form
    $('.login-form').animate({
        top: '20px'
    }, 600, function () {
        $(this).animate({
           top: '0px',
            width: '600px'
        },600);
    });
    // animate edit user  form
    $('.edit-user-form').animate({
        marginLeft: '50px'
    }, 800,function () {
        $(".edit-form").css('margin-left',50)
    });

    // toggle placeholder
  $("[placeholder]").focus( function () {
      $(this).attr('data-placeholder',$(this).attr('placeholder')).attr('placeholder','');
  }).blur( function () {
      $(this).attr('placeholder',$(this).attr('data-placeholder'));
  });



});