<?php
        include('../model/bdd.php');
        
        if(isset($_GET['category']) || isset($_GET['words']) || isset($_GET['cities']) || isset($_GET['department']))
        {
            $words=$_GET['words'];
            $city=$_GET['cities'];
            $department=$_GET['department'];
            $w=explode(" ", $words);
            $c=explode(" ", $city);
            $d=explode(" ", $department);
            $category=$_GET['category'];
            $sql="SELECT * FROM annonce";
            $i=0;
            
        if($words != "")
        {
            foreach($w as $word)
            {
                if(strlen($word)>3)
                {
                    if($i==0)
                    {
                        $sql.=" WHERE";
                    }
                    else
                    {
                        $sql.=" OR";
                    }
                    $sql.=" title LIKE '%$word%' OR name LIKE '%$word%' OR description LIKE '%$word%'";
                    $i++;
                }
            }
        }
           
            if($category != "category")
            {
                if($i==0)
                {
                    $sql.=" WHERE";
                } 
                else
                {
                    $sql.=" AND";
                }

                $sql.=" category LIKE '%$category%'";
                $i++;
            }

            if($department != "")
        {
            foreach($d as $department)
            {
                if(strlen($department)>3)
                {
                    if($i==0)
                    {
                        $sql.=" WHERE";
                    }
                    else
                    {
                        $sql.=" AND";
                    }
                    $sql.=" location LIKE '%$department%'";
                    $i++;
                }
            }
        }
           
            if($city != "")
        {
            foreach($c as $city)
            {
                if(strlen($city)>3)
                {
                    if($i==0)
                    {
                        $sql.=" WHERE";
                    }
                    else
                    {
                        $sql.=" AND";
                    }
                    $sql.=" city LIKE '%$city%'";
                    $i++;
                }
            }
        }
            
        
        if (isset($sql)!=0)
        {

    
            $req=$bdd->query($sql) or die(mysql_error());
            $count = $req->rowCount();
            echo $count." resultat(s)";

            while ($donnees = $req->fetch())
            {

                echo'<hr>';
                echo '<div id="accueil"> Titre de l\'annonce : <strong>'.$donnees['title'] .
                 '</strong><br /> Nom du produit : <strong>'.$donnees['name']. 
                 '</strong><br /> catégorie de produit : <strong>' .$donnees['category'] . 
                 '</strong><br /> Région de disponibilité : <strong>'.$donnees['location']. 
                 '</strong><br /> Ville où le produit est disponible : <strong>' .$donnees['city'] . 
                 '</strong><br /> Description du produit : <strong>'.$donnees['description'].'</strong></div> <br />';

            }
        }
        }
    ?>