<?php
require 'db.php';

if(!empty($_GET['id'])){
    $id=verification($_GET['id']);
}

$nomErreur=$descriptionErreur=$prixErreur=$categoriesErreur=$imageErreur="";
$nom=$description=$prix=$categories=$image="";

if(!empty($_POST)){
    $nom=verification($_POST['nom']);
    $description=verification($_POST['description']);
    $prix=verification($_POST['prix']);
    $categories=verification($_POST['categories']);
    $image=verification($_FILES['image']['name']);
    $imagePath='../image/'.basename($image);
    $imageExtension=pathinfo($imagePath,PATHINFO_EXTENSION);

    $isSuccess=true;
    

    if(empty($nom)){
        $nomErreur='ce champ ne peut pas être vide';
        $isSuccess=false;
    }
    if(empty($description)){
        $descriptionErreur='ce champ ne peut pas être vide';
        $isSuccess=false;
    }
    if(empty($prix)){
        $prixErreur='ce champ ne peut pas être vide';
        $isSuccess=false;
    }
    if(empty($categories)){
        $categoriesErreur='ce champ ne peut pas être vide';
        $isSuccess=false;
    }
    if(empty($image)){
        $isImageUpdated = false;
       
    }else{
        $isImageUpdated = true;
        $isUploadSuccess = true;
        if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) {
            $imageErreur = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
            $isUploadSuccess = false;
        }
        if(file_exists($imagePath)) {
            $imageErreur = "Le fichier existe deja";
            $isUploadSuccess = false;
        }
        if($_FILES["image"]["size"] > 500000) {
            $imageErreur = "Le fichier ne doit pas depasser les 500KB";
            $isUploadSuccess = false;
        }
        if($isUploadSuccess) {
            if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                $imageErreur = "Il y a eu une erreur lors de l'upload";
                $isUploadSuccess = false;
            } 
        } 
    
    }

    if(($isSuccess && $isUploadSuccess && $isImageUpdated )||($isSuccess && !$isImageUpdated ) ) {
        $db = Database::connection();
        if($isImageUpdated){
            $requete = $db->prepare("UPDATE  produits set  nom=?,description=?,prix=?,categories=?,image=? WHERE id=? ");
            $requete->execute(array($nom,$description,$prix,$categories,$image,$id));

        }else{
            $requete = $db->prepare("UPDATE  produits set  nom=?,description=?,prix=?,categories=? WHERE id=? ");
            $requete->execute(array($nom,$description,$prix,$categories,$id));

        }
      
        Database::deconnection();
        header("Location: index.php");
    }
   else if($isImageUpdated && !$isUploadSuccess){
        $db = Database::connection();
        $requet=$db->prepare("SELECT * FROM produits WHERE id=?");
        $requet->execute(array($id));
        $produits=$requet->fetch();
    
        $image=$produits['image'];
        Database::deconnection();
            
    }
}
else{
    $db = Database::connection();
    $requet=$db->prepare("SELECT * FROM produits WHERE id=?");
    $requet->execute(array($id));
    $produits=$requet->fetch();

    $nom=$produits['nom'];
    $description=$produits['description'];
    $prix=$produits['prix'];
    $categories=$produits['categories'];
    $image=$produits['image'];
    Database::deconnection();
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
            <h1><strong>modifier un produit</strong></h1> <br>
            <div class="row">
                <div class="col-sm-6  col-md-6 col-lg-6">
                    <form action="<?php echo 'modifier.php?id='.$id;?>" method="POST" enctype="multipart/form-data" class="form" role="form">
                        <div class="form-group">
                            <label for="nom" >Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control" placeholder="nom" value="<?php echo $nom;?>">
                            <span class="erreur"><?php echo $nomErreur;?></span>
                        </div> <br>
                        <div class="form-group">
                            <label for="description" >Description</label>
                            <input type="text" name="description" id="description" class="form-control" placeholder="description" value="<?php echo $description;?>">
                            <span class="erreur"><?php echo $descriptionErreur;?></span>
                        </div> <br>
                        <div class="form-group">
                            <label for="prix" >Prix</label>
                            <input type="text" name="prix" id="prix" class="form-control" placeholder="prix" value="<?php echo $prix;?>">
                            <span class="erreur"><?php echo $prixErreur;?></span>
                        </div> <br>
                        <div class="form-group">
                            <label for="categories" >Categorie</label>
                            <select  name="categories" id="categories" class="form-control" placeholder="categorie" >
                                <?php

                                $db=Database::Connection();

                                $requet=$db->query("SELECT * FROM categories");

                                foreach($requet as $valeur){

                                    if($valeur['id']==$categories){
                                        echo " <option selected='selected' value=".$valeur['id'].">".$valeur['nom']."</option>"; 
                                    }else{

                                        echo " <option value=".$valeur['id'].">".$valeur['nom']."</option>";
                                    }
                                }
                                $db=Database::deconnection();
                                
                                
                                ?>
                            </select>
                            <span class="erreur"><?php echo $categoriesErreur;?></span>
                        </div> <br>
                        <div class="form-group">
                            <label>Image:</label>
                            <p><?php echo $image;?></p>
                            <label for="image" > selectionner l'image</label>
                            <input type="file" name="image" id="image" class="form-control">
                            <span class="erreur"><?php echo $imageErreur;?></span>
                        </div> <br>
                        <div class="form-group">
                           
                        <button type="submit" class="btn btn-success"  ><span class="bi-plus"></span>modifier</button>
                        <a href="index.php" class="btn btn-primary" ><span class="bi-arrow-left"></span>retour</a> 
                        </div>
                       
                    </form>
                </div>
                <div class="col-sm-6  col-md-6 col-lg-6" >
                <div class="img-thumbnail">
                    <img src="<?php echo '../image/'.$image;?>" class='img-fluid' alt="...">
                    <div class='prix'><?php echo'   '.number_format((float)$prix,2,'.','');?> FCFA</div>
                        <div class="caption">
                            <h4><?php echo'   '.$nom;?></h4>
                            <p><?php echo'   '.$description;?></p>
                            <a href="#" class="btn btn-order" role="button"><span class="bi-cart-fill"></span>commander</a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
            
    </body>
</html>