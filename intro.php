<?php

include_once "../root.php";
include_once root . "/services/DomaineServices.php";
include_once root . "/services/FormationServices.php";
include_once root . "/services/UserServices.php";
include_once root . "/services/NoterServices.php";


session_start();


$OS = new FormationServices();
$NS = new NoterServices();


if(isset($_SESSION['user']))
    header('location:./index.php');
else {

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <title>AppendSkills</title>
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/main.css"/>
    </head>

    <body>
    <?php include_once './inc/nav.php'; ?>
    <main>
        <div class="w-100  ">
            <!--<img src="img/2.jpg" style="width:100%;height:500px;object-fit:cover">-->
            <div class="bd-example" style="top:56px;">
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                        <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <?php

                        $r = true;
                        foreach (json_decode($OS->Read()) as $f) {
                            ?>

                            <div class="carousel-item  <?php if ($r) echo 'active'; ?>">
                                <a href="course.php?id=<?php echo $f->id; ?>">
                                    <div class="bshadow"></div>
                                    <img src="img/<?php echo $f->photo; ?>" class="d-block w-100"
                                         style="height:500px;object-fit:cover;box-shadow:inset 0px 0px 20px 10px rgba(0,0,0,0.6)"
                                         alt="...">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h1><?php echo $f->nom; ?></h1>
                                        <p><?php echo $f->description; ?></p>
                                    </div>

                                </a>

                            </div>

                            <?php
                            $r = false;
                        }

                        ?>

                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div id="body" class="container-fluid p-5">

                <div class="container w-100 my-3">
                    <div class="row">
                        <div class="search w-100 pl-2 pr-2">
                            <form class="form-inline my-2 my-lg-0 d-lg-none d-xl-none" style="justify-content: center;">
                                <input class="form-control mr-sm-2" type="search"
                                       placeholder="Que souhaitez-vous apprendre?" aria-label="Search"/>
                                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">
                                    Search
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="row w-100">
                        <div class="w-100">
                            <h3>Les cours les plus populaires</h3>
                            <hr>
                            <div class="container items-container position-relative">
                                <span class="il"></span>
                                <span class="ir"></span>
                                <div class="d-flex w-100 contents mb-2" style="overflow: hidden">

                                    <?php
                                    $r = true;
                                    foreach (json_decode($OS->Read()) as $f) {
                                        ?>

                                        <div class="col-lg-3 col-xl-2 col-md-4 col-sm-6 col-6 card style-card-1 item"
                                             style="width: 18rem;">
                                            <a><img src="img/<?php echo $f->photo; ?>" class="card-img-top"
                                                    alt="..."></a>
                                            <div class="card-body position-relative">
                                                <a href="course.php?id=<?php echo $f->id; ?>">
                                                    <p class="card-text font-weight-bold"><?php echo $f->nom; ?></p>
                                                </a>
                                                <p class="text-muted mb-30px"><?php echo $f->userfirstname . ' '. $f->userlastname; ?></p>
                                                <span class="card-price"><?php echo $f->prix; ?> <i class="fas fa-dollar-sign"></i></span>
                                                <?php
                                                if ($NS->FindTotalNoteByFormation($f->id) != '')
                                                {
                                                    $rate =  explode('.',$NS->FindTotalNoteByFormation($f->id));
                                                    $r= $rate[0];
                                                    if ($rate[1][0] != '0')
                                                        $r.= '.'.$rate[1][0];
                                                    echo '<span class="card-rate">'.$r.'<i class="fas fa-star"></i></span>';
                                                }
                                                ?>

                                            </div>
                                        </div>

                                        <?php
                                        $r = false;
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row w-100">
                        <div class="w-100">
                            <h3>Les nouveaux cours en fonction de votre intérêt</h3>
                            <hr>
                            <div class="container items-container position-relative">
                                <span class="il"></span>
                                <span class="ir"></span>
                                <div class="d-flex w-100 contents mb-2" style="overflow: hidden">

                                    <?php
                                    $r = true;
                                    foreach (json_decode($OS->Read()) as $f) {
                                        ?>

                                        <div class="col-lg-3 col-xl-2 col-md-4 col-sm-6 col-6 card style-card-1 item"
                                             style="width: 18rem;">
                                            <a><img src="img/<?php echo $f->photo; ?>" class="card-img-top"
                                                    alt="..."></a>
                                            <div class="card-body position-relative">
                                                <a href="course.php?id=<?php echo $f->id; ?>">
                                                    <p class="card-text font-weight-bold"><?php echo $f->nom; ?></p>
                                                </a>
                                                <p class="text-muted mb-30px"><?php echo $f->userfirstname . ' '. $f->userlastname; ?></p>
                                                <span class="card-price"><?php echo $f->prix; ?> <i class="fas fa-dollar-sign"></i></span>
                                                <?php
                                                if ($NS->FindTotalNoteByFormation($f->id) != '')
                                                {
                                                    $rate =  explode('.',$NS->FindTotalNoteByFormation($f->id));
                                                    $r= $rate[0];
                                                    if ($rate[1][0] != '0')
                                                        $r.= '.'.$rate[1][0];
                                                    echo '<span class="card-rate">'.$r.'<i class="fas fa-star"></i></span>';
                                                }
                                                ?>

                                            </div>
                                        </div>

                                        <?php
                                        $r = false;
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row w-100">
                        <div class="w-100">
                            <h3>Most pupolar courses</h3>
                            <hr>
                            <div class="container items-container position-relative">
                                <span class="il"></span>
                                <span class="ir"></span>
                                <div class="d-flex w-100 contents mb-2" style="overflow: hidden">

                                    <?php
                                    $r = true;
                                    foreach (json_decode($OS->Read()) as $f) {
                                        ?>

                                        <div class="col-lg-3 col-xl-2 col-md-4 col-sm-6 col-6 card style-card-1 item"
                                             style="width: 18rem;">
                                            <a><img src="img/<?php echo $f->photo; ?>" class="card-img-top"
                                                    alt="..."></a>
                                            <div class="card-body position-relative">
                                                <a href="course.php?id=<?php echo $f->id; ?>">
                                                    <p class="card-text font-weight-bold"><?php echo $f->nom; ?></p>
                                                </a>
                                                <p class="text-muted mb-30px"><?php echo $f->userfirstname . ' '. $f->userlastname; ?></p>
                                                <span class="card-price"><?php echo $f->prix; ?> <i class="fas fa-dollar-sign"></i></span>
                                                <?php
                                                if ($NS->FindTotalNoteByFormation($f->id) != '')
                                                {
                                                    $rate =  explode('.',$NS->FindTotalNoteByFormation($f->id));
                                                    $r= $rate[0];
                                                    if ($rate[1][0] != '0')
                                                        $r.= '.'.$rate[1][0];
                                                    echo '<span class="card-rate">'.$r.'<i class="fas fa-star"></i></span>';
                                                }
                                                ?>

                                            </div>
                                        </div>

                                        <?php
                                        $r = false;
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?include_once 'inc/footer.php'; ?>
    <script src="js/jquery-3.3.1.min.js "></script>
    <script src="js/bootstrap.min.js "></script>
    <script src="js/popper.min.js "></script>
    <script src="js/main.js "></script>
    </body>

    </html>

    <?php
}

    ?>