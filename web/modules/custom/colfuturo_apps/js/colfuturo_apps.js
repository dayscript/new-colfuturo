Drupal.behaviors.colfuturo_apps = {
    attach: function (context, settings) {
      var $ = jQuery;
      if(typeof settings.colfuturo_apps != 'undefined'){
        var colfuturo_apps = settings.colfuturo_apps;

        $(colfuturo_apps.item_class).each(  function() {
          $(this).attr('href', $(this).attr('link').replace(' ','') + '?id_token=' + colfuturo_apps.colftuturo_apps_cognito.IdToken ) 
          $(this).attr('target', '_blank' ) 

        })
      }


      function redirect(params){

        // $('<form>').attr({
        //   method: 'post',
        //   action: params.url,
        //   target: '_blank'
        // }).appendTo('document').submit();
        
        
        if(typeof params.url != 'undefined') {
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
        }
      }

    }
  };