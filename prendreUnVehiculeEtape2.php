<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Gestion des véhicules</title>
  <link href="prendreVehicule.css" rel="stylesheet" />
  <script>
        document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('titre').style.opacity = 100;
        });
    </script>
</head>
<body>
<div class="navbar ">
    <br>
    <a class="lien-styliseNav" href="gestionVehicule.html">Accueil</a>
        <a class="lien-styliseNav" href="prendreUnVehiculeEtape1.php">Prendre un véhicule</a>
        <a class="lien-styliseNav" href="rendreUnVehiculeEtape1.php">Rendre un véhicule</a>
        <a class="lien-styliseNav" href="ajoutIndividu.php">Gestion des Individus</a>
        <a class="lien-styliseNav" href="ajoutVehicue.php">Gestion des Véhicules</a><br><br><br>

  </div>
  <br><br><br><br>
<div class="container">
  Bonjour

  <strong>
  <?php 
    $identifiantPersonne = $_GET['idPersonne'];
    include 'BaseDeDonnee.php';

    $requetePersonne = "SELECT prenom FROM personne WHERE idPersonne = $identifiantPersonne";
    $resultatPersonne = $connexionALaBdD->prepare($requetePersonne);
    $resultatPersonne->execute();
    
    while ($donneesPersonne = $resultatPersonne->fetch()) {
      echo $donneesPersonne['prenom'];
    }
?>

  </strong>
  
  ,  Vous avez l'intention de prendre un véhicule.<br>
  Veuillez choisir le véhicule que vous désirez utiliser
<br><br><br>
  <div class="personne">
  <?php
    $requeteVehicules = 'SELECT idVehicule, type, marque, immatriculation FROM vehicule';
    $resultatVehicules = $connexionALaBdD->prepare($requeteVehicules);
    $resultatVehicules->execute();
    echo '<br>';
    
    while ($donneesVehicule = $resultatVehicules->fetch()) {
      echo '<a class="lien-stylise" href="prendreUnVehiculeEtape3-v1.php?idPersonne=' . $identifiantPersonne . '&idVehicule=' . $donneesVehicule['idVehicule'] . '">' . $donneesVehicule['type'] . ' ' . $donneesVehicule['marque'] . ' ' . $donneesVehicule['immatriculation'] . '</a><br><br><br>';
    }

    $resultatVehicules->closeCursor();
?>

</div>
<center>
  <br><br>
    <a class="lien-styliseBack" href="prendreUnVehiculeEtape1.php"  class="btnRed">Précédent</a>
  </div>
  </center>


</div>



</body>
</html>