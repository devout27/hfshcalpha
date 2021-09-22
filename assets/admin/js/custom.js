(function ($) {

  $(document).ready(function(){
    $('.treeview > a').click(function(){
      // $(this).parent().toggleClass('active').siblings().removeClass("active");
      $(this).parent().toggleClass('active');
      $(this).parent().find(".treeview-menu").slideToggle();
    });
    $('.menu-icon').click(function(){
      $("body").toggleClass("sidebar-active");
      $(this).toggleClass("active");
      $('.layer').toggleClass("active");
    });
    $('.layer').click(function(){
      $("body").removeClass("sidebar-active");
      $(this).removeClass("active");
      $(".menu-icon").removeClass("active");
    });
    /*$("#multiple-campaign").bsMultiSelect();
    $("#multiple-campaign").dashboardCodeBsMultiSelect();*/
  });
})(jQuery)