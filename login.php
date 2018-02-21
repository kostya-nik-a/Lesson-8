<?php

require_once 'function.php';

if (isAuthorized() && isAdmin()) {
    redirect('admin');
}

$errors = [];

if (!empty($_POST)) {
    foreach (getUsers() as $user) {
        if ($_POST['login'] == $user['login'] && $_POST['pass'] == $user['password']) {
            if ($_POST['login'] == 'guest' && $_POST['pass'] == 'guest') {
                if (empty($_POST['user_name'])) {
                    echo 'Введите имя';
                    die();
                }
                    $_SESSION['user'] = $user;
                    $_SESSION['user']['user_name'] = $_POST['user_name'] ;
                    redirect('list');
        }
            $_SESSION['user'] = $user;
            redirect('admin');
        } 
    }
    $errors[] = 'Неверный логин или пароль';
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Lesson 8 Authorization</title>
    </head>
    <body>
        <?php foreach ($errors as $error) {
            $error;
        }

        ?>
        <form method="POST">
            <div style="width: 50%; text-align: left;">
                <fieldset>
                    <legend>
                        <h3>Для доступа к загрузке тестов введите логи и пароль</h3>
                    </legend>
                    <label>  
                    Login: <input type="text" name="login" value=""><br>
                    Password: <input type="password" name="pass" value="">
                    </label>
                </fieldset>
                <button type="submit">Войти</button> 
            </div>
        </form>
        <form method="POST">
            <div style="width: 50%; text-align: left;">
                <fieldset>
                    <legend>
                        <h3>Или войдите как Гость</h3>
                    </legend> 
                    Введите Ваше имя: <input type="text" name="user_name" value="">
                    <input type="hidden" name="login" value="guest">
                    <input type="hidden" name="pass" value="guest">
                    <button type="submit">Войти как гость</button>
                </fieldset>   
            </div>
        </form>
    </body>
</html>
