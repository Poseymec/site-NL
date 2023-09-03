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
            <h1><strong>Liste des produits</strong> <a href="ajouter.php" class="btn btn-success btn-md"><span class="bi-plus"></span> ajouter</a></h1>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Categories</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require 'db.php';
                    $db=Database::connection();
                    $requete=$db->query('SELECT produits.id,produits.nom,produits.prix,produits.description,categories.nom AS categories 
                                          FROM produits  LEFT JOIN categories ON produits.categories=categories.id
                                          ORDER BY produits.id DESC  ');
                    while($produits=$requete->fetch()){

                      echo ' <tr>';
                      echo '<td>'.$produits['nom'].'</td>';
                      echo '<td>'.$produits['description'].'</td>';
                      echo '<td>'.$produits['prix'].'F</td>';
                      echo '<td>'.$produits['categories'].'</td>';
                      echo '<td width=320px>';
                            echo '<a class="btn btn-secondary vue" href="vue.php?id='.$produits['id'].'"><span class="bi-eye "></span>Voir</a>';
                            echo ' ';
                            echo '<a class="btn btn-primary modifier" href="modifier.php?id='.$produits['id'].'"><span class="bi-pencil"></span>Modifier</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger supprimer" href="supprimer.php?id='.$produits['id'].'"><span class="bi-x"></span>Spprimer</a>';
                           
                    echo'</td>';
                    echo'</tr>';
                    }
                    Database::deconnection();
                    ?>
                </tbody>
            </table>
        </div>
    </div>


        
    </body>
</html>