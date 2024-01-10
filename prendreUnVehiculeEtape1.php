<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Prise en charge d'un véhicule</title>
  <link href="prendreVehicule.css" rel="stylesheet" />

</head>
<body>
  <div class="header">
    <h1 id="titre">Service de Gestion de Véhicules</h1>
    <nav class="navigation">
    <a class="lien-styliseNav" href="gestionVehicule.html">Accueil</a>
        <a class="lien-styliseNav" href="prendreUnVehiculeEtape1.php">Prendre un véhicule</a>
        <a class="lien-styliseNav" href="rendreUnVehiculeEtape1.php">Rendre un véhicule</a>
        <a class="lien-styliseNav" href="ajoutIndividu.php">Gestion des Individus</a>
        <a class="lien-styliseNav" href="ajoutVehicue.php">Gestion des Véhicules</a><br><br><br>

    </nav>
  </div>

  <div class="container">
    <h2>Prise en charge d'un véhicule</h2>
    <p>Veuillez choisir l'utilisateur du véhicule :</p>
    <div class="personne">
    
    <?php
    include 'BaseDeDonnee.php';
   
    $requetePersonnes = 'SELECT idPersonne, civilite, nom, prenom FROM personne';
    $resultatPersonnes = $connexionALaBdD->prepare($requetePersonnes);
    $resultatPersonnes->execute();
    echo '<br>';
    
    while ($donneesPersonne = $resultatPersonnes->fetch()) {
    echo '<a class="lien-stylise" href="prendreUnVehiculeEtape2.php?idPersonne=' . $donneesPersonne['idPersonne'] . '">' . $donneesPersonne['civilite'] . '  ' . $donneesPersonne['nom'] . '  ' . $donneesPersonne['prenom'] . ' </a><br><br><br>';
    }

    $resultatPersonnes->closeCursor();
?>


    
  </div> 
</div>

  
  </body>
  </html>