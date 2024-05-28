<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/CSS/CustomStyles.css">
    <title>MarketHome</title>
</head>
<body>
<div class="container text-center justify-content-center">
    <nav class="navbar fixed-top navbar-expand">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 text-white">
                 <img src="/img/240_F_527599859_al1Qz9ir73LHzo7Zdd6LLcJgaChsTyHO.png" alt="" width="40" height="40"
                      class="d-inline-block mx-3 ">
                 MarketHome
            </span>
            <ul class="nav nav-underline">
                <li class="nav-item">
                    <a class="nav-link <?= $_SESSION['current'] == 'home' ? 'active' : '' ?> px-2 text-white"
                       aria-current="page" href="../../home/home">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $_SESSION['current'] == 'login' ? 'active' : '' ?> px-2 text-white"
                       href="../../auth/login">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $_SESSION['current'] == 'register' ? 'active' : '' ?> px-2 text-white"
                       href="../../auth/register">Créer un compte</a>
                </li>
            </ul>
        </div>
    </nav>
