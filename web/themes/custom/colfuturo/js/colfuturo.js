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
		    if (jQuery(window).scrollTop() > 37) {
					jQuery("header.header-page").addClass("header-fixed");
		    } else {
					jQuery("header.header-page").removeClass("header-fixed");
		    }
		    if (jQuery(window).scrollTop() > 706) {
					jQuery("#sidebar-first").addClass("submenu-fixed");
		    } else {
					jQuery("#sidebar-first").removeClass("submenu-fixed");
		    }
		});
		jQuery('.submenu ul li ul li a').on('click', function (e) {
			jQuery('.submenu ul li ul li a').each(function () {
				jQuery(this).removeClass('active');
			})
			jQuery(this).addClass('active');
			var target = this.hash;
			jQuerytarget = jQuery(target);
			jQuery('html, body').stop().animate({
				'scrollTop': jQuerytarget.offset().top+2
			}, 800, 'swing', function () {
			});
		});
		/**
		* Bloque de búsqueda
		**/
		jQuery('.search').click(function(e) {
			e.preventDefault();
			jQuery('.searchBox').toggleClass('invisible');
		});
	}
  };
})(jQuery, Drupal);