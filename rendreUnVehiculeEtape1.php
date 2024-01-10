<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Rendre un Véhicule</title>
  <link href="rendreVehicule.css" rel="stylesheet" />
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.getElementById('titre').style.opacity = 1;
    });
  </script>
</head>

<body>
  <div class="header">
    <h1 id="titre">Rendre Un Véhicule</h1>
    <nav class="navigation">
      <a class="lien-styliseNav" href="gestionVehicule.html">Accueil</a>
      <a class="lien-styliseNav" href="prendreUnVehiculeEtape1.php">Prendre un véhicule</a>
      <a class="lien-styliseNav" href="rendreUnVehiculeEtape1.php">Rendre un véhicule</a>
      <a class="lien-styliseNav" href="ajoutIndividu.php">Gestion des Individus</a>
      <a class="lien-styliseNav" href="ajoutVehicue.php">Gestion des Véhicules</a><br><br><br>
    </nav>
  </div>

  <?php
  include 'BaseDeDonnee.php';

  $queryVehicles = "SELECT t.idTrajet, p.nom, p.prenom, v.marque, v.type, v.immatriculation 
                  FROM trajet t
                  JOIN personne p ON t.idPersonne = p.idPersonne
                  JOIN vehicule v ON t.idVehicule = v.idVehicule
                  WHERE t.dateArrivee = '0000-00-00' OR t.heureArrivee = '00:00:00'";

  $resultat = $connexionALaBdD->query($queryVehicles);

  while ($data = $resultat->fetch()) {
    echo "<div class='info'>";
    echo "<strong>Nom Prénom :</strong> " . htmlspecialchars($data['nom']) . ' ' . htmlspecialchars($data['prenom']) . "<br>";
    echo "<strong>Marque :</strong> " . htmlspecialchars($data['marque']) . "<br>";
    echo "<strong>Type :</strong> " . htmlspecialchars($data['type']) . "<br>";
    echo "<strong>Immatriculation :</strong> " . htmlspecialchars($data['immatriculation']) . "<br>";
    echo "<a href='rendreUnVehiculeEtape2.php?idTrajet=" . htmlspecialchars($data['idTrajet']) . "' class='lien-stylise'>Rendre ce véhicule</a>";
    echo "</div>";
  }

  echo "<a href='gestionVehicule.html' class='back'>Précédent</a>";
  $resultat->closeCursor();
  ?>

</body>

</html>