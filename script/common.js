$(function () {


  $("#gnb li").click(function () {
    $(this)
      .find("div")
      .find("i.fa-solid")
      .toggleClass("on")
      .parent()
      .parent()
      .siblings()
      .find("i.fa-solid")
      .removeClass("on");

    $("#gnb li").find(".lnb").stop().slideUp();
    $(this).find(".lnb").stop().slideToggle();
  });

  $('#h_wrap-mobile').click(function(){
    $('#h_side').toggleClass('act');
    $(this).toggleClass('act');
  }
  );

});