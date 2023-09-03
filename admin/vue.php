
<?php

require 'db.php';

if(!empty($_GET['id'])){
    $id=checkInput($_GET['id']);
}

$db=Database::Connection();
$requete=$db->prepare('SELECT produits.id,produits.nom,produits.prix,produits.description, produits.image,categories.nom AS categories
FROM produits  LEFT JOIN categories ON produits.categories=categories.id
WHERE produits.id=?');

$requete->execute(array($id));

$produits=$requete->fetch();
Database::deconnection();





/**fonction */

function checkInput($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
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
    <div class="container  admin">
        <div class="row">
            <div class="col-sm-6  col-md-6 col-lg-6">
                <h1><strong>voir un produit</strong></h1> <br>
                <form>
                    <div class="form-group">
                        <label >Nom:<?php echo'   '.$produits['nom'];?></label>
                    </div><br>
                    <div class="form-group">
                        <label >Description:<?php echo'   '.$produits['description'];?></label>
                    </div><br>
                    <div class="form-group">
                        <label >Prix:<?php echo'   '.number_format((float)$produits['prix'],2,'.','');?> fcfa</label>
                    </div><br>
                    <div class="form-group">
                        <label >Categories:<?php echo'   '.$produits["categories"];?></label>
                    </div><br>
                    <div class="form-group">
                        <label >Image:<?php echo'   '.$produits["image"];?></label>
                    </div>
                </form>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-6 site">
                <div class="img-thumbnail">
                    <img src="<?php echo '../image/'.$produits['image'] ;?>" class='img-fluid' alt="...">
                    <div class='prix'><?php echo'   '.number_format((float)$produits['prix'],2,'.','');?> FCFA</div>
                        <div class="caption">
                            <h4><?php echo'   '.$produits['nom'];?></h4>
                            <p><?php echo'   '.$produits['description'];?></p>
                            <a href="#" class="btn btn-order" role="button"><span class="bi-cart-fill"></span>commander</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="action-form">
                <a href="index.php" class="btn btn-primary" ><span class="bi-arrow-left"></span>retour</a>
            </div>
            
    </div>

        
    </body>
</html>