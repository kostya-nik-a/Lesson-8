<?php

require_once 'function.php';

if(!isAuthorized()) {
    http_response_code(403);
    die();
}

if (isAuthorized()) {
    foreach (getUsers() as $user) {
        if (($_SESSION['user'] == $user['login'] && $_SESSION['user'] == $user['password']) || ($_SESSION['user'] == 'guest' && $_SESSION['user'] == 'guest')) {
            $_SESSION['user'] = $user;
        }
        $errors[] = 'Неверный логин или пароль';
    }

    $userName = $_SESSION['user']['user_name'];

}
    if (empty($_POST['user_rating'])) {
        http_response_code(400);
        echo "Вы не прошли тест!";
        exit();
    } 
    else 
        {
            $rating = $_POST['user_rating'];
        }

$image = imagecreatetruecolor(965, 685);
$backcolor = imagecolorallocate($image, 255, 255, 555);
$textcolor = imagecolorallocate($image, 50, 50, 50);

$boxFile = __DIR__ . '/sertificate.jpg';
if (!file_exists($boxFile)) {
    echo "Файл с картинкой не найден";
    exit();
}

$imBox = imagecreatefromjpeg($boxFile);
imagefill($image, 0, 0, $backcolor);
imagecopy($image, $imBox, 0, 0, 0, 0, 965, 685);

$fontFile = __DIR__ . '/timesbi.ttf';
if (!file_exists($fontFile)) {
    echo "Файл со шрифтом не найден";
    exit();
}

foreach (getUsers() as $user) {
    # code...
}
imagettftext($image, 25, 0, 390, 340, $textcolor, $fontFile, $userName);  
imagettftext($image, 14, 0, 450, 395, $textcolor, $fontFile, $rating);
header('Content-type: image/jpeg');
imagejpeg($image); 

?>