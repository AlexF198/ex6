<?php
header('Content-Type: text/html; charset=UTF-8');

  $user = 'u47564';
  $pass = '7204156';
  $db = new PDO('mysql:host=localhost;dbname=u47564', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.<br>';
    if (!empty($_COOKIE['pass'])) {
      $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['pass']));
    }
  }

  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['mail'] = !empty($_COOKIE['mail_error']);
  $errors['date'] = !empty($_COOKIE['date_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['limb'] = !empty($_COOKIE['limb_error']);
  $errors['super'] = !empty($_COOKIE['super_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['check1'] = !empty($_COOKIE['check1_error']);

  if ($errors['name']) {
    setcookie('name_error', '', 100000);
    $messages['name_message'] = '<div class="error">Заполните имя.</div>';
  }
  if ($errors['mail']) {
    setcookie('mail_error', '', 100000);
    $messages['mail_message'] = '<div class="error">Заполните e-mail.</div>';
  }
  if ($errors['date']) {
    setcookie('date_error', '', 100000);
    $messages['date_message'] = '<div class="error">Выберите дату рождения</div>';
  }
  if ($errors['sex']) {
    setcookie('sex_error', '', 100000);
    $messages['sex_message'] = '<div class="error">Укажите ваш пол</div>';
  }
  if ($errors['limb']) {
    setcookie('limb_error', '', 100000);
    $messages['limb_message'] = '<div class="error">Выберите количество конечностей</div>';
  }
  if ($errors['super']) {
    setcookie('super_error', '', 100000);
    $messages[] = '<div class="error">Выберите хотя бы одну сверхспособность</div>';
  }
  if ($errors['bio']) {
    setcookie('bio_error', '', 100000);
    $messages['bio_message'] = '<div class="error">Введите информацию о себе</div>';
  }
  if ($errors['check1']) {
    setcookie('check1_error', '', 100000);
    $messages['check1_message'] = '<div class="error">Вы не можете отправить форму, не ознакомившись с контрактом</div>';
  }

  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['mail'] = empty($_COOKIE['mail_value']) ? '' : $_COOKIE['mail_value'];
  $values['date'] = empty($_COOKIE['date_value']) ? '' : $_COOKIE['date_value'];
  $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
  $values['limb'] = empty($_COOKIE['limb_value']) ? '' : $_COOKIE['limb_value'];
  $values['super'] = [];
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['check1'] = empty($_COOKIE['check1_value']) ? '' : $_COOKIE['check1_value'];

  $super = array(
    '1' => "1",
    '2' => "2",
	'3' => "3",
	'4' => "4",
  );
  
if(!empty($_COOKIE['super_value'])) {
    $super_value = unserialize($_COOKIE['super_value']);
    foreach ($super_value as $s) {
      if (!empty($super[$s])) {
          $values['super'][$s] = $s;
      }
    }
  }

  if (!empty($_COOKIE[session_name()]) &&
  session_start() && !empty($_SESSION['login'])) {
    try{
      $sth = $db->prepare("SELECT id FROM users6 WHERE login = ?");
      $sth->execute(array($_SESSION['login']));
      $user_id = ($sth->fetchAll(PDO::FETCH_COLUMN, 0))['0'];
      $sth = $db->prepare("SELECT * FROM application6 WHERE id = ?");
      $sth->execute(array($user_id));
      $values['super'] = [];
      $super_value = unserialize($_COOKIE['super_value']);
        foreach ($super_value as $s) {
            if (!empty($super[$s])) {
                $values['super'][$s] = $s;
            }
        }

      } 
      catch(PDOException $e) {
          print($e->getMessage());
          exit();
      }
  }
  include('form.php');
}

else {
  $errors = FALSE;
// ИМЯ
if (empty($_POST['name'])) {
    setcookie('name_error', ' ', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
  }
  // EMAIL
  if (empty($_POST['mail'])){
    setcookie('mail_error', ' ', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('mail_value', $_POST['mail'], time() + 30 * 24 * 60 * 60);
  }

  // Дата
  if ($_POST['date']=='') {
    setcookie('date_error', ' ', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('date_value', $_POST['date'], time() + 30 * 24 * 60 * 60);
  }

  // ПОЛ
  if (empty($_POST['sex'])) {
    setcookie('sex_error', ' ', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else{
  setcookie('sex_value', $_POST['sex'], time() + 30 * 24 * 60 * 60);
  }

  // КОНЕЧНОСТИ
  if (empty($_POST['limb'])) {
    setcookie('limb_error', ' ', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('limb_value', $_POST['limb'], time() + 30 * 24 * 60 * 60);
  }

  // СВЕРХСПОСОБНОСТИ
  if(empty($_POST['super'])){
    setcookie('super_error', ' ', time() + 24 * 60 * 60);
    setcookie('super_value', '', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else{
    foreach ($_POST['super'] as $key => $value) {
      $super[$key] = $value;
    }
    setcookie('super_value', serialize($super), time() + 30 * 24 * 60 * 60);
  }

  // ИНФОРМАЦИЯ О СЕБЕ
  if (empty($_POST['bio'])) {
    setcookie('bio_error', ' ', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
  }

  // СОГЛАСИЕ
  if (empty($_POST['check1'])) {
    setcookie('check1_error', ' ', time() + 24 * 60 * 60);
    setcookie('check1_value', '', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('check1_value', $_POST['check1'], time() + 30 * 24 * 60 * 60);
  }

  if ($errors) {
    header('Location: index.php');
    exit();
  }
  else {
    setcookie('name_error', '', 100000);
    setcookie('mail_error', '', 100000);
    setcookie('date_error', '', 100000);
    setcookie('sex_error', '', 100000);
    setcookie('limb_error', '', 100000);
    setcookie('super_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('check1_error', '', 100000);
  }

 if (!empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
    try {
      $stmt = $db->prepare("SELECT id FROM users6 WHERE login =?");
      $stmt -> execute(array($_SESSION['login'] ));
      $user_id = ($stmt->fetchAll(PDO::FETCH_COLUMN))['0'];

      $stmt = $db->prepare("UPDATE application6 SET name = ?, mail = ?, date = ?, sex = ?, limb = ?, bio = ? WHERE id =?");
      $stmt -> execute(array(
          $_POST['name'],
          $_POST['mail'],
          $_POST['date'],
          $_POST['sex'],
          $_POST['limb'],
          $_POST['bio'],
          $user_id,
      ));
      $sth = $db->prepare("DELETE FROM supers6 WHERE id = ?");
      $sth->execute(array($user_id));
      $stmt = $db->prepare("INSERT INTO supers6 SET id = ?, superpowers = ?");
      foreach($_POST['super'] as $s){
          $stmt -> execute(array(
            $user_id,
            $s,
          ));
        }
      }
    catch(PDOException $e){
      print('Error: ' . $e->getMessage());
      exit();
    }
  }
  else {
    $sth = $db->prepare("SELECT login FROM users6");
    $sth->execute();
    $login_array = $sth->fetchAll(PDO::FETCH_COLUMN);
    $flag=true;
    do{
      $login = rand(1,1000);
      $pass = rand(1,10000);
      foreach($login_array as $key=>$value){
        if($value == $login)
          $flag=false;
      }
    }while($flag==false);
    $hash = password_hash((string)$pass, PASSWORD_BCRYPT);
    setcookie('login', $login);
    setcookie('pass', $pass);

    try {
      $stmt = $db->prepare("INSERT INTO application6 SET name = ?, mail = ?, date = ?, sex = ?, limb = ?, bio = ?");
      $stmt -> execute(array(
          $_POST['name'],
          $_POST['mail'],
          $_POST['date'],
          $_POST['sex'],
          $_POST['limb'],
          $_POST['bio'],
        )
      );

      $id_db = $db->lastInsertId();
      $stmt = $db->prepare("INSERT INTO supers6 SET id = ?, superpowers = ?");
      foreach($_POST['super'] as $s){
          $stmt -> execute(array(
            $id_db,
            $s,
          ));
        }
      $stmt = $db->prepare("INSERT INTO users6 SET login = ?, pass = ?");
      $stmt -> execute(array(
          $login,
          $hash,
        )
      );
    }
    catch(PDOException $e){
      print('Error: ' . $e->getMessage());
      exit();
    }
  }
  
  setcookie('save', '1');
  header('Location: index.php');
}