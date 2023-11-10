
// click pour mettre par ordre croissant dans la liste des trophées

const button = document.getElementById('classByOrder');
const button1 = document.getElementById('classByOrder1');
const tableBody = document.querySelector('tbody');

button.addEventListener('click', function () {
  const rows = Array.from(tableBody.querySelectorAll('.ligne-trophee'));

  rows.sort(function (rowA, rowB) {
    const totalA = parseInt(rowA.querySelector('.total-trophee').textContent);
    const totalB = parseInt(rowB.querySelector('.total-trophee').textContent);

    return totalB - totalA;
  });
  
  rows.forEach(function (row) {
    tableBody.appendChild(row);
  });
});

button1.addEventListener('click', function () {
  const rows = Array.from(tableBody.querySelectorAll('.ligne-trophee'));
  rows.sort(function (rowA, rowB) {
    const totalA = parseInt(rowA.querySelector('.total-trophee').textContent);
    const totalB = parseInt(rowB.querySelector('.total-trophee').textContent);

    return totalA - totalB;
  });

  rows.forEach(function (row) {
    tableBody.appendChild(row);
  });
});



/*click sur image galerie*/


function cacherPhoto(tournoiId) {
  let photos = document.getElementById("photos " + tournoiId)
  ; //Ca sélectionne l'élément HTML correspondant à l'identifiant "photos " suivi de l'identifiant de tournoi qe je veux dans l'appel de la fonction.
  if (photos.style.display === "none") {
    photos.style.display = "block";
  } else {
    photos.style.display = "none";
  }
}

function affichageTitreW() {
  let titre = document.getElementById('titrePagePrincipaleWin'); 
  // Accéder à l'élément par son identifiant
  titre.style.animation = 'slide-in 1s ease'; 
}















