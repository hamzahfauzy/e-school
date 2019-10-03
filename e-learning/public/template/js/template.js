(function($) {
  'use strict';
  $(function() {
    var body = $('body');
    var contentWrapper = $('.content-wrapper');
    var scroller = $('.container-scroller');
    var footer = $('.footer');
    var sidebar = $('.sidebar');

    //Add active class to nav-link based on url dynamically
    //Active class can be hard coded directly in html file also as required

    function addActiveClass(element) {
      if(element.attr('href') == "/"){
        var curr = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');;
        if(curr == "")
        {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
        }
      }else if (current === "") {
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
        // if (element.attr('href').indexOf(current) !== -1) {
        if (current.includes(element.attr('href')) && element.attr('href') != "/") {
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

    var current = location.href //.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
    setTimeout(()=>{
      $('.nav li a', sidebar).each(function() {
        var $this = $(this);
        addActiveClass($this);
      })
    },500)

    //Close other submenu in sidebar on opening any

    sidebar.on('show.bs.collapse', '.collapse', function() {
      sidebar.find('.collapse.show').collapse('hide');
    });


    //Change sidebar 
    $('[data-toggle="minimize"]').on("click", function() {
      body.toggleClass('sidebar-icon-only');
    });

    //checkbox and radios
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');

  });

  // focus input when clicking on search icon
  $('#navbar-search-icon').click(function() {
    $("#navbar-search-input").focus();
  });
  
})(jQuery);