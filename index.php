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
     <link rel="stylesheet" href="css/styles.css">
     <!--lien vers javascript-->
     <script src="js/script.js" type="module" defer> </script>
     <!--les icons-->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
     
    </head>
    <body>
    <div class="container site">
        <h1 class="titre">Ets NL busness </h1>
        
    </div>
        <?php
        require 'admin/db.php';
        echo "  <nav class='nav'>
                    <ul class='nav nav-pills' role='tablist'>";
                    $db=Database::Connection();
                    $requete=$db->query("SELECT * FROM categories");
                    $categories=$requete->fetchAll();
                    foreach( $categories as $categorie){
                        if($categorie['id']=='1'){
                           echo '<li class="nav-item" role="presentation"  >
                                    <a class="nav-link active"  data-bs-target="#tab'.$categorie['id'].'" data-bs-toggle="pill" role="tab">'.$categorie['nom'].'</a>
                                </li>';
                        }
                        else{
                            echo '<li class="nav-item" role="presentation"  >
                                    <a class="nav-link "  data-bs-target="#tab'.$categorie['id'].'" data-bs-toggle="pill" role="tab">'.$categorie['nom'].'</a>
                                </li>';
                        }
                    }
                    echo '       </ul>
                            </nav>';


                    echo ' <div class="tab-content">';
                    foreach ($categories as $categorie) {
                        if($categorie['id'] == '1') {
                            echo '<div class="tab-pane active" id="tab' . $categorie['id'] .'" role="tabpanel">';
                        } else {
                            echo '<div class="tab-pane" id="tab' . $categorie['id'] .'" role="tabpanel">';
                        }
                        
                        echo '<div class="row">';
                        
                        $requete= $db->prepare(' SELECT * FROM produits WHERE produits.categories = ? ');
                        $requete->execute(array($categorie['id']));
                        while ($produits = $requete->fetch()) {
                            echo '<div class="col-md-6 col-lg-4">
                                    <div class="img-thumbnail">
                                        <img src="image/' . $produits['image'] . '" class="img-fluid" alt="...">
                                        <div class="prix">' . number_format($produits['prix'], 2, '.', ''). 'f</div>
                                        <div class="caption">
                                            <h4>' . $produits['nom'] . '</h4>
                                            <p>' . $produits['description'] . '</p>
                                            <a href="#" class="btn btn-order" role="button"><span class="bi-cart-fill"></span> Commander</a>
                                        </div>
                                    </div>
                                </div>';
                        }
                       
                       echo    '</div>
                            </div>';
                    }
                    Database::deconnection();
                    echo  '</div>';
                ?>
    
            </div>
        </body>
    </html>
     

   























