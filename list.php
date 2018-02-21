<?php

require_once 'function.php';

if(!isAuthorized()) {
    http_response_code(403);
    die();
}

$testDir = __DIR__."./tests";
$tests_list = scandir($testDir);
$numFiles=count(scandir($testDir))-1;
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Выбор теста</title>
</head>
<body>
  <div>
    <p><strong><?php echo $_SESSION['user']['user_name']?></strong>, Вам доступны для прохождения следующие тесты:</p>
    <?php 
      $i = 2;
      do {
        $contents = file_get_contents($testDir.DIRECTORY_SEPARATOR.$tests_list[$i]);
        $tests = json_decode($contents, true);
        echo '<strong>'.($i-1).'. '.$tests['title'].'</strong><br>';
      } while ($i++<$numFiles);
    ?>
    <form enctype="multipart/form-data" action="test.php" method="get"><hr> Введите номер теста:   
        <input type="text" name="test_number"><br/>                
        <button type="submit">Пройти тест</button>    
    </form>

    <?  if (isAdmin()) { ?>
      <a href="admin.php" >Добавить тест</a>
    <?php
          }
    ?>
  </div>
</body>
</html>
