<?php 
//on inclut la page qui nous permet de nous connecter à la base de donnée
include('../model/bdd.php');

$maxwidth= 1048576;
$maxheight= 1048576;
$erreur = "remplissez bien tous les champs ;)";



    //Vérification de l'existence des variables
    if (!empty($_POST['title']) && !empty($_POST['name']) && !empty($_POST['category'])&& !empty($_POST['location']) && !empty($_POST['city']) && !empty($_POST['description']) )  
    {
              $title     = htmlspecialchars($_POST["title"]);
              $name     = htmlspecialchars($_POST["name"]);
              $category     = htmlspecialchars($_POST["category"]);
              $location      = htmlspecialchars($_POST["location"]);
              $city      = htmlspecialchars($_POST["city"]);
              $description      = htmlspecialchars($_POST["description"]);
              $image_nom    = $_FILES['fichier']['name'];
        // Remplissage de la base de donnée          
        $req = $bdd->prepare('INSERT INTO annonce(title, name, prenomPost, category, location, city, description, date_mise_en_ligne, image_nom) VALUES(:title, :name, :prenomPost, :category, :location, :city, :description, CURDATE(), :image_nom)');

        if (isset($_POST['upload']))
            {
                $req->execute(array(
            'title' => $title,
            'name' => $name,
            'prenomPost'=>$_SESSION['userPrenom'],
            'category' => $category,
            'location' => $location,
            'city' => $city,
            'description'=> $description,
            'image_nom'=>$image_nom
            )); 

                
              //  $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
                //$extension_upload = strtolower( strrchr($_FILES['fichier']['name'], '.'));
                   
             //   if ( in_array($extension_upload,$extensions_valides) ) 
               // {

                    
                    //$image_sizes = getimagesize($_FILES['fichier']['tmp_name']);

                    if ($image_sizes[0] > $maxwidth OR $image_sizes[1] > $maxheight) $erreur = "Image trop grande";

                      mkdir('../images/'.$_SESSION["userPrenom"].'/annonce_upload', 0777, true);

                     $upload_dir = '/../images/'.$_SESSION["userPrenom"].'/annonce_upload';
                    $resultat = move_uploaded_file($image_nom, $upload_dir);
                    if ($resultat!=FALSE)
                    {
                        $erreur = "Votre Annonce à bien été Postée ! ";
           
                    }
                    else
                    {
                        $erreur= "problème en vu";
                    }
               // }
               
                       
            }
            elseif ( empty($_POST['title']))
        
            {  
                $erreur = "Tu as oublié de rentrer un titre";
            }
            elseif (empty($_POST['name']))
        
            {
                $erreur ="Tu as oublié de rentrer un nom";
            }
             elseif (empty($_POST['category']))
        
            {
                $erreur ="Tu as oublié de rentrer la catégorie du produit";
            }
             elseif (empty($_POST['location']))
        
            {
                $erreur ="Tu as oublié de rentrer la région dans laquelle sera disponible ton annonce";
            }
             elseif (empty($_POST['city']))
        
            {
                $erreur ="Tu as oublié de rentrer la ville dans laquelle sera disponible ton annonce";
            }
            elseif (empty($_POST['description']))
        
            {
                $erreur ="Tu as oublié de rentrer une description de ton annonce";
            }
            else
            {
                $erreur ="quelque chose ne vas pas !!";
                
            }
    }
    include('../view/PosterAnnonce.php');
?>