<?php

include_once "../root.php";
include_once root . "/services/DomaineServices.php";
include_once root . "/services/FormationServices.php";
include_once root . "/services/UserServices.php";
include_once root . "/services/AcheterServices.php";
include_once root . "/services/SectionServices.php";
include_once root . "/services/VideoServices.php";
include_once root . "/services/NoterServices.php";
include_once root . "/vendor/getid3/getid3.php";


session_start();


$OS = new FormationServices();
$US = new UserServices();
$AS = new AcheterServices();
$SS = new SectionServices();
$VS = new VideoServices();
$NS = new NoterServices();
if(!isset($_GET['id']))
header('location:./index.php');
else {

    $formation = json_decode($OS->FindById($_GET['id']));

    if($formation=="")
        header('location:./index.php');
    else
    {

        $user = json_decode($US->FindById($formation->user));
        $nbrUsers = count(json_decode($AS->FindByFormation($_GET['id'])));
        $nbrFormations = count(json_decode($OS->FindByUser($formation->user)));
        $nbrUsersForBuyer = count(json_decode($AS->FindSellersByBuyer($formation->user)));



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>AS | <?php echo $formation->nom;?></title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/main.css" />
</head>

<body>
<?php include_once './inc/nav.php'; ?>

    <main>
        <div class="w-100  ">
            <div class="container-fluid bg-dark p-0 text-light">
            </div>
            <div id="body" class="container-fluid p-5">
                <div class="container w-100 my-3">
                    <div class="row">
                        <!--<span class="col-12">12/02/2019</span>-->
                        <h1 class="col-12"><?php echo $formation->nom;?></h1>
                    </div>
                    <div class="row mb-5">
                        <div class="container-fluid py-0 col-lg-6 col-md-12">
                            <?php if (count(json_decode($SS->findByFormation($_GET['id']))) > 0){ ?>
                            <div class="row container-fluid p-2">
                                <!--<p class="col-12"></p>
                                    <p class="col-3"><span class="font-weight-bold"><i class="fas fa-language"></i></span> Français</p>-->
                                <p class="col-4"><span class="font-weight-bold"><i class="fas fa-users"></i></span> <?php echo $nbrUsers; ?></p>
                                <p class="col-4"><span class="font-weight-bold"><i class="fas fa-star"></i></span>
                                    <?php
                                    if ($NS->FindTotalNoteByFormation($_GET['id']) != '')
                                    {
                                        $rate =  explode('.',$NS->FindTotalNoteByFormation($_GET['id']));
                                        echo $rate[0];
                                        if ($rate[1][0] != '0')
                                            echo '.'.$rate[1][0];
                                    }

                                ?></p>
                                <p class="col-4"><span class="font-weight-bold"><i class="fas fa-hourglass-half"></i></span><span class="totaltimes"></span></p>

                            </div>
                            <?php }else
                                echo '<div class="row container-fluid p-4"></div>';?>
                            <div class="row d-md-block d-sm-block d-lg-none d-xl-none  pt-2">
                                <div class="card style-card-1" style="">
                                    <div class="card-img-top embed-responsive embed-responsive-16by9" style="border-radius: 10px;">
                                        <video class="introvideo" width="320" height="240" poster="img/<?php echo $formation->photo;?>" controls></video>
                                    </div>
                                    <div class="card-body text-center border-0 container-fluid">
                                        <div class="row">
                                            <div class="col-4">
                                                <button class="btn text-dark" disabled><?php echo $formation->prix;?> <i class="fas fa-dollar-sign"></i></button>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                                <button class="btn btn-outline-danger">Favoriser</button>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                                <button class="btn btn-outline-success">Acheter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h5 class="col-12">Description</h5>
                                <div class="p-2 pl-4" >
                                    <p><?php echo $formation->description;?></p>
                                </div>
                            </div>
                            <div class="row">
                                <h5 class="col-12">À propos du formateur</h5>
                            </div>
                            <div class="row text-muted">
                                <div class="col-lg-3 col-sm-2 col-xl-2 col-md-2 " style="align-self: center;">
                                    <img src="img/<?php echo $user->photo;?>" class="img-fluid" style="object-fit:cover;border-radius: 50%;" alt="">
                                </div>
                                <div class="col-lg-9 col-xl-10 col-sm-10 col-md-10 p-2 container-fluid">
                                    <div class="row">
                                        <h5 class="col-12"><?php echo $user->nom.' '.$user->prenom;?></h5>
                                        <h6 class="col-12"><?php echo $user->about;?></h6>
                                        <p class="col-4">
                                            <?php
                                            if ($NS->FindTotalNoteByUser($formation->user) != '')
                                            {
                                                $rate =  explode('.',$NS->FindTotalNoteByUser($formation->user));
                                                $r= $rate[0];
                                                if (isset($rate[1][0]) && $rate[1][0] != '0')
                                                    $r.= '.'.$rate[1][0];
                                                echo '<span class="font-weight-bold"><i class="fas fa-star"></i> '.$r.'</span>';
                                            }
                                            ?>
                                        </p>
                                        <p class="col-4"><span class="font-weight-bold"><i class="fas fa-users"></i></span> <?php echo $nbrUsersForBuyer;?></p>
                                        <p class="col-4"><span class="font-weight-bold"><i class="far fa-play-circle" ></i></span> <?php echo $nbrFormations;?> Cours</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 d-md-none d-sm-none d-lg-block d-none d-xl-block pt-2">
                            <div class="card style-card-1" style="">
                                <div class="card-img-top embed-responsive embed-responsive-16by9" style="border-radius: 10px;">
                                    <video class="introvideo" width="320" height="240" poster="img/<?php echo $formation->photo;?>" controls></video>
                                </div>
                                <div class="card-body text-center border-0 container-fluid">
                                    <div class="row">
                                        <div class="col-4">
                                            <button class="btn text-dark" disabled><?php echo $formation->prix;?> <i class="fas fa-dollar-sign"></i></button>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-outline-danger">Favoriser</button>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-outline-success">Acheter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row w-100 position-relative contents mb-2">
                        <h5 class="col-12 p-0">Des cours similaires</h5>
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
                                                <?php if (count(json_decode($SS->findByFormation($_GET['id']))) > 0){
                                                    ?>

                    <div class="row mb-2">
                        <h5 class="col-12 p-0">Contenu du cours</h5>
                        <div class="col-12">
                            <div class="accordion" id="accordionExample">
                                <?php
                                $times = array();
                                $totaltime =0;
                                $r = true;
                                $collapse = true;
                                foreach (json_decode($SS->findByFormation($_GET['id'])) as $section)
                                {

                                    ?>

                                    <div class="card">
                                        <div class="card-header p-2 pr-4 d-flex justify-content-between align-items-center" id="heading<?php echo $section->id; ?>">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $section->id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $section->id; ?>">
                                                <?php echo $section->nom; ?>
                                            </button>
                                            <div>
                                                <span><?php echo count(json_decode($VS->FindBySection($section->id))); ?> sessions</span>
                                                <span class="badge badge-primary ml-3 totaltime"></span>
                                            </div>

                                        </div>

                                        <div id="collapse<?php echo $section->id; ?>" class="collapse <?php if ($collapse) {echo 'show'; $collapse=false;} ?>" aria-labelledby="heading<?php echo $section->id; ?>" data-parent="#accordionExample">
                                            <div class="card-body border-left-0 border-right-0 rounded-0">
                                                <ul class="list-group list-group-flush">
                                                    <?php
                                                    foreach (json_decode($VS->FindBySection($section->id)) as $video)
                                                    {
                                                        $getID3 = new getID3();
                                                        $file = $getID3->analyze("videos/".$video->chemin);
                                                        $totaltime += strtotime("00:".$file['playtime_string']);
                                                    ?>

                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div title="">
                                                                <i class="far fa-play-circle" style="font-size:14px;"></i>
                                                                <a data-toggle="collapse" href="#section-<?php echo $video->id; ?>" role="button" aria-expanded="false" aria-controls="section-<?php echo $video->id; ?>"><?php echo $video->titre; ?></a>
                                                            </div>
                                                            <div>
                                                                <?php if($video->gratuit == 1) {
                                                                    if($r){
                                                                        $v = $video->chemin;
                                                                        $r=false;
                                                                    }

                                                                    ?>
                                                                <span class="text-primary cursor-grabbing" onclick="showVideo('<?php echo $video->titre; ?>','<?php echo $video->chemin; ?>')">Apreçu</span>
                                                                <?php } ?>
                                                                <span class="badge badge-dark ml-3 time"><?php echo $file['playtime_string']; ?></span>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-11 pl-5">
                                                                    <div class="collapse multi-collapse" id="section-<?php echo $video->id; ?>">
                                                                        <?php echo $video->description; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <?php } ?>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                array_push($times,($totaltime/60)%60);
                                $totaltime = 0;
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-2">
                        <h5 class="col-12 p-0">Commentaires</h5>
                        <div class="col-12">
                            <div id="course_comments" class="p-3 border rounded-top" style="max-height:500px;overflow-y: auto"></div>
                            <div id="add_cmt"></div>
                        </div>
                    </div>
                    <?php } else
                            echo '<div class="row mb-2 border rounded p-5"><h3 class="w-100 text-center"> Aucun cours pour l\'instant</h3>';
                        ?>
            </div>

        </div>
    </main>
    <?include_once 'inc/footer.php'; ?>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-1 modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                </div>
                <div class="modal-body p-0">
                    <div class="embed-responsive embed-responsive-16by9">
                        <video id="modalvideo" width="320" height="240" controls></video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        <?php if (isset($_GET['id'])) echo 'var _formation='.$_GET['id'].';'; ?>
        <?php if (isset($_SESSION['user'])) echo 'var _user='.$_SESSION['user']->id.';'; ?>
        <?php if($v != null) echo '$(".introvideo").prop("src","videos/'.$v.'");';?>
        <?php if(count($times) != 0){
            $t=0;
            for ($i = 0;$i<count($times);$i++){
                echo '$(".totaltime").eq('.$i.').text(" +'.$times[$i].'min");';
                $t+=$times[$i];
            }
            echo '$(".totaltimes").text(" +'.$t.'min");';
        }

        ?>
        showVideo = function(title,link){
            $('#exampleModalCenter').on('show.bs.modal', function(e) {
                $('body').addClass('pr-0');
                $('#exampleModalCenterTitle').text(title);
                $('#modalvideo').prop('src',"videos/"+link);
                $('#modalvideo')[0].play();
            });
            $('#exampleModalCenter').modal('show');
        }
        var intToStars = function(i){
            t='';
            for (let j = 0; j <i ; j++) {
                t+='<i class="fas fa-star text-gold"></i>';
            }
            return t;
        }
        var add_data = function (data) {
            var text = "";
            var addcmt = "";
            var r=true;
            for (let i = 0; i <data.length ; i++) {
                var p = $('<p></p>').text(data[i].commentaire);
                var nom = data[i].nom+' '+data[i].prenom;
                var hr = '<hr>';
                var supprimer = "";
                if(i== data.length-1)
                    hr="";
                <?php if (isset($_SESSION['user'])){ ?>
                if(data[i].user == _user)
                {
                    supprimer = '<i id="delete" class="fa fa-trash text-primary cursor-grabbing float-right" title="Supprimer ce commentaire"></i>';
                    nom = "Moi";
                    r=false;
                }
                <?php } ?>
                text += '<div class="media position-relative"><img src="img/'+data[i].photo+'" style="width:80px; height:80px;object-fit:cover" class="mr-3 rounded-circle" alt="...">';
                text += '<div class="media-body"><span class="float-right text-muted">'+intToStars(data[i].note)+'</span><h5 class="mt-0">'+nom+'</h5><p style="border-left: 1px solid #b1b5b9;padding-left: 5px;">'+p.html()+'</p>'+supprimer+'</div></div>'+hr;
            }
        <?php if (isset($_SESSION['user'])){ ?>
            if(r)
            {
                addcmt+='<div class="col-12 p-0"><div class="card-header border border-top-0 rounded-bottom"><div class="media position-relative">';
                addcmt+='<img src="img/<?php echo $_SESSION['user']->photo; ?>" style="width:60px; height:60px;object-fit:cover" class="mr-3 rounded-circle" alt="..."><div class="media-body d-flex  align-self-center">';
                addcmt+='<select id="selectstars" style="padding: 5px;border-top-left-radius: 20px;border-bottom-left-radius: 20px;border-style: none;border: 1px solid #ced4da;outline: none;">';
                addcmt+='<option value="1">1 étoile</option><option value="2">2 étoiles</option><option value="3">3 étoiles</option><option value="4">4 étoiles</option><option value="5">5 étoiles</option></select>';
                addcmt+='<input type="text" class="form-control no-focus-border-effect rounded-0 border-left-0 border-right-0" id="commenter" placeholder="Tappez votre commentaire">';
                addcmt+='<button id="ajouter" style="border-top-right-radius: 20px;border-bottom-right-radius: 20px;border-style: none;border: 1px solid #ced4da;outline: none;">Ajouter</button></div></div></div></div>';
            }
            <?php } ?>
            if (text == "")
                text = '<p class="text-center w-100">Aucun commentaire pour l\'instant.</p>';
            $('#course_comments').html(text);
            $('#add_cmt').html(addcmt);

            $('#delete').click(function () {
                $.ajax({
                    url: '../controllers/NoterController.php',
                    async: false,
                    method: 'POST',
                    data:{op:'findbyformation',ID:_formation,and:'delete'},
                    success: function (data, textStatus, jqXHR) {
                        add_data(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Connection error '+textStatus);
                    }
                });
            });
            $('#ajouter').click(function () {
                if ($('#selectstars').prop('selectedIndex') >=0 && $('#commenter').val() != ""){
                    $.ajax({
                        url: '../controllers/NoterController.php',
                        async: false,
                        method: 'POST',
                        data:{op:'findbyformation',ID:_formation,and:'add',note:parseInt($('#selectstars').val()),commentaire:$('#commenter').val()},
                        success: function (data, textStatus, jqXHR) {
                            add_data(data);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert('Connection error '+textStatus);
                        }
                    });
                }else
                    alert("Vous devez remplir le champ");
            });
        }
        $.ajax({
            url: '../controllers/NoterController.php',
            async: false,
            method: 'POST',
            data:{op:'findbyformation',ID:_formation},
            success: function (data, textStatus, jqXHR) {
                add_data(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Connection error');
            }
        });



    </script>

</body>

</html>

    <?php
    }
}

?>