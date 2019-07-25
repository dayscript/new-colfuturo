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
		jQuery(window).scroll(function() {
			//console.log(jQuery(window).scrollTop());
		    if (jQuery(window).scrollTop() > 706) {
					jQuery("#sidebar-first").addClass("submenu-fixed");
		    } else {
					jQuery("#sidebar-first").removeClass("submenu-fixed");
		    }
		});
    }
  };

})(jQuery, Drupal);
