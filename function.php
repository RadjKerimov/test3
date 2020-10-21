<?php
  //Проверяеv сушествует ли такой пользыватель, tсли да то return email и password
  function get_user_by_email ($email, $pdo){
    $prepare = $pdo->prepare("SELECT email, pass FROM `users` WHERE `email` = :email");
    $prepare->execute(['email' => $email]);
    return $prepare->fetch(PDO::FETCH_ASSOC);
  };

  // Добовляет пользывателя
  function add_user($email, $pass, $pdo){
    $pass =  password_hash($pass, PASSWORD_DEFAULT);
    $prepare = $pdo->prepare('INSERT INTO users(email, pass) VALUES (:email, :pass)');
    $prepare->execute(['email' => $email, 'pass' => $pass]);
    return $pdo->lastInsertId();     
  };

  //Подготовка сообщения 
  function set_flash_message($name, $message){
    $_SESSION[$name] = $message;
  };

  function display_flash_message($name){ 
    if (isset($_SESSION[$name])) {
      echo "<div class=\"alert alert-$name\">$_SESSION[$name]</div>";
      unset($_SESSION[$name]);
    }
  };

  function redirect_to($path){
    header("Location: $path");
  };
  ////////////////////////// 

  /*
    Проверяем если такой email БД 
    return array [email, pass]
  */
  function if_the_user($email, $pass, $pdo){
    $prepare = $pdo->prepare("SELECT `email`,`pass` FROM `users` WHERE `email` = :email ");
    $prepare->execute(['email' => $email]);
    return $prepare->fetch(PDO::FETCH_ASSOC); 
  }