<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <a class="navbar-brand" href="/">Краудсорсинг здоровья</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php if($page_home) echo 'active'; $page_home = false;?>">
                <a class="nav-link" href="/">Главная страница <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item <?php if($page_auth) echo 'active'; $page_auth = false; ?>">
                <a class="nav-link" href="/includes/auth.php" tabindex="-1" aria-disabled="true">Ваша страница</a>
            </li>
        </ul>
    </div>
</nav>