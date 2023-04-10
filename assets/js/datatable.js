$(document).ready(function () {
    $('.dataTable').DataTable({
      "order": [[0, "desc"]], // Tri par ordre décroissant de la première colonne
      "paging": true // Activation de la pagination
    });
  });