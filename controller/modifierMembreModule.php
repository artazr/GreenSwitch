<?php 
//on inclut la page qui nous permet de nous connecter à la base de donnée
include('../model/bdd.php');

$user = $bdd->prepare('SELECT prenom, nom, email, age, telephone FROM users WHERE id='.$_GET['idmembre']);
$user -> execute();

$info = $user -> fetch();

if($_POST['modifier']){
header('location : ../view/Admin.php');
}
?>	