<form action="/lab1_s/<?php echo $is_register ? 'register.php' : 'login.php'; ?>" method="post">
    <h2><?php echo ($is_register ? 'Регистрация' : 'Вход') ?></h2><br>

    <?php $login_field_error = isset($validate_errors) && array_key_exists('login', $validate_errors); ?>
    <label for="login" class="form-label">Логин</label>
    <input type="text" class="form-control <?php echo ($login_field_error ? 'is-invalid' : '') ?>" name="login" id="login" value="">
    <?php echo $login_field_error ? '<div class="invalid-feedback">'.$validate_errors['login'].'</div>' : '' ?><br>

    <?php
    if ($is_register){
        $email_field_error = isset($validate_errors) && array_key_exists('email', $validate_errors);
        echo '
        <label for="email" class="form-label">Почта</label>
        <input type="email" class="form-control '.($email_field_error ? 'is-invalid' : '').'" name="email" id="email" value="">
        '.($email_field_error ? '<div class="invalid-feedback">'.$validate_errors['email'].'</div><br>' : '<br>');
    }
    ?>

    <?php $password_field_error = isset($validate_errors) && array_key_exists('password', $validate_errors); ?>
    <label for="password" class="form-label">Пароль</label>
    <input type="password" class="form-control <?php echo ($password_field_error ? 'is-invalid' : '') ?>" name="password" id="password" value="">
    <?php echo $password_field_error ? '<div class="invalid-feedback">'.$validate_errors['password'].'</div>' : '' ?><br>

    <button type="submit" class="btn btn-primary table-button" name="enter" id="enter"><?php echo ($is_register ? 'Зарегестрироваться' : 'Войти') ?></button>
    <?php
    if (isset($login_error)){
        echo '<div class="error-text">Неправильный логин или пароль</div>';
    }
    else if (isset($register_error)){
        echo '<div class="error-text">Такой логин или почта уже существует</div>';
    }
    ?>
</form>