<?php
if (session_status() != PHP_SESSION_ACTIVE)
    session_start();
if (isset($_SESSION['user'])){
    include_once "../root.php";
    include_once root."/services/UserServices.php";
    $US = new UserServices();
    $_SESSION['user'] = $US->FindByEmail($_SESSION['user']->email);

}

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="./index.php">AppendSkills</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-5">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Catégories
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php include_once 'inc/domaines.php'; ?>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0 mr-auto d-none d-lg-block d-xl-block">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" />
            <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">
                Search
            </button>
        </form>
        <?php if (!isset($_SESSION['user'])){ ?>
            <div>
                <ul class="navbar-nav mr-lg-3 ml-lg-3">
                    <li class="nav-item">
                        <a href="login.php" class="nav-link">
                            <span>Se connecter</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="signin.php" class="nav-link">
                            <span>S'inscrire</span>
                        </a>
                    </li>
                </ul>
            </div>
        <?php }else{ ?>
            <div>
                <ul class="navbar-nav mr-lg-3 ml-lg-3">

                    <li class="nav-item dropdown">
                        <div class="d-none d-lg-block" style="border-left: 1px solid rgba(255,255,255,.5);height:100%;position:absolute;"></div>
                        <a class="nav-link dropdown-toggle " href="#" id="accountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <img src="img/<?php if (isset($_SESSION['user'])) echo $_SESSION['user']->photo; ?>" class="img-fluid rounded-circle ml-2" style="width:45px;height:45px;object-fit:cover">
                            <span class="font-weight-bolder ml-2"><?php if (isset($_SESSION['user'])) echo $_SESSION['user']->nom.' '.$_SESSION['user']->prenom; ?></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="accountDropdown">
                            <a class="dropdown-item" href="#">Profile</a>
                            <a class="dropdown-item" href="#">Paramètres</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="./logout.php">Se Déconnecter</a>
                        </div>
                    </li>
                </ul>
            </div>
        <?php }?>
    </div>

</nav>
