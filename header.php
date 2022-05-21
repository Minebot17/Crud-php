<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
    </head>
	<body>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Книжный магазин</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link <?php echo($entity_index == 0 ? "active" : ""); ?>" href="/lab1_s/index.php?ei=0">Авторы</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo($entity_index == 1 ? "active" : ""); ?>" href="/lab1_s/index.php?ei=1">Книги</a>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav me-auto mb-2 mb-md-0 header-right">
                    <?php
                    if (array_key_exists('is_auth', $_SESSION) && $_SESSION['is_auth']){
                        echo '
                            <li class="nav-item">
                                <a class="nav-link" href="/lab1_s/login.php?logout=true">'.$_SESSION['login'].'</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/lab1_s/login.php?logout=true">Выход</a>
                            </li>
                        ';
                    }
                    else {
                        echo '
                            <li class="nav-item">
                                <a class="nav-link" href="/lab1_s/register.php">Регистрация</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/lab1_s/login.php">Вход</a>
                            </li>
                        ';
                    }
                    ?>

                </ul>
            </div>
        </nav>
        <div class="container">