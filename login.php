<?php
  session_start();
  require('sql.php');
  require('../function.php');

  $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
  $pass = trim(filter_var($_POST['password'],FILTER_SANITIZE_STRING));
  $checkbox = $_POST['checkbox'];



  $result = if_the_user($email, $pass, $pdo);

  if (password_verify($pass, $result['pass'])){
    if (isset($checkbox))
      $_SESSION['email'] = $email;
    redirect_to('../users.php');   
  }
  elseif ($result['email'] != $email) {
    set_flash_message('danger', 'Пользователь с таким Email ( '.$email.' ) не найден!');
    redirect_to('../page_register.php');      
  }
  else{
    set_flash_message('danger', 'Неправельный логин или пароль!');
    redirect_to('../page_login.php');
  }