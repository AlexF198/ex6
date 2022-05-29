<!DOCTYPE html>

<html lang="ru">

  <head>
    <meta charset="UTF-8">
    <title>Задание 6</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
  <?php 
		if (!empty($messages)) {
			if(isset($messages['save'])) print('<div id="messages" class="ok">'); else print('<div id="messages">');
			foreach ($messages as $message) {
				print($message);
			}
		  print('</div>');
		}
	?>
   <a href="login.php">Вход для пользователя</a><br>
   <a href="admin.php">Вход для админа</a>
   <div id="form">
    <div class="form1">
	<form action="" method="POST">
	
        <input type="text" name="name" placeholder="Ваше имя" 
        <?php if (!empty($errors['name'])) {print 'class="error"';} ?> 
        <?php if(empty($errors['name'])&&!empty($values['name'])) print 'class="ok"';?> 
        value="<?php isset($_COOKIE['name_error'])? print trim($_COOKIE['name_error']) : print $values['name']; ?>">
      <br />
	  
        <input type="text" id="mail" placeholder="Ваш email" name="mail" 
        <?php if(!empty($errors['mail']))  print 'class="error"';?> 
        <?php if(empty($errors['mail'])&&!empty($values['mail'])) print 'class="ok"';?> 
        value="<?php isset($_COOKIE['mail_error'])? print trim($_COOKIE['mail_error']) : print $values['mail']; ?>">
      <br />
	  
      <label for="date"> Дата рождения: </label><br />
        <input type="date" id="date" name="date" <?php if(!empty($errors['date']))  
        print 'class="error"';?> <?php if(empty($errors['date'])&&!empty($values['date'])) 
        print 'class="ok"';?> value="<?php isset($_COOKIE['date_error'])? print trim($_COOKIE['date_error']) : 
        print $values['date']; ?>">
      <br />
	  
	  <label <?php if(!empty($errors['sex'])) print 'class="error_check"'?>>
       Пол: </label><br />
      <input type="radio" id="male"name="sex" value="male" 
      <?php if (isset($values['sex'])&&$values['sex'] == 'male') print("checked"); ?>>
      мужской
      <input type="radio" id="female" name="sex" value="female" 
      <?php if (isset($values['sex'])&&$values['sex'] == 'female') print("checked"); ?>>
      женский<br />
	  
	  <label <?php if(isset($_COOKIE['limb_error'])) print 'class="error_check"'?>>
       Количество конечностей: </label><br />
      <input type="radio" id="1" name="limb" value="1" 
      <?php if (isset($values['limb'])&&$values['limb'] == '1') print("checked"); ?>>1
	  <input type="radio" id="2" name="limb" value="2" 
      <?php if (isset($values['limb'])&&$values['limb'] == '2') print("checked"); ?>>2
	  <input type="radio" id="3" name="limb" value="3" 
      <?php if (isset($values['limb'])&&$values['limb'] == '3') print("checked"); ?>>3
      <input type="radio" id="4" name="limb" value="4" 
      <?php if (isset($values['limb'])&&$values['limb'] == '4') print("checked"); ?>>4<br />	
	  
	   Сверхспособности: <br />
      <label><select name="super[]" multiple="multiple" 
      <?php if (!empty($errors['super'])) print 'class="error"';?>>
        <?php
				$sql = 'SELECT * FROM SuperDef';
				foreach ($db->query($sql) as $row) {
					?><option value=<?php print $row['id']?> 
                    name=super[] <?php if(isset($values['super'][$row['id']])&&empty($_COOKIE['super_error']))print("checked"); print "\t"; ?>>
					<?php print $row['name'] . "\t";
				}
			?></option>
		</select>
      </label><br />
	  
        <textarea id="bio" name="bio" placeholder="Расскажите о себе..." 
        <?php if(!empty($errors['bio']))  print 'class="error"';?> 
        <?php if(empty($errors['bio'])&&!empty($values['bio'])) print 'class="ok"';?>>
        <?php isset($_COOKIE['bio_error']) ? print trim($_COOKIE['bio_error']) : 
        print $values['bio'] ?></textarea>
      <br />
	  
	  <label <?php if(!empty($errors['check1'])) print 'class="error_check"'?>>
       С контрактом ознакомлен(а) </label>
      <input type="checkbox" id="check1" name="check1" value="check1" 
      <?php if (isset($values['check1'])&&$values['check1'] == 'check1') 
      print("checked"); ?>><br />
	  
      <p><button type="submit" value="send">Отправить</p>
    </form>
    </div>
	<?php if(!empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])) 
    print( '<div id="footer">Вход с логином ' . $_SESSION["login"]. '<br> <a href=login.php?do=logout> Выход</a><br></div>');?>
    </div>
  </body>
</html>