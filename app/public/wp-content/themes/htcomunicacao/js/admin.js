//JS para o Dashboard
jQuery(document).ready(function($) {
  $('.ht-mask__money').mask('#.##0,00', {reverse: true, placeholder : "0,00"});
  $('.ht-mask__date input').mask("00/00/0000", {placeholder: "__/__/____"});
  $('.ht-mask__cnpj input').mask('00.000.000/0000-00');
  $('.ht-mask__cpf input').mask('000.000.000-00');
  $('.ht-mask__cep input').mask("00000-000", {placeholder: "_____-___"});
  var optionsPhone = {onKeyPress : function(val){}}
  var SPMaskBehavior = function (val) { return val.replace(/\D/g, '').length === 11 ? '(00) 0 0000-0000' : '(00) 0000-00009'; }, spOptions = { placeholder: "(XX) X XXXX-XXXX", onKeyPress: function(val, e, field, options) { field.mask(SPMaskBehavior.apply({}, arguments), options); } };
  $('.ht-mask__tel input').mask(SPMaskBehavior, spOptions);

  var product = $("#products_page");
  $(".row-products_page").hide();
  $("#front-static-pages ul").append("<li class=\"ht-product-page\">Página de produtos: </li>");
  $(".ht-product-page").append(product);
});
