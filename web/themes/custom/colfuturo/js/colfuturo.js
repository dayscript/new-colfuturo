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
      if (Foundation.MediaQuery.is('small only')) {
      	jQuery("#sidebar-first nav").addClass("submenumobile-fixed");
      }else{
      	jQuery("#sidebar-first nav").addClass("submenu");
      	jQuery(window).scroll(function() {
      		if (jQuery(window).scrollTop() > 37) {
      			jQuery(".off-canvas-content").addClass("header-fixed");
      		}else{
      			jQuery(".off-canvas-content").removeClass("header-fixed");
      		}
		    if (jQuery(window).scrollTop() > 531) {
					jQuery("#sidebar-first").addClass("submenu-fixed");
		    } else {
					jQuery("#sidebar-first").removeClass("submenu-fixed");
		    }
      	});
      }
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