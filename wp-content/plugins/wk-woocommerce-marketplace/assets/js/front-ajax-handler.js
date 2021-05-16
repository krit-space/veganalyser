jQuery(document).ready(function($){

    // Remove seller from favourite list
    jQuery(".favourite-seller .remove-icon").on("click",function(){
      currentElm=jQuery(this);
      seller = currentElm.data("seller-id");
      customer_acc = currentElm.data("customer-id");
      if (jQuery('table.shop-fol').hasClass('customer-end')) {
        var confirmMsg = the_mpajax_script.mkt_tr.fajax1;
      } else {
        var confirmMsg = the_mpajax_script.mkt_tr.fajax2;
      }
      var retVal = confirm(confirmMsg)
      if( retVal == true ){
          jQuery.ajax({
            type: 'POST',
            url: the_mpajax_script.mpajaxurl,
            data: {"action": "delete_favourite_seller", "seller":seller,"customer_acc":customer_acc,"nonce":the_mpajax_script.nonce},
              success: function(data) {

                if(data==1){

                  currentElm.closest("tr").remove();
                  if (jQuery('table.shop-fol').hasClass('customer-end')) {
                    if( jQuery('.shop-fol tbody').html().trim() == '' ){
                      jQuery('.shop-fol tbody').html('<tr><td>'+the_mpajax_script.mkt_tr.fajax3+'</td></tr>');
                    }
                  } else {
                    if( jQuery('.shop-fol tbody').html().trim() == '' ){
                      jQuery('.shop-fol tbody').html('<tr><td>'+the_mpajax_script.mkt_tr.fajax4+'</td></tr>');
                      jQuery('.mass-action-checkbox').parent().removeClass('checked');
                    }
                  }

                }
                else{

                  alert(the_mpajax_script.mkt_tr.fajax5);

                }
              }
          });
        }
    });


    /*----------*/ /*---------->>> Bulk Delete Shop Followers Seller End <<<----------*/ /*----------*/
    jQuery(".action-delete").on("click",function(){

      customer_checked='';
      temp_arr=[];
      customer_checked=jQuery(".shop-fol tbody tr").find(".icheckbox_square-blue input:checkbox:checked").map(function(){
         currentElm=jQuery(this);
          customer_id = jQuery(this).closest("tr").find("td:last span.remove-icon").data("customer-id");
          seller_id   = jQuery(this).closest("tr").find("td:last span.remove-icon").data("seller-id");
          temp_arr=seller_id+","+customer_id;

          return temp_arr;
       }).get();


        if(customer_checked.length > 0){

          var retVal = confirm(the_mpajax_script.mkt_tr.fajax6);
          if(retVal==true){
            jQuery.ajax({
                type: 'POST',
                url: the_mpajax_script.mpajaxurl,
                data: {"action": "change_favorite_status","nonce":the_mpajax_script.nonce,"customer_selected":customer_checked},

                success: function(response)
                {
                  response = JSON.parse(response);
                  jQuery('.mass-action-checkbox').parent('div').removeClass('checked').parent('div').remove();
                  jQuery.each(response, function(key, value){
                    jQuery("tr[data-id='" + value + "']").remove();
                  });
                  if( jQuery('.shop-fol tbody').html().trim() == '' ){
                    jQuery('.shop-fol tbody').html('<tr><td>'+the_mpajax_script.mkt_tr.fajax4+'</td></tr>');
                  }
                 }
              });
           }
        }
        else{

          alert(the_mpajax_script.mkt_tr.fajax7);

        }

    });


    /*----------*/ /*---------->>> Send Mail To Shop Followers <<<----------*/ /*----------*/
    var counter = 0;
    jQuery("#wk-send-mail").on("click",function(evt){
      var tempc = 0;
      evt.preventDefault();

      var sendButton = jQuery(this);

      var subject = jQuery('.customer_subject');
      var message = jQuery('.customer_message');

      if(subject.val().length < 1 && counter == 0){
        tempc++;
        subject.parent().append('<p style="color:red">'+the_mpajax_script.mkt_tr.fajax8+'</p>');
      }
      if(message.val().length < 1 && counter == 0){
        tempc++;
        message.parent().append('<p style="color:red">'+the_mpajax_script.mkt_tr.fajax9+'</p>');
      }
      if((tempc != 0 || counter != 0) && (subject.val().length < 1 && message.val().length < 1)){
        counter++;
        return false;
      }

       var datastring = jQuery("#snotifier").serializeArray();

       var customer_checked='';

      var temp_arr=[];

      customer_checked=jQuery(".shop-fol tbody tr").find(".icheckbox_square-blue input:checkbox:checked").map(function(){
         currentElm=jQuery(this);
          customer_email = jQuery(this).closest("tr").find("td.c-mail").data("cmail");
          temp_arr=customer_email;
          return temp_arr;
       }).get();

       sendButton.attr('disabled', 'disabled');

       jQuery.ajax({
          type: 'POST',
          url: the_mpajax_script.mpajaxurl,
          data: {"action": "send_mail_to_customers","nonce":the_mpajax_script.nonce,"form_serialized":datastring,"customer_list":customer_checked},

          success: function(response)
          {
              if(response == 'sent'){
                jQuery("#notify-customer .mp-modal-header").append("<div class='woocommerce-message'></button>"+the_mpajax_script.mkt_tr.fajax10+"</div>");
                jQuery("#notify-customer .woocommerce-message").delay(5000).slideUp();
                setTimeout(function(){
                    jQuery('#notify-customer').fadeOut();
                    sendButton.prop("disabled", false);
                    window.location.reload();
                 }, 2000);

                jQuery('input:checkbox').removeAttr('checked');
                jQuery('input:checkbox').parent(".icheckbox_square-blue").removeClass("checked");
                jQuery("#wk-send-mail").attr('disabled');
              }
              else{
                jQuery("#notify-customer .mp-modal-header").append("<div class='woocommerce-error'></button>"+the_mpajax_script.mkt_tr.fajax11+"</div>");
                jQuery("#notify-customer .woocommerce-error").delay(5000).slideUp();
                setTimeout(function(){
                    jQuery('#notify-customer').fadeOut();
                 }, 2000);
              }

           }
        });

    });


    /*----------*/ /*---------->>> Seller Shop Options Check <<<----------*/ /*----------*/
    jQuery('#seller-shop').on('focusout', function() {
        var self = jQuery(this);
        jQuery.ajax({
                    type: 'POST',
                    url: the_mpajax_script.mpajaxurl,
                    data: {"action": "wk_check_myshop","shop_slug":self.val(),"nonce":the_mpajax_script.nonce},
                  success: function(response)
                  {
                      if ( response == 0){
                          jQuery('#seller-shop-alert').removeClass('text-success').addClass('text-danger');
                          jQuery('#seller-shop-alert-msg').removeClass('text-success').addClass('text-danger').text(the_mpajax_script.mkt_tr.fajax12);
                        }
                      else if(response == 2){
                          jQuery('#seller-shop-alert').removeClass('text-success').addClass('text-danger');
                          jQuery('#seller-shop-alert-msg').removeClass('text-success').addClass('text-danger').text(the_mpajax_script.mkt_tr.fajax13);
                        }
                      else {
                              jQuery('#seller-shop-alert').removeClass('text-danger').addClass('text-success');
                              jQuery('#seller-shop-alert-msg').removeClass('text-danger').addClass('text-success').text(the_mpajax_script.mkt_tr.fajax14);
                        }
                  }
            });

    });



    // deleting image
    jQuery('a.mp-img-delete_gal').click(function(){
          jQuery('#'+this.id).parent().remove();
            jQuery.ajax({
            type: 'POST',
            url: the_mpajax_script.mpajaxurl,
            data: {"action": "productgallary_image_delete", "img_id":this.id,"nonce":the_mpajax_script.nonce},
            success: function(data){
            jQuery('#product_image_Galary_ids').val(data);
            }
            });
        });


    // variation attribute
    jQuery(document).on('click','#mp_var_attribute_call',function(event){
      event.preventDefault();
      var pid=jQuery('#sell_pr_id').val();
              jQuery.ajax({
              type: 'POST',
              url: the_mpajax_script.mpajaxurl,
              data: {"action": "marketplace_attributes_variation","product":pid,"nonce":the_mpajax_script.nonce},
              beforeSend: function(){
                jQuery('#mp-loader').css('display', 'block');
              },
              success: function(data){
              jQuery('#mp-loader').css('display', 'none');
              jQuery('#mp_attribute_variations').append(data);
              }
              });
          });


    jQuery(document).on('click','.wkmp_var_btn',function(){
      var var_att_id=jQuery(this).attr('id');
      jQuery(this).parent().parent().remove();
      jQuery.ajax({
              type: 'POST',
              url: the_mpajax_script.mpajaxurl,
              data: {"action": "mpattributes_variation_remove","var_id":var_att_id,"nonce":the_mpajax_script.nonce},
              success: function(data){
              }
              });

    });


    jQuery('#mp_attribute_variations').on("click",".mp_varnew_file",function(){
    var var_did=jQuery(this).attr('id');
    var variation_count=jQuery("div#variation_downloadable_file_"+var_did+" > div").length;
    var wrapper='#variation_downloadable_file_'+var_did;
    jQuery.ajax({
            type: 'POST',
            url: the_mpajax_script.mpajaxurl,
            data: {"action": "mp_downloadable_file_add","var_id":var_did,"eleme_no":variation_count,"nonce":the_mpajax_script.nonce},
            success: function(data){
            jQuery(data).appendTo(wrapper);
            }
        });
    });


    /* login with face book function start */
    jQuery('#mp-fb-login-btn').on('click',function(){
      jQuery(window).scrollTop(0)
      jQuery('body').append('<div class="wk-mp-loader"><div class="wk-mp-spinner wk-mp-skeleton"><!--////--></div></div>')
      jQuery('.wk-mp-loader').css('display', 'inline-block')
      jQuery('body').css('overflow', 'hidden')
            function updateButton(response)
            {
            if (response.authResponse)
              {
              //user is already logged in and connected
              FB.api('/me?fields=id,name,email', function(info) {
                login(response, info);
                });
              }
              else
              {
                FB.login(function(response) {
                if (response.authResponse!==null) {

                  var url = window.location;
                  url += '?checkpoint=1&key='+response.authResponse.accessToken;
                  window.location.href = url;

                  }
                }, {scope: 'email', return_scopes: true});
              }
            }
            FB.getLoginStatus(updateButton);
            // FB.Event.subscribe('auth.statusChange', updateButton);


        function login(response, info)
        {
            if ( Object.keys(response.authResponse).length !== 0) {
                var name=info.name;
                var fb_id=info.id;
                var email=info.email;
                jQuery.ajax({
                    type: 'POST',
                    url: the_mpajax_script.mpajaxurl,
                    data: {"action": "mp_login_with_facebook","name":name,"username":email,"email":email,"facebook_info":response,"facebook_id":fb_id,"nonce":the_mpajax_script.nonce},
                  success: function(data)
                  {
                    var url = window.location;
                    url += '?check=1';
                    window.location.href = url;
                  }
                });
              /*Write Your Ajax call Here to store the data in database */
            }

        }
    });

    jQuery('#check-group').on("keyup",function(){
        var character=jQuery(this).val();
        jQuery.ajax({
          type: 'POST',
          dataType: 'json',
          url: the_mpajax_script.mpajaxurl,
          data: {"action": "wk_search_group","group_char":character,"nonce":the_mpajax_script.nonce},
          success: function(data){
            jQuery(".group-selected,.selected").empty();
            if(data==""){
              jQuery(".group-selected").append("<a><span>"+the_mpajax_script.mkt_tr.fajax15+"</span></a>");
            }
            else{
              for(var i=0;i<Object.keys(data._sku).length;i++)
                jQuery(".group-selected").append("<a data-group-id="+data.id[i]+"><span>"+data._sku[i]+"-"+data.post_title[i]+"</span></a>");
            }
          },
           error: function (xhr, ajaxOptions, thrownError) {
                jQuery(".group-selected").append("<a><span>"+the_mpajax_script.mkt_tr.fajax15+"</span></a>");
              }
        });
      });

});
