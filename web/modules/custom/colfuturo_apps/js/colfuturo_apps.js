Drupal.behaviors.colfuturo_apps = {
    attach: function (context, settings) {
      var $ = jQuery;
      if(typeof settings.colfuturo_apps != 'undefined'){
        var colfuturo_apps = settings.colfuturo_apps;

        
        $(colfuturo_apps.item_class).on(
          'app_redirect', 
          (event, item) => { 
            
            var html = $(item).html();

            var data = {'nombre':'Test'}

            $(item).html('<div class="medium-12 columns text-center"><img src="/core/themes/stable/images/core/loading-small.gif"/></div>')
            
            redirect({
              url: $(item).attr('link'),
              id_token: colfuturo_apps.colftuturo_apps_cognito.IdToken
            });

            $(item).html(html)  

          }
        )

        $(colfuturo_apps.item_class).each(  function() {
          $(this).click(
            () => { 
              $(this).trigger('app_redirect',[this]) 
            })
        })
      }


      function redirect(params){

        // $('<form>').attr({
        //   method: 'post',
        //   action: params.url,
        //   target: '_blank'
        // }).appendTo('document').submit();

        var form = document.createElement("form");
            form.setAttribute("method", "get");
            form.setAttribute("action", params.url);
            form.setAttribute("target", "_blank");
        
        document.body.appendChild(form);
        
        var input = document.createElement('input');
            input.setAttribute('name', 'id_token');
            input.setAttribute('value', params.id_token)
            input.setAttribute('type', 'hidden')

        form.appendChild(input);
        form.submit();

        return true;
      }

    }
  };