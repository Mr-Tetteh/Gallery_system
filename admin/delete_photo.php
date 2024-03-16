<?php  include "includes/init.php"  ?>

<?php

if (empty($_GET['id'])){
    redirect("photos.php");
}

$photo = Photo::find_by_id($_GET['id']);
if ($photo){
    $photo->delet_phtot();
}else{
    redirect('photos.php');
}
?>
