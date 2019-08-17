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

      //MENU #block-homemenu
      var pathArray = window.location.pathname.split('/');
      if (pathArray[1] == 'for-international-universities') {
        jQuery("#block-homemenu .menu .international-universities").addClass("is-active");
      }else if(pathArray[1] == 'servicios-corporativos'){
        console.log('SI');
        jQuery("#block-homemenu .menu .servicios-corporativos").addClass("is-active");
      }else{
        jQuery("#block-homemenu .menu .estudios-exterior").addClass("is-active");
      }

      //alert("I'm alive!");
      if (Foundation.MediaQuery.is('small only')) {
        jQuery(window).scroll(function() {
          console.log(jQuery(window).scrollTop());
          if (jQuery(window).scrollTop() > 336) {
            //jQuery(".off-canvas-content").removeClass("header-fixed");
          }
        });
      	jQuery("#sidebar-first nav").addClass("submenumobile-fixed");
        jQuery(".off-canvas-content").addClass("header-fixed");
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