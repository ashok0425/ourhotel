(function($) {
  'use strict';
  $(function() {
    var body = $('body');
    var contentWrapper = $('.content-wrapper');
    var scroller = $('.container-scroller');
    var footer = $('.footer');
    var sidebar = $('.sidebar');
    var menuicon=$('.navbar-toggler')

    //Add active class to nav-link based on url dynamically
    //Active class can be hard coded directly in html file also as required

    menuicon.click(function(){
        sidebar.toggleClass('sidebar-offcanvas')
    })

    function addActiveClass(element) {
      if (current === "") {
        //for root url
        if (element.attr('href').indexOf("index.html") !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
        }
      } else {
        //for other url
        if (element.attr('href').indexOf(current) !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
          if (element.parents('.submenu-item').length) {
            element.addClass('active');
          }
        }
      }
    }

    var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
    $('.nav li a', sidebar).each(function() {
      var $this = $(this);
      addActiveClass($this);
    })

    $('.horizontal-menu .nav li a').each(function() {
      var $this = $(this);
      addActiveClass($this);
    })

    //Close other submenu in sidebar on opening any

    sidebar.on('show.bs.collapse', '.collapse', function() {
      sidebar.find('.collapse.show').collapse('hide');
    });


    //Change sidebar and content-wrapper height
    applyStyles();

    function applyStyles() {
      //Applying perfect scrollbar
      if (!body.hasClass("rtl")) {
        if ($('.settings-panel .tab-content .tab-pane.scroll-wrapper').length) {
          const settingsPanelScroll = new PerfectScrollbar('.settings-panel .tab-content .tab-pane.scroll-wrapper');
        }
        if ($('.chats').length) {
          const chatsScroll = new PerfectScrollbar('.chats');
        }
        if (body.hasClass("sidebar-fixed")) {
          if($('#sidebar').length) {
            var fixedSidebarScroll = new PerfectScrollbar('#sidebar .nav');
          }
        }
      }
    }

    $('[data-toggle="minimize"]').on("click", function() {
      if ((body.hasClass('sidebar-toggle-display')) || (body.hasClass('sidebar-absolute'))) {
        body.toggleClass('sidebar-hidden');
      } else {
        body.toggleClass('sidebar-icon-only');
      }
    });

    //checkbox and radios
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');

    //Horizontal menu in mobile
    $('[data-toggle="horizontal-menu-toggle"]').on("click", function() {
      $(".horizontal-menu .bottom-navbar").toggleClass("header-toggled");
    });
    // Horizontal menu navigation in mobile menu on click
    var navItemClicked = $('.horizontal-menu .page-navigation >.nav-item');
    navItemClicked.on("click", function(event) {
      if(window.matchMedia('(max-width: 991px)').matches) {
        if(!($(this).hasClass('show-submenu'))) {
          navItemClicked.removeClass('show-submenu');
        }
        $(this).toggleClass('show-submenu');
      }
    })

    $(window).scroll(function() {
      if(window.matchMedia('(min-width: 992px)').matches) {
        var header = $('.horizontal-menu');
        if ($(window).scrollTop() >= 70) {
          $(header).addClass('fixed-on-scroll');
        } else {
          $(header).removeClass('fixed-on-scroll');
        }
      }
    });
  });

  // focus input when clicking on search icon
  $('#navbar-search-icon').click(function() {
    $("#navbar-search-input").focus();
  });

})(jQuery);


let fileLimit=8;
function previewUploadImage(input, element_id) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            $(`#${element_id}`).removeClass('d-none');
            $(`#${element_id}`).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$('#thumb').change(function () {
    previewUploadImage(this, 'preview_thumb')
});


$('#mobile_thumbnail').change(function () {
    previewUploadImage(this, 'mobile_thumbnail_preview')
});



$('#gallery').change(function (e) {

    if($('.remove_gallery').length>=fileLimit){
        $('.max_file').html(`Only ${fileLimit} File can be uploaded`);
        return false;
    }
    e.stopPropagation()
    stop()
    $('.max_file').html('');

    var form_data = new FormData();
    form_data.append('image', this.files[0]);
    form_data.append('_token',$("meta[name='csrf_token']").attr('content'));
    $.ajax({
        url: '/upload-image',
        data: form_data,
        type: 'POST',
        contentType: false,
        processData: false,
        success: function (res)  {
                if (res.code === 200) {

                    if(res.status=='error'){
                        console.log(res.file_name)
                        $('.max_file').html(res.file_name);
                   return false;
                    }

        $('#gallery_preview').append(`
        <div style="position:relative;width:100px">
        <input type="hidden" name="gallery[]" value="${res.file_name}"/>
        <img src="${res.file_path}" alt="" width='100' height='100'>
        <a style="position:absolute;top:10px;right:10px;color:red;cursor:pointer"  class="remove_gallery" id="${res.file_name}"><i class='fas fa-trash'></i></a>
        </div>
        `)
    };
}
            });

 });

 $(document).on('click','.remove_gallery',function(e){
    e.stopPropagation()
    stop();
    $('.max_file').html('');
    let image=$(this).attr('id');
    let id=$(this).attr('data-id');
    let model=$(this).attr('data-model');

  $(this).parent().remove();

  $.ajax({
    url: `/delete-image?image=${image}&id=${id}&model=${model}`,
    type: 'GET',
    contentType: false,
    processData: false,
    success: function (res) {
        console.log(res);
    }
});
 })
