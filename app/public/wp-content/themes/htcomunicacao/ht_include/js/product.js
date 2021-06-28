jQuery(document).ready(function($) {

  $("html").on("click",".ht-control__number",function(){

    var field = $(this).find(".ht-control__input");
    var value = field.val();
    var min = field.attr("min");
    var max = field.attr("max");

    $(this).find(".ht-control__button--plus").on("click", function(e){
      e.preventDefault();
      if(value < max)
        value++;
      field.val(value);
    });

    $(this).find(".ht-control__button--minus").on("click", function(e){
      e.preventDefault();
      if(value > min)
        value--;
      field.val(value);
    });

    $(this).find(".ht-control__input").on("keyup", function(){
      value = $(this).val();
    });

  });

  $("html").on("click", ".ht-produtos-sidebar__wait--js .ht-produtos-sidebar__item", function(){
    $(".ht-produtos-sidebar__wait").css("display", "flex");
    $(".ht-produtos-sidebar__wait").hide();
    $(".ht-produtos-sidebar__wait").fadeIn();
    $(".ht-produtos-sidebar__wait--js").submit();

  });

  $(".ht-produtos-sidebar__show--js").on("click", function(){
    $("html").toggleClass("ht-produtos-sidebar__wrapper--active")
  })

  $(".ht-carrinho__list--js").hide();
  $(".ht-carrinho__list--show-js").on("click",function(){
    $(this).prev().slideToggle();
  })

});
