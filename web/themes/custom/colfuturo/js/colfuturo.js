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
        jQuery("#block-homemenu .menu .international-universities").parent().addClass("is-active");
        jQuery("#block-homemenu .menu .international-universities").addClass("is-active");
      }else if(pathArray[1] == 'servicios-corporativos'){
        jQuery("#block-homemenu .menu .servicios-corporativos").parent().addClass("is-active");
        jQuery("#block-homemenu .menu .servicios-corporativos").addClass("is-active");
      }else{
        jQuery("#block-homemenu .menu .estudios-exterior").parent().addClass("is-active");
        jQuery("#block-homemenu .menu .estudios-exterior").addClass("is-active");
      }

      //alert("I'm alive!");
      if (Foundation.MediaQuery.is('small only')) {
        jQuery(window).scroll(function() {
          if (jQuery(window).scrollTop() > 37) {
            jQuery(".header-page").addClass("header-fixed");
          }else{
            jQuery(".header-page").removeClass("header-fixed");
          }
          //console.log(jQuery(window).scrollTop());
          if (jQuery(window).scrollTop() >= 392) {
            jQuery("#sidebar-first nav").addClass("second-sticky");
          }else{
            jQuery("#sidebar-first nav").removeClass("second-sticky");
          }
        });
        jQuery("#sidebar-first nav").addClass("submenumobile-fixed");
        jQuery(".off-canvas-content").addClass("header-fixed");
      }else{
      	jQuery("#sidebar-first nav").addClass("submenu");
      	jQuery(window).scroll(function() {
      		if (jQuery(window).scrollTop() > 37) {
      			jQuery(".header-page").addClass("header-fixed");
      		}else{
      			jQuery(".header-page").removeClass("header-fixed");
      		}
/*		    if (jQuery(window).scrollTop() > 531) {
          console.log(jQuery(window).scrollTop());
					jQuery("#sidebar-first").addClass("submenu-fixed");
		    } else {
					jQuery("#sidebar-first").removeClass("submenu-fixed");
		    }*/
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

    /**
    * Menu meta-header
    **/
    $('#block-homemenu .menu', context).once('exampleBehavior').on('click','li.is-active',function(e){
        e.stopPropagation()

        let menu = $(this).parent().toggleClass('opened')
        $('.header-page').toggleClass('opened')
        
        menu.prepend($(this))

        e.preventDefault()
    })

	}
  };

$(document).ready(function() {
    /**
    * scrollLeft .submenumobile-fixed
    **/
    var x = $('nav.submenumobile-fixed .menu li a.is-active').position();
    //alert("Top: " + x.top + " Left: " + x.left);
    $('nav.submenumobile-fixed .menu').animate({
      scrollLeft: x.left
    }, 200);
    /**
    * scrollLeft .submenumobile-fixed
    **/
});


var thisArticle = $('main#main');
var thisSidebar = $('#sidebar-first');
function positionSidebar(){
    var articleHeight = thisArticle.height();
    var articleFromTop = thisArticle.offset().top;

    var windowScroll = $(window).scrollTop();
    var sweetSpot = ((articleHeight + articleFromTop) - thisSidebar.height());
    console.log('ss: ' + sweetSpot);
    console.log('current scroll: ' + windowScroll);
    if ($(window).width() >= 1280) {
        console.log('screen larger than 1280');
        //if sidebar has hit the bottom
        if ((windowScroll + 40) >= sweetSpot) {
            console.log('sidebar is at the bottom');
            thisSidebar.css('position', 'relative');

            console.log(sweetSpot);
            console.log(thisSidebar.height());
            //thisSidebar.css('top', (sweetSpot - (thisSidebar.height() + 60)));
            thisSidebar.css('top', (thisArticle.height() - thisSidebar.height()));
            thisSidebar.css('max-width', '433px');
            //Sidebar has not yet hit the bottom
        } else{
            //if scroll has not yet passed the top of the article - should still be absolute
            if ((windowScroll + 40) <= articleFromTop) {
                console.log('Sidebar hasent passed top of article yet');
                //jQuery("#sidebar-first").removeClass("submenu-fixed");
                thisSidebar.css('top', '0');
                thisSidebar.css('position', 'relative');
                //thisSidebar.css('bottom', '2.5rem');
                //Scroll has passed the top of the article - fix the sidebar
            } else {
                console.log('let the scrolln beign');
                //jQuery("#sidebar-first").addClass("submenu-fixed");
                thisSidebar.css('top','45.27px');
                thisSidebar.css('position', 'fixed');
                //thisSidebar.css('bottom', 'auto');
            }
        }
    } else {
    //Window should now be one column
        console.log('Break the design');
    }
}

$(function () {
    positionSidebar();
    $(window).scroll(function () {
        positionSidebar();
    });
});


})(jQuery, Drupal);