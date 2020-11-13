
(function ($) {
    "use strict";


    /*==================================================================
    [ Validate after type ]*/
    $('.validate-input .input100').each(function(){
        $(this).on('blur', function(){
            if(validate(this) == false){
                showValidate(this);
            }
            else {
                $(this).parent().addClass('true-validate');
            }
        })
    })


    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
           $(this).parent().removeClass('true-validate');
        });
    });

     function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');

        $(thisAlert).append('<span class="btn-hide-validate">&#xf136;</span>')
        $('.btn-hide-validate').each(function(){
            $(this).on('click',function(){
               hideValidate(this);
            });
        });
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();
        $(thisAlert).removeClass('alert-validate');
        $(thisAlert).find('.btn-hide-validate').remove();
    }



})(jQuery);

var firebaseConfig = {
  apiKey: "AIzaSyC8BOE-GDJXi4a1AHEgkfWfS8H27DsTNjM",
  authDomain: "visit-app-81660.firebaseapp.com",
  databaseURL: "https://visit-app-81660.firebaseio.com",
  projectId: "visit-app-81660",
  storageBucket: "visit-app-81660.appspot.com",
  messagingSenderId: "655133351286",
  appId: "1:655133351286:web:4db0428856c895ec02ee57"
};
var x = document.getElementById("notif-tone");
if ($("#status").length > 0) {
  const csrf_token = $("meta[name='csrf_token']").attr('content');
  firebase.initializeApp(firebaseConfig);
  const messaging = firebase.messaging();
  messaging
  .requestPermission()
  .then(function () {
    return messaging.getToken()
  })
  .then(function(token) {
    $.post(token_url,{token: token,_token: csrf_token,u_type: 'guest',id_request: $("#id-request").text()},function(res){
      if (res.status != 'success') {
        console.log(res);
      }
    },'json');
  })
  .catch(function (err) {
    console.log("Unable to get permission to notify.", err);
  });

  messaging.onMessage((payload) => {
    if (payload.data.type == 'guest' && payload.data.id == $("#id-request").text()) {
      $("title").text("("+(payload.data.action==1?"Disetujui":"Ditolak")+") "+$("title").text());
      var sw = payload.data.action==1?'<span class="p-1 pl-2 pr-2 alert alert-success">Disetujui</span>':'<span class="p-1 pl-2 pr-2 alert alert-danger">Ditolak</span>';
      $("#status").html(sw);
      $(".dstatus").removeClass('d-none');
      $("#approved_by").text(payload.data.approved_by);
      $("#keterangan").text(payload.data.keterangan);
      $("#status").prop('id','');
      x.play()
    }
  });
}
