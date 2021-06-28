<?php
if(!empty($_POST[md5("ht-action")]))
{

  $action = filter_var($_POST[md5("ht-action")], FILTER_SANITIZE_SPECIAL_CHARS);
  switch($action)
  {
    case md5("ht-contato"):

      $nome = filter_var($_POST[md5("ht-nome")], FILTER_SANITIZE_SPECIAL_CHARS);
      $email = filter_var($_POST[md5("ht-email")], FILTER_SANITIZE_EMAIL);
      $telefone = filter_var($_POST[md5("ht-telefone")], FILTER_SANITIZE_SPECIAL_CHARS);
      $mensagem = filter_var($_POST[md5("ht-mensagem")], FILTER_SANITIZE_SPECIAL_CHARS);
      $headers =[
        "Content-Type: text/html; charset=UTF-8",
        "Reply-To: {$nome} <{$email}>",
      ];
      $to = ht_get_contact();
      $tkPage = get_field("ht_options_thank_you", "options") ?? get_home_url();

      if(
        !empty($nome) &&
        !empty($email)
        ){
        $titutlo = "Contato de {$nome} enviado através do site";
        $body = "Nome: <b>{$nome}</b><br>E-mail: <b>{$email}</b><br>";
        if(!empty($telefone))
          $body .= "Telefone: <b>{$telefone}</b><br>";
        if(!empty($duvida))
          $body .= "Mensagem: <br><br><b>{$duvida}</b><br>";


        if(wp_mail( $to["mail"], $titutlo, $mensagem, $headers )){
          if(
            !get_field("ht_options_thank_you", "options") || 
            get_field("ht_options_thank_you", "options") == get_home_url()
            ){
            $_SESSION["ht-success"] = "E-mail enviado com sucesso";
          }
          wp_redirect($thank_you);
          exit;
        }
        else{
          $_SESSION["ht-error"] = "Houve algo errado... Seu e-mail não foi enviado";
        }

      }
      else{
        $_SESSION["ht-error"] = "Por favor, informe seu nome e seu e-mail";
      }
      break;
  }
}
