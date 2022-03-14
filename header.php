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
    </div>
</nav>