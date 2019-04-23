<?php
$DS = new DomaineServices();

$domaines = json_decode($DS->Read());
foreach ($domaines as $d) {
    echo '<a class="dropdown-item" href="./intro.php?q='.$d->id.'">'.$d->nom.'</a>';
}

?>