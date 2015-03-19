// Custom scripts
$(document).ready(function() {

  // MetsiMenu
  $('#side-menu').metisMenu();

  // minimalize menu
  $('.navbar-minimalize').click(function() {
    $("body").toggleClass("mini-navbar");
    SmoothlyMenu();
  })

  // iChecks
  if (typeof $('.i-checks').iCheck == 'function') {
    $('.i-checks').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green',
    });
  }
});




// Minimalize menu when screen is less than 768px
$(function() {
  $(window).bind("load resize", function() {
    if ($(this).width() < 769) {
      $('body').addClass('body-small')
    } else {
      $('body').removeClass('body-small')
    }
  })
})
