/**
 * @file
 * Placeholder file for custom sub-theme behaviors.
 *
 */
(function ($, Drupal) {

  /**
   * Use this behavior as a template for custom Javascript.
   */
  Drupal.behaviors.exampleBehavior = {
    attach: function (context, settings) {
      //alert("I'm alive!");
      $('.block-views-blockgestion-en-cifras-block-1 .field-value').each(function() {
        var porcenta = $(this).text();
        var lastChar = porcenta[porcenta.length -1];
        var restoChar = porcenta.substring(0, porcenta.length - 1);;

        if (lastChar == '%') {
          $(this).html(restoChar + '<b class="porcenta">' + lastChar + '</b>');
        }
      });

      if ($(window).width() < 480 || $(window).height() < 480) {
        $('.block-views-block-asesoria-home-block-1 .views-field-nothing .columns:last-child').each(function () {
          $(this).insertBefore($(this).prev());
        });
      }
    }
  };

})(jQuery, Drupal);
