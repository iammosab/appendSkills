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

            <div id="body" class="container-fluid p-5">

                <div class="container w-100 my-3">
                    <div class="row">
                        <h1 class="col-12"><?php echo $formation->nom;?></h1>
                        <div class="col-lg-8">
                            <div class="card default-card">
                                <?php

                                if (isset($_GET['v'])){
                                    $r = true;
                                    if (is_numeric($_GET['v']))
                                    {
                                        $v = $VS->FindById($_GET['v']);
                                        $v = json_decode($v);
                                        if ($v != null)
                                            $r = false;
                                    }
                                    if ($r) {
                                        $s = json_decode($SS->findByFormation($_GET['id']));
                                        $v = json_decode($VS->FindBySection($s[0]->id));
                                        $v = $v[0];
                                    }
                                }
                                ?>
                                <div class="card-header"><i class="far fa-play-circle" style="font-size:14px;"></i>
                                    <?php echo $v->titre; ?>
                                </div>
                                <div class="card-body p-0">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <video width="320" height="240" controls>
                                            <source src="videos/<?php echo $v->chemin;  ?>" type="video/mp4">
                                        </video>
                                    </div>
                                </div>
                                <div class="card-footer text-muted">
                                    <?php echo $v->description;?>
                                </div>
                            </div>
                            <div class="card default-card">
                                <div class="card-header">
                                    Formateur
                                </div>
                                <div class="card-body row">
                                    <div class="col-lg-3  col-sm-2 col-xl-2 col-md-2 " style="align-self: center;">
                                        <img src="img/<?php echo $user->photo;?>" class="img-fluid" style="object-fit:cover;border-radius: 50%;" alt="">
                                    </div>
                                    <div class="col-lg-9 col-xl-10 col-sm-10 col-md-10 p-2 container-fluid">
                                        <div class="row">
                                            <h5 class="col-12"><?php echo $user->nom.' '.$user->prenom;?></h5>
                                            <p class="col-4">
                                                <?php
                                                if ($NS->FindTotalNoteByUser($formation->user) != '')
                                                {
                                                    $rate =  explode('.',$NS->FindTotalNoteByUser($formation->user));
                                                    $r= $rate[0];
                                                    if (isset($rate[1][0]) && $rate[1][0] != '0')
                                                        $r.= '.'.$rate[1][0];
                                                    echo '<span class="font-weight-bold"><i class="fas fa-star"></i></span> '.$r;
                                                }
                                                ?>
                                            </p>
                                            <p class="col-4"><span class="font-weight-bold"><i class="fas fa-users"></i></span> <?php echo $nbrUsersForBuyer;?></p>
                                            <p class="col-4"><span class="font-weight-bold"><i class="far fa-play-circle" ></i></span> <?php echo $nbrFormations;?> Cours</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card default-card">
                                <div class="card-header">
                                    Les commentaires
                                </div>
                                <div class="card-body">
                                    <div id="video_comments" class="col-12 p-3" style="max-height:500px;overflow-y: auto">

                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="media position-relative">
                                        <img src="img/<?php echo $_SESSION['user']->photo; ?>" style="width:60px; height:60px;object-fit:cover" class="mr-3 rounded-circle" alt="...">
                                        <div class="media-body align-self-center">
                                            <div class="input-group">
                                                <input type="text" style="border-radius: 20px 0px 0px 20px;" class="form-control no-focus-border-effect" id="commenter" placeholder="Tappez votre commentaire">
                                                <div class="input-group-append">
                                                    <span style="border-radius: 0px 20px 20px 0px;" class="input-group-text cursor-grabbing" title="Ajouter ce commentaire" id="ajouter"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
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
                                                <?php echo $section->nom; ?> (<?php echo count(json_decode($VS->FindBySection($section->id))); ?>)
                                            </button>
                                            <div>
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
                                                                    <a <?php  if ($video->id != $v->id) { ?>href="./course-content.php?id=<?php echo $formation->id.'&v='.$video->id; ?>" <?php } ?>><?php echo $video->titre; ?></a>
                                                                </div>
                                                                <div>
                                                                    <span class="badge badge-dark ml-3 time"><?php echo $file['playtime_string']; ?></span>
                                                                </div>
                                                            </div>
                                                        </li>

                                                    <?php } ?>

                                                </ul>
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
                    </div>
                </div>

            </div>
    </main>

    <?php include_once './inc/footer.php'; ?>
    <script src="js/jquery-3.3.1.min.js "></script>
    <script src="js/popper.min.js "></script>
    <script src="js/bootstrap.min.js "></script>
    <script src="js/main.js "></script>
    <script>
        <?php if (isset($v)) echo 'var _video='.$v->id.';'; ?>
        <?php if (isset($_SESSION['user'])) echo 'var _user='.$_SESSION['user']->id.';'; ?>

        <?php if(count($times) != 0){
            $t=0;
            for ($i = 0;$i<count($times);$i++){
                echo '$(".totaltime").eq('.$i.').text(" +'.$times[$i].'min");';
                $t+=$times[$i];
            }
            echo '$(".totaltimes").text(" +'.$t.'min");';
        }

        ?>
        var add_data = function(data){
            text ="";
            for (let i = 0; i <data.length ; i++) {

                var p = $('<p><p>').text(data[i].commentaire);
                var nom = data[i].nom+' '+data[i].prenom;
                var hr = '<hr>';
                var supprimer = "";
                if(i== data.length-1)
                    hr="";
                <?php if (isset($_SESSION['user'])){ ?>
                if(data[i].user == _user)
                {
                    supprimer = '<i id="'+data[i].id+'" class="fa fa-trash text-primary delete cursor-grabbing float-right" title="Supprimer ce commentaire"></i>';
                    nom = "Moi";
                    r=false;
                }
                <?php } ?>
                text+='<div class="media position-relative">';
                text+='<img src="img/'+data[i].photo+'" style="width:80px; height:80px;object-fit:cover" class="mr-3 rounded-circle" alt="...">';
                text+='<div class="media-body"><span class="float-right text-muted"></span><h5 class="mt-0">'+nom+'</h5>';
                text+='<p>'+p.eq(0).html()+'</p>'+supprimer+'</div></div>'+hr;
            }
            if (text == "")
                text = '<p class="text-center w-100">Aucun commentaire pour l\'instant.</p>';
            $('#video_comments').html(text);

            $('.delete').click(function () {
                $.ajax({
                    url: '../controllers/CommentaireController.php',
                    async: false,
                    method: 'POST',
                    data:{op:'findbyvideo',idcmt:$(this).prop('id'),and:'delete',ID:_video},
                    success: function (data, textStatus, jqXHR) {
                        add_data(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Connection error '+textStatus);
                    }
                });
            });
            $('#ajouter').click(function () {
                if ($('#commenter').val() != ""){
                    $.ajax({
                        url: '../controllers/CommentaireController.php',
                        async: false,
                        method: 'POST',
                        data:{op:'findbyvideo',ID:_video,and:'add',commentaire:$('#commenter').val()},
                        success: function (data, textStatus, jqXHR) {
                            add_data(data);
                            $('#commenter').val('');
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
            url: '../controllers/CommentaireController.php',
            async: false,
            method: 'POST',
            data:{op:'findbyvideo',ID:_video},
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