<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <a class="navbar-brand" href="/">Краудсорсинг здоровья</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php if($home_pg) echo 'active'; $home_pg = false;?>">
                <a class="nav-link" href="/">Главная страница <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item <?php if($usr_pg) echo 'active'; $usr_pg = false; ?>">
                <a class="nav-link" href="/includes/auth.php" tabindex="-1" aria-disabled="true">Ваша страница</a>
            </li>
        </ul>
        <form class="form-inline mr-sm-2" action="/includes/divarication.php" method="POST">
            <input class="form-control mr-sm-2" name="victim-adres" type="text" placeholder="Ваш адрес" aria-label="Ваш адрес">
            <button class="btn btn-danger my-2 my-sm-0" type="submit">Вызов скорой помощи</button>
        </form>
        <form class="form-inline" action="/includes/divarication.php" method="GET">
            <input class="form-control mr-sm-2" name="search" type="search" placeholder="Поиск" aria-label="Поиск">
            <button class="btn btn-success my-2 my-sm-0" type="submit">Поиск</button>
        </form>
    </div>
</nav>