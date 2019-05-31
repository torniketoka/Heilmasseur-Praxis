<!DOCTYPE html>

<?php
  $user = 'a01469313';
  $pass = 'atmospero1';
  $database = 'lab';
 
  // establish database connection
  $conn = oci_connect($user, $pass, $database);
  if (!$conn)
{ 
  exit("Keine Verbindung zu DBS");
}

//preparing sql query for hotel search

$conditions = array();
$searchPraxisgemeinschaftSql = "SELECT * FROM Praxisgemeinschaft";


//search Praxisgemeinschaft
if (!empty($_GET['action']) && $_GET['action'] == 'search') {
  //prepare conditions for query if they was passed
  if (!empty($_GET['PGID'])) {
    $conditions[] = "PGID = " . $_GET['PGID'];
  }

  if (!empty($_GET['PGNAME'])) {
    $conditions[] = "UPPER(PGNAME) like '%" . strtoupper($_GET['PGNAME']) . "%'";
  }

  if (!empty($conditions)) {
    $searchPraxisgemeinschaftSql .= " WHERE " . implode(' AND ', $conditions);
  }
}


//create Praxisgemeinschaft
if (!empty($_GET['action']) && $_GET['action'] == 'create') {
  $createPraxisgemeinschaftSql = "INSERT INTO Praxisgemeinschaft (PgID, pgname) VALUES('" . $_POST['PGID'] . "','" . $_POST['PGNAME'] . "')";

  $stmt = oci_parse($conn, $createPraxisgemeinschaftSql);
  oci_execute($stmt);

  header("Location: ?");
}

//delete Praxisgemeinschaft
if (!empty($_GET['action']) && $_GET['action'] == 'delete') {
  $deletePraxisgemeinschaftSql = "DELETE FROM Praxisgemeinschaft WHERE PGID = " . $_GET['PGID'];
  $deletePraxisraumSql = "DELETE FROM Praxisraum WHERE PGID = " . $_GET['PGID'];

  $stmt = oci_parse($conn, $deletePraxisgemeinschaftSql);
  oci_execute($stmt);

  $stmt = oci_parse($conn, $deletePraxisraumSql);
  oci_execute($stmt);

  header("Location: ?");
}

//update Praxisgemeinschaft
if (!empty($_GET['action']) && $_GET['action'] == 'update') {
  $getRowForUpdate = "SELECT * FROM Praxisgemeinschaft WHERE PGID = " . $_GET['PGID'];
  $stmt = oci_parse($conn, $getRowForUpdate);
  oci_execute($stmt);
  $rowForUpdate = oci_fetch_array($stmt, OCI_ASSOC);

  if (!empty($_POST)) {
    $updatePraxisgemeinschaftSql = "UPDATE Praxisgemeinschaft SET PGID = '" . $_POST['PGID'] . "', PGNAME = '" . $_POST['PGNAME'] . "' WHERE PGID = " . $_GET['PGID'];

    $stmt = oci_parse($conn, $updatePraxisgemeinschaftSql);
    oci_execute($stmt);

    header("Location: ?");
  }
}
//add order for beautify
$searchPraxisgemeinschaftSql .= " ORDER BY PGID";


//parse and execute sql statement
$stmt = oci_parse($conn, $searchPraxisgemeinschaftSql);
oci_execute($stmt);
?>



<html>
  <head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <title>Massage Praxis</title>
  </head>

  <body>
    <div class="container">
      <br>

      <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
        <img src="logo.jpg.png" alt="Massage praxis Logo" width="100" height="100" align="top">
          
            <a href="Arzt.php">Arzt</a>
          </li>
          <li>
            <a href="Patient.php">Patient</a>
          </li>
          <li>
            <a href="Heilmasseur.php">Heilmasseur</a>
          </li>
          <li>
          <li class="active">
            <a href="Praxisgemeinschaft.php">Praxisgemeinschaft</a>
          </li>
          <li>
            <a href="Praxisraum.php">Praxisraum</a>
          </li>
          <li>
            <a href="Rechnung.php">Rechnung</a>
          </li>
      </div>

      <div class="col-md-9">



<!-- navigation -->
        <ol class="breadcrumb">
          <li><a href="index.php">Massage Praxis</a></li>
          <li class="active">Praxisgemeinschaft</li>
        </ol>
<!-- Haupt panel mit Tabelle -->
        <div class="panel panel-default">
          <div class="panel-body">
<!-- Tabelle Panel -->
            <form id=1 method='get'>
              <input type="hidden" name="action" value="search">
<!-- Refresh Taste -->
              <input class="btn btn-link" type="submit" value="Refresh" />



 <!-- Haupt Tabelle -->
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="th1" width="50">PgID</th>
                    <th width="100">pgname</th>  
                    <th width="50">update</th> 
                    <th width="50">delete</th>      
                  </tr>
                </thead>
                <tbody>

  <!-- Search zeile-->
                  <tr>
                    <td><input name='PGID' value='<?= @$_GET['PGID'] ?: '' ?>' style="width:100%" /></td>
                    <td><input name='PGNAME' value='<?= @$_GET['PGNAME'] ?: '' ?>' style="width:70%" /></td>
                    <td></td>
                    <td></td>
                  </tr>

                  <!-- Ausgeben Zeilen mit inf von Daten -->
                  <?php while($row = oci_fetch_array($stmt, OCI_ASSOC)): ?>
                  <tr>
                    <td class="th1"><?= $row['PGID'] ?></td>
                    <td class="th1"><?= $row['PGNAME'] ?></td>
                    <td><a href="?action=update&PGID=<?= $row["PGID"] ?>">update</a></td>
                    <td><a href="?action=delete&PGID=<?= $row["PGID"] ?>">delete</a></td>
                  </tr>
                  <?php endwhile; ?>

                </tbody>
              </table>
            </form>
          </div>
        </div>
        

        
        <?php  oci_free_statement($stmt); ?>


  <!-- zweite Panel form -->
        <div class="panel panel-default">
          <div class="panel-body">
<!-- Form -->
            <form class="form-horizontal" action="?action=<?=isset($_GET['action']) ? $_GET['action'] . '&PGID=' . $_GET['PGID'] : 'create'?>" method='post'>

<!--   PGID label + input -->
 <div class="form-group">
                <label for="PGID" class="col-sm-2 control-label">PGID</label>
                <div class="col-sm-10">
                  <input class="form-control" name='PGID' value="<?=isset($rowForUpdate) ? $rowForUpdate['PGID'] : ''?>" />
                </div>
              </div>

              <!-- PGNAME label + input -->
              <div class="form-group">
                <label for="PGID" class="col-sm-2 control-label">PGNAME</label>
                <div class="col-sm-10">
                  <input class="form-control" name='PGNAME' value="<?=isset($rowForUpdate) ? $rowForUpdate['PGNAME'] : ''?>" />
                </div>
              </div>
              
<!-- Zeilen Werfen oder senden  -->
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-default">Speichern</button>
                  <button type="submit" class="btn btn-default">Abbrechen</button>
                 
                </div>
              </div>
            </form>

          </div>
        </div>
        
      </div>
    </div>
</body>
</html>