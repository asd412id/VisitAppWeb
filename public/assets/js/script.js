String.prototype.format = function() {
  var formatted = this;
  for (var i = 0; i < arguments.length; i++) {
    var regexp = new RegExp('\\{'+i+'\\}', 'gi');
    formatted = formatted.replace(regexp, arguments[i]);
  }
  return formatted;
};

(function($) {
  showSuccessToast = function(text) {
    'use strict';
    resetToastPosition();
    $.toast({
      heading: 'Berhasil!',
      text: text,
      showHideTransition: 'slide',
      icon: 'success',
      loaderBg: '#f96868',
      position: 'top-right'
    })
  };
  showInfoToast = function() {
    'use strict';
    resetToastPosition();
    $.toast({
      heading: 'Info',
      text: 'And these were just the basic demos! Scroll down to check further details on how to customize the output.',
      showHideTransition: 'slide',
      icon: 'info',
      loaderBg: '#46c35f',
      position: 'top-right'
    })
  };
  showWarningToast = function() {
    'use strict';
    resetToastPosition();
    $.toast({
      heading: 'Warning',
      text: 'And these were just the basic demos! Scroll down to check further details on how to customize the output.',
      showHideTransition: 'slide',
      icon: 'warning',
      loaderBg: '#57c7d4',
      position: 'top-right'
    })
  };
  showDangerToast = function(text) {
    'use strict';
    resetToastPosition();
    $.toast({
      heading: 'Kesalahan!',
      text: text,
      showHideTransition: 'slide',
      icon: 'error',
      loaderBg: '#f2a654',
      position: 'top-right'
    })
  };
  showToastPosition = function(position) {
    'use strict';
    resetToastPosition();
    $.toast({
      heading: 'Positioning',
      text: 'Specify the custom position object or use one of the predefined ones',
      position: String(position),
      icon: 'success',
      stack: false,
      loaderBg: '#f96868'
    })
  }
  showToastInCustomPosition = function() {
    'use strict';
    resetToastPosition();
    $.toast({
      heading: 'Custom positioning',
      text: 'Specify the custom position object or use one of the predefined ones',
      icon: 'success',
      position: {
        left: 120,
        top: 120
      },
      stack: false,
      loaderBg: '#f96868'
    })
  }
  resetToastPosition = function() {
    $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center'); // to remove previous position class
    $(".jq-toast-wrap").css({
      "top": "",
      "left": "",
      "bottom": "",
      "right": ""
    }); //to remove previous position style
  }

  $(".currency").autoNumeric('init');
  // $(document).on('contextmenu',function(){
  //   return false;
  // })
})(jQuery);

if ($(".toggle").length>0) {
  var elemsingle = document.querySelector('.toggle');
  var switchery = new Switchery(elemsingle, {
      color: '#4099ff',
      jackColor: '#fff',
  });
}

var language = {
  "decimal":        "",
  "emptyTable":     "Data tidak tersedia",
  "info":           "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
  "infoEmpty":      "Menampilkan 0 sampai 0 dari 0 data",
  "infoFiltered":   "(Difilter dari _MAX_ total data)",
  "infoPostFix":    "",
  "thousands":      ",",
  "lengthMenu":     "Menampilkan _MENU_ data",
  "loadingRecords": "Memuat...",
  "processing":     "Memproses...",
  "search":         "Cari:",
  "zeroRecords":    "Pencarian tidak ditemukan",
  "paginate": {
    "first":      "Pertama",
    "last":       "Terakhir",
    "next":       "Selanjutnya",
    "previous":   "Sebelumnya"
  }
};

$(".confirm").on('click',function(){
  var txt = $(this).data('text');
  if (!confirm(txt)) {
    return false;
  }
});

$('.pendidikan').repeater({
  // (Optional)
  // "defaultValues" sets the values of added items.  The keys of
  // defaultValues refer to the value of the input's name attribute.
  // If a default value is not specified for an input, then it will
  // have its value cleared.
  defaultValues: {
    'status_pendidikan': 'negeri',
  },
  // (Optional)
  // "show" is called just after an item is added.  The item is hidden
  // at this point.  If a show callback is not given the item will
  // have $(this).show() called on it.
  show: function() {
    $(this).slideDown();
  },
  // (Optional)
  // "hide" is called when a user clicks on a data-repeater-delete
  // element.  The item is still visible.  "hide" is passed a function
  // as its first argument which will properly remove the item.
  // "hide" allows for a confirmation step, to send a delete request
  // to the server, etc.  If a hide callback is not given the item
  // will be deleted.
  hide: function(deleteElement) {
    if (confirm('Hapus data pada baris ini?')) {
      $(this).slideUp(deleteElement);
    }
  },
  // (Optional)
  // Removes the delete button from the first list item,
  // defaults to false.
  isFirstItemUndeletable: true
});

$('.file-upload-browse').on('click', function(e) {
  e.stopPropagation();
  e.stopImmediatePropagation();
  var file = $(this).parent().parent().parent().find('.file-upload-default');
  file.trigger('click');
});
$('.file-upload-default').on('change', function(e) {
  e.stopPropagation();
  e.stopImmediatePropagation();
  $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
});

$("#form-import").submit(function(){
  $(this).find("button[type='submit']").prop('disabled',true);
  $(this).find("button[type='submit']").html('Sedang mengimport ...');
})

if ($("#table-users").length>0) {
  var table = $("#table-users").DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: location.href,
    columns: [
      {data: 'id'},
      {data: 'name', name: 'name'},
      {data: 'ruang', name: 'ruang'},
      {data: 'tgl_dibuat', name: 'tgl_dibuat'},
      {data: 'action', name: 'action', orderable: false, searchable: false}
    ],
    "language": language,
    'drawCallback': function(settings){
      $(".confirm").on('click',function(){
        var txt = $(this).data('text');
        if (!confirm(txt)) {
          return false;
        }
      });
    }
  });
}
if ($("#table-ruang").length>0) {
  var table = $("#table-ruang").DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: location.href,
    columns: [
      {data: 'id'},
      {data: 'nama', name: 'nama'},
      {data: 'kepala', name: 'kepala'},
      {data: 'telp', name: 'telp'},
      {data: 'status_text', name: 'status_text'},
      {data: 'action', name: 'action', orderable: false, searchable: false}
    ],
    "language": language,
    "drawCallback": function(settings){
      $(".confirm").on('click',function(){
        var txt = $(this).data('text');
        if (!confirm(txt)) {
          return false;
        }
      });
    }
  });
}
if (table!=undefined) {
  table.on( 'draw.dt', function () {
    var PageInfo = $('.dataTable').DataTable().page.info();
    table.column(0, {search: 'applied', order: 'applied', page: 'applied'}).nodes().each( function (cell, i) {
      cell.innerHTML = (i+1+PageInfo.start)+'.';
    });
  }).draw();
}

$.fn.select2.amd.define('select2/selectAllAdapter', [
  'select2/utils',
  'select2/dropdown',
  'select2/dropdown/attachBody'
], function (Utils, Dropdown, AttachBody) {
  function SelectAll() { }
  SelectAll.prototype.render = function (decorated) {
    var self = this,
    $rendered = decorated.call(this),
    $selectAll = $(
      '<button class="btn btn-xs btn-primary" type="button" style="margin-left:6px;padding: 3px 7px;">Pilih Semua</button>'
    ),
    $unselectAll = $(
      '<button class="btn btn-xs btn-default" type="button" style="margin-left:6px;padding: 3px 7px;">Batalkan Semua</button>'
    ),
    $btnContainer = $('<div style="margin-top:3px;">').append($selectAll).append($unselectAll);
    if (!this.$element.prop("multiple")) {
      // this isn't a multi-select -> don't add the buttons!
      return $rendered;
    }
    $rendered.find('.select2-dropdown').prepend($btnContainer);
    $selectAll.on('click', function (e) {
      var $results = $rendered.find('.select2-results__option[aria-selected=false]');
      $results.each(function () {
        self.trigger('select', {
          data: $(this).data('data')
        });
      });
      self.trigger('close');
    });
    $unselectAll.on('click', function (e) {
      self.$element.find('option').prop('selected',false).trigger('change');
      self.trigger('close');
    });
    return $rendered;
  };
  return Utils.Decorate(
    Utils.Decorate(
      Dropdown,
      AttachBody
    ),
    SelectAll
  );
});
$(".select2").select2();
$(".select2-ajax").each(function(){
  var url = $(this).data('url');
  var placeholder = $(this).data('placeholder');
  $(this).select2({
    placeholder: placeholder,
    minimumInputLength: 1,
    ajax: {
      url: url,
      dataType: 'json',
      delay: 250,
      closeOnSelect: false
    }
  });
})
$(".select2-ajax-multiple").each(function(){
  var url = $(this).data('url');
  var placeholder = $(this).data('placeholder');
  $(this).select2({
    multiple: true,
    placeholder: placeholder,
    dropdownAdapter: $.fn.select2.amd.require('select2/selectAllAdapter'),
    minimumInputLength: 1,
    ajax: {
      url: url,
      dataType: 'json',
      delay: 250,
      closeOnSelect: false
    }
  });
});
// $("a").not('.confirm,.direct').each(function(){
//   var _t = $(this);
//   if (_t.attr('href')!=''&&_t.attr('href')!='javascript:void(0)') {
//     var _u = _t.attr('href');
//     _t.attr('href','javascript:void(0)');
//     _t.attr('data-url',_u);
//   }
//
//   _t.click(function(){
//     if ($(this).data('url')!='#'&&$(this).data('url')!='javascript:void(0)') {
//       location.href = $(this).data('url');
//     }
//   });
// })

if ($("#notif-tone").length > 0) {
  var x = document.getElementById("notif-tone");
  var firebaseConfig = {
    apiKey: "AIzaSyC8BOE-GDJXi4a1AHEgkfWfS8H27DsTNjM",
    authDomain: "visit-app-81660.firebaseapp.com",
    databaseURL: "https://visit-app-81660.firebaseio.com",
    projectId: "visit-app-81660",
    storageBucket: "visit-app-81660.appspot.com",
    messagingSenderId: "655133351286",
    appId: "1:655133351286:web:4db0428856c895ec02ee57"
  };
  firebase.initializeApp(firebaseConfig);
  const messaging = firebase.messaging();

  const csrf_token = $("meta[name='csrf_token']").attr('content');
  const u_type = $("meta[name='u_type']").attr('content');
  const u_uuid = $("meta[name='u_uuid']").attr('content');

  messaging
  .requestPermission()
  .then(function () {
    return messaging.getToken()
  })
  .then(function(token) {
    $.post(token_url,{token: token,_token: csrf_token,u_type: u_type},function(res){
      if (res.status != 'success') {
        console.log(res);
      }
    },'json');
  })
  .catch(function (err) {
    console.log("Unable to get permission to notify.", err);
  });

  var notif = `
  <a href="{0}" class="media">
  <span class="d-flex">
  <i class="ik ik-check"></i>
  </span>
  <span class="media-body">
  <span class="heading-font-family media-heading">{1}</span>
  </span>
  </a>
  `;
  if ($("#notif-count").length > 0) {
    var ncount = Number($("#notif-count").text());
    var ruang = $("meta[name='ruang']").attr('content').split(',');
    messaging.onMessage((payload) => {
      if (ruang.includes(payload.data.id) && payload.data.type == 'ruang') {
        ncount++;
        $("title").html("("+ncount+") "+$("title").text());
        $("#notif-count").text(ncount);
        if (!$("#notif-count").is(":visible")) {
          $("#notif-count").removeClass("d-none");
          $("#notif-none").remove();
        }
        var n = notif.format(payload.data.url,payload.data.message);
        $(".notifications-wrap").prepend(n);
        $("#newnotif").removeClass('d-none');
        x.play();
      }
    });
  }
}
