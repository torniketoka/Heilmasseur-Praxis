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

//preparing sql query for Rechnung search

$conditions = array();
$searchRechnungSql = "SELECT * FROM Rechnung";


//search Rechnung
if (!empty($_GET['action']) && $_GET['action'] == 'search') {
  //prepare conditions for query if they was passed
  if (!empty($_GET['RECHNUNGSNUMMER'])) {
    $conditions[] = "RECHNUNGSNUMMER = " . $_GET['RECHNUNGSNUMMER'];
  }

  if (!empty($_GET['RECHNUNGSDATUM'])) {
    $conditions[] = "UPPER(RECHNUNGSDATUM) like '%" . strtoupper($_GET['RECHNUNGSDATUM']) . "%'";
  }

  if (!empty($_GET['SUMME'])) {
    $conditions[] = "UPPER(SUMME) like '%" . strtoupper($_GET['SUMME']) . "%'";
  }

 if (!empty($_GET['PATIENTID'])) {
    $conditions[] = "UPPER(PATIENTID) like '%" . strtoupper($_GET['PATIENTID']) . "%'";
  }

 if (!empty($_GET['VERSICHERUNGSART'])) {
    $conditions[] = "UPPER(VERSICHERUNGSART) like '%" . strtoupper($_GET['VERSICHERUNGSART']) . "%'";
  }

  if (!empty($conditions)) {
    $searchRechnungSql .= " WHERE " . implode(' AND ', $conditions);
  }
}


//create RECHNUNG
if (!empty($_GET['action']) && $_GET['action'] == 'create') {
  $createRechnungSql = "INSERT INTO Rechnung(Rechnungsdatum, Summe, PatientID, Versicherungsart) VALUES( to_date('" . $_POST['RECHNUNGSDATUM'] . "', 'dd-mm-yyyy'), '"  . $_POST['SUMME'] . "', '" . $_POST['PATIENTID'] . "','" . $_POST['VERSICHERUNGSART'] . "')";

  $stmt = oci_parse($conn, $createRechnungSql);
  oci_execute($stmt);

  header("Location: ?");
}

//delete RECHNUNG
if (!empty($_GET['action']) && $_GET['action'] == 'delete') {
  $deleteRechnungSql = "DELETE FROM Rechnung WHERE RECHNUNGSNUMMER = " . $_GET['RECHNUNGSNUMMER'];

  $stmt = oci_parse($conn, $deleteRechnungSql);
  oci_execute($stmt);

  header("Location: ?");
}



//update RECHNUNG
if (!empty($_GET['action']) && $_GET['action'] == 'update') {
  $getRowForUpdate = "SELECT * FROM Rechnung WHERE RECHNUNGSNUMMER = " . $_GET['RECHNUNGSNUMMER'];
  $stmt = oci_parse($conn, $getRowForUpdate);
  oci_execute($stmt);
  $rowForUpdate = oci_fetch_array($stmt, OCI_ASSOC);

  if (!empty($_POST)) {
    $updateRechnungSql = "UPDATE Rechnung SET RECHNUNGSDATUM = to_date('" . $_POST['RECHNUNGSDATUM'] . "', 'dd-mm-yyyy'), SUMME = '" . $_POST['SUMME'] . "', PATIENTID = '" . $_POST['PATIENTID'] . "', VERSICHERUNGSART = '" . $_POST['VERSICHERUNGSART'] . "' WHERE RECHNUNGSNUMMER = " . $_GET['RECHNUNGSNUMMER'];

    $stmt = oci_parse($conn, $updateRechnungSql);
    oci_execute($stmt);

    header("Location: ?");
  }
}
//add order for beautify
$searchRechnungSql .= " ORDER BY RECHNUNGSNUMMER";


//parse and execute sql statement
$stmt = oci_parse($conn, $searchRechnungSql);
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
          <a href="Patient.php">Patient</a>
          </li>
          <li>
          <a href="Heilmasseur.php">Heilmasseur</a>
          </li>
          <li>
            <a href="Praxisgemeinschaft.php">Praxisgemeinschaft</a>
          </li>
          <li>
            <a href="Praxisraum.php">Praxisraum</a>
          </li>
          <li>
          <li class="active">
            <a href="Rechnung.php">Rechnung</a>
          </li>
      </div>

      <div class="col-md-9">



<!-- navigation -->
        <ol class="breadcrumb">
          <li><a href="index.php">Massage Praxis</a></li>
          <li class="active">Rechnung</li>
        </ol>
<!-- Haupt Panel mit Tabelle -->
        <div class="panel panel-default">
          <div class="panel-body">
<!-- Tabelle panel -->
            <form id=1 method='get'>
              <input type="hidden" name="action" value="search">
<!-- Refresh taste -->
              <input class="btn btn-link" type="submit" value="Refresh" />



 <!-- Haupt tabelle -->
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th width="50">Rechnungsnummer</th>
                    <th width="50">Rechnungsdatum (dd-mm-yyyy)</th>
                    <th width="50">Summe</th>
                    <th width="50">PatientID</th>
                    <th width="50">Versicherungsart</th>
                    <th width="50">update</th>   
                    <th width="50">delete</th>        
                  </tr>
                </thead>
                <tbody>

  <!-- Search Zeilen -->
                  <tr>
                    <td><input name='RECHNUNGSNUMMER' value='<?= @$_GET['RECHNUNGSNUMMER'] ?: '' ?>' style="width:100%" /></td>
                    <td><input name='RECHNUNGSDATUM' value='<?= @$_GET['RECHNUNGSDATUM'] ?: '' ?>' style="width:100%" /></td>
                    <td><input name='SUMME' value='<?= @$_GET['SUMME'] ?: '' ?>' style="width:100%" /></td>
                    <td><input name='PATIENTID' value='<?= @$_GET['PATIENTID'] ?: '' ?>' style="width:100%" /></td>
                    <td><input name='VERSICHERUNGSART' value='<?= @$_GET['VERSICHERUNGSART'] ?: '' ?>' style="width:100%" /></td>
                    <td></td>
                    <td></td>
                  </tr>

                  <!-- Ausgeben zeilen min Inf von Daten -->
                  <?php while($row = oci_fetch_array($stmt, OCI_ASSOC)): ?>
                  <tr>
                    <td><?= $row['RECHNUNGSNUMMER'] ?></td>
                    <td><?= $row['RECHNUNGSDATUM'] ?></td>
                    <td><?= $row['SUMME'] ?></td>
                    <td><?= $row['PATIENTID'] ?></td>
                    <td><?= $row['VERSICHERUNGSART'] ?></td>
                    <td><a href="?action=update&RECHNUNGSNUMMER=<?= $row["RECHNUNGSNUMMER"] ?>">update</a></td>
                    <td><a href="?action=delete&RECHNUNGSNUMMER=<?= $row["RECHNUNGSNUMMER"] ?>">delete</a></td>
                  </tr>
                  <?php endwhile; ?>

                </tbody>
              </table>
            </form>
          </div>
        </div>
        

        
        <?php  oci_free_statement($stmt); ?>


  <!-- Zweite Panel form -->
        <div class="panel panel-default">
          <div class="panel-body">
<!--Form  -->
            <form class="form-horizontal" action="?action=<?=isset($_GET['action']) ? $_GET['action'] . '&RECHNUNGSNUMMER=' . $_GET['RECHNUNGSNUMMER'] : 'create'?>" method='post'>

<!--  RECHNUNG label + input -->
                <div class="form-group">
                <label for="RECHNUNGSNUMMER" class="col-sm-2 control-label">RECHNUNGSNUMMER</label>
                <div class="col-sm-10">
                  <input class="form-control" name='RECHNUNGSNUMMER' value="<?=isset($rowForUpdate) ? $rowForUpdate['RECHNUNGSNUMMER'] : ''?>" disabled/>
                </div>
              </div>

              <!-- RECHNUNGSDATUM label + input -->
              <div class="form-group">
                <label for="RECHNUNGSNUMMER" class="col-sm-2 control-label">RECHNUNGSDATUM</label>
                <div class="col-sm-10">
                  <input class="form-control" name='RECHNUNGSDATUM' value="<?=isset($rowForUpdate) ? $rowForUpdate['RECHNUNGSDATUM'] : ''?>" />
                </div>
              </div>

<!-- SUMME label + input -->
              <div class="form-group">
                <label for="RECHNUNGSNUMMER" class="col-sm-2 control-label">SUMME</label>
                <div class="col-sm-10">
                  <input class="form-control" name='SUMME' value="<?=isset($rowForUpdate) ? $rowForUpdate['SUMME'] : ''?>" />
                </div>
              </div>

<!-- PATIENTID label + input -->
              <div class="form-group">
                <label for="RECHNUNGSNUMMER" class="col-sm-2 control-label">PATIENTID</label>
                <div class="col-sm-10">
                  <input class="form-control" name='PATIENTID' value="<?=isset($rowForUpdate) ? $rowForUpdate['PATIENTID'] : ''?>" />
                </div>
              </div>

<!-- VERSICHERUNGSART label + input -->
              <div class="form-group">
                <label for="RECHNUNGSNUMMER" class="col-sm-2 control-label">VERSICHERUNGSART</label>
                <div class="col-sm-10">
                  <input class="form-control" name='VERSICHERUNGSART' value="<?=isset($rowForUpdate) ? $rowForUpdate['VERSICHERUNGSART'] : ''?>" />
                </div>
              </div>


  <!-- Zeilen Werfen und senden Form -->
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