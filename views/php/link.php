<link rel="shortcut icon" href="views/img/logo.jpeg">
    <link rel="stylesheet" href="views/css/modal.css">
    <link href="views/css/sb-admin-2.css" rel="stylesheet">
    <link href="views/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- SweetAlert2 CSS -->
       <link href="views/css/sweetalert2.min.css" rel="stylesheet">

      <link rel="stylesheet" type="text/css" href="views/js/DataTables/datatables.css">
      <!-- <link rel="stylesheet" type="text/css" href="views/js/DataTables/DataTables/css/dataTables.bootstrap.css"> -->
      <!-- <link rel="stylesheet" type="text/css" href="views/js/DataTables/DataTables/css/responsive.dataTables.min.css"> -->
   <script src="views/js/jquery.js"></script>


    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> -->
    <script src="views/js/sweetalert2.min.js"></script>
    <script src="views/js/index.js"></script>
    <script src="views/js/validate_login.js"></script>
    <script src="views/js/confirm.js"></script>

   
   <script src="views/js/DataTables/datatables.js"></script>
   <!-- <script src="views/js/DataTables/DataTables/js/dataTables.bootstrap.js"></script> -->
   <!-- <script src="views/js/DataTables/DataTables/js/dataTables.responsive.min.js"></script> -->
<script>
   $(function () {
      // $(".datatable").DataTable();
      $(".datatablesss").DataTable({
         "language": {
            "url": "views/js/DataTables/spanish.json",
            'info': true,
         },
         responsive: true,
      });
   });
</script>