$(function() {
    'use strict';

    //Switch between login and signup

    $('.login-page h1 span').click(function () {

     $(this).addClass('selected').siblings().removeClass('selected');

     $('.login-page form').hide();

     $('.' + $(this).data('class')).fadeIn(100) ;

    });


    //Trigger the selectboxit

    $("select").selectBoxIt({
     
    autoWidth: false

});



    // to hide placeholder on form focus

    $('[placeholder]').focus(function () {
        $(this).attr('data-text', $(this).attr('placeholder'));

        $(this).attr('placeholder', '');

    }).blur(function () {
        $(this).attr('placeholder', $(this).attr('data-text'));

    });

    // Add Asterisk on required field

    $('input').each(function() {

        if ($(this).attr('required') === 'required') {
            $(this).after('<span class="asterisk">*</span>');
        }

    });

    

    //Confirm msg on buttons

    $('.confirm').click(function (){
        return confirm('Are You Sure?') ;
      });


      $('.live').keyup(function () {

        $($(this).data('class')).text($(this).val()); 

       
      });

      

      


});