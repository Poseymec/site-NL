<?php
require 'db.php';

if(!empty($_GET['id'])){
    $id=verification($_GET['id']);
}

if(!empty($_POST)){
    $id= verification($_POST['id']);

    $db=Database::Connection();
    $requet=$db->prepare("DELETE  FROM produits WHERE id=?");
    $requet->execute(array($id));
    $db=Database::deconnection();

    header("location: index.php");
}








/**fonction  */

//fonction qui verifie si les donnees sont justes

function verification($data){
    $data=htmlspecialchars($data);
    $data=trim($data);
    $data=stripslashes($data);

    return $data;
}


?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--lien vers boostrap-->

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
        <title>boutique-NL</title>
        <!--lien vers le css-->
        <link rel="stylesheet" href="../css/styles.css">
        <!--lien vers javascript-->
        <script src="js/script.js" type="module" defer> </script>
        <!--les icons-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    </head>
    <body>
        <div class="container site">
            <h1 class="titre">Ets NL busness </h1>
        </div>
        <div class="container admin">
            <div class="row">
               
                    <h1><strong>supprimer un produit</strong></h1> <br>
                    <form action="supprimer.php" method="POST"  class="form" role="form">

                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <p class="alert alert-warning">voulez vous vraiment supprimer ce produit?</p>
                        <div class="form-actions"> 
                            <button type="submit" class="btn btn-warning"  >Oui</button>
                            <a href="index.php" class="btn btn-default" >Non</a> 
                        </div>
                       
                    </form>
                </div>
        </div>
            
    </body>
</html>