<?php

require_once 'function.php';

if(!isAuthorized()) {
    http_response_code(403);
    die();
}

print_r($_SESSION['user']);

$testDir = __DIR__."./tests";
$tests_list = scandir($testDir);
$numFiles=count(scandir($testDir))-1;
//echo "<pre>";
//print_r($tests_list);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Выбор теста</title>
</head>
<body>
  <div>
    <p>Доступные для прохождения тесты:</p>
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
  </div>
</body>
</html>