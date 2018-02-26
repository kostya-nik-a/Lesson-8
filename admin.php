<?php

require_once 'function.php';

if(!isAuthorized()) {
    http_response_code(403);
    die();
}

if (isAuthorized()) {
    foreach (getUsers() as $user) {
        if (($_SESSION['user'] == $user['login'] && $_SESSION['user'] == $user['password']) || isGuest()) {
            $_SESSION['user'] = $user;
        }
    $errors[] = 'Неверный логин или пароль';
    }
}

echo "Добро пожаловать, <strong>".$_SESSION['user']['user_name']."</strong>. ";

if (isAdmin()) {
echo "Вы вошли как Администратор.";echo '<br><br>';
}


if (!file_exists(__DIR__ . "/tests")) {
    mkdir(__DIR__ . "/tests");
}
$testDir = __DIR__."/tests";
$message = '';

if (isset($_FILES['send_files'])) {
    $file = $_FILES['send_files'];
}

if (isset($file['name']) && !empty($file['name'])) 
{
    if ($file['error'] == UPLOAD_ERR_OK)
    {
        move_uploaded_file($file['tmp_name'], $testDir.DIRECTORY_SEPARATOR.$file['name']);

      	$info = new SplFileInfo($file['name']);
        $fileType = $info->getExtension();
        $contents = file_get_contents($testDir.DIRECTORY_SEPARATOR.$file['name']);
        $tests = json_decode($contents, true);
        
        if ($fileType != "json") {
            echo "Ошибка загрузки файла. Необходимо загрузить только файлы с расширением json. <br> <a href='admin.php'> Назад </a> ";
            unlink($testDir.DIRECTORY_SEPARATOR.$file['name']);
            exit();
        }
        elseif ($tests == null) {
            echo "Неверная структура json <br> <a href='admin.php'> Назад </a>";
            unlink($testDir.DIRECTORY_SEPARATOR.$file['name']);
            exit();
        }
        
            header("Location: list.php", true, 307); 
            $message = 'Файл успешно загружен';
    }
    else {
        $message = 'Файл не загружен: ';
        echo $message.$file['error'];
    }
}
?>

<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8">
  <title>Lesson 8</title>
</head>
<style>
  div
  { display: inline-block;
  	width: 50%;
  	}
legend { font-weight: 600;}
</style>
<body>
<div>
<form enctype="multipart/form-data" method="post" action="">
	<fieldset>
		<legend>Загрузка файлов</legend>
			<p>Загрузите файлы с тестами в формаете JSON</p>
			<input type="file" name="send_files" placeholder="Файл">
			<hr>
        <?php  
            if (isAdmin()) { 
        ?>
			<input type="submit" name="btn" value="Отправить файлы на сервер">
        <?php
            }
        ?>
			<p style="color: green;"><?php echo $message; ?></p>
	</fieldset>
	<fieldset>
        <legend>Список загруженных файлов</legend>
        <p>Json-файлы с тестами, загруженные на сервер:</p>
        <ul>
            	<?php 
            		$filesDir = scandir($testDir);
                    $numFiles=count(scandir($testDir))-2;
                    $filesDirs = array_slice($filesDir, 2);
            		foreach ($filesDirs as $fd) {
        					echo '<li>'.$fd.'</li>';
                    }
        				
        		?>
        </ul>
        <hr>
        <p>Можно перейти к выбору теста.</p>
        <div>
          <input type="submit" formaction="list.php" name="ShowTestsList" value="К тестам =>" title="Перейти к выполнению тестов">
        </div>
      </fieldset>

</form>
</div>
<br>
<a href="logout.php" >Выйти</a>
</body>
