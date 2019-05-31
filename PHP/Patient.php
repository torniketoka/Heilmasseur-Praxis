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

//preparing sql query for Patient search

$conditions = array();
$searchPatientSql = "SELECT * FROM Patient";


//search Patient
if (!empty($_GET['action']) && $_GET['action'] == 'search') {
  //prepare conditions for query if they was passed
  if (!empty($_GET['PATIENTID'])) {
    $conditions[] = "PATIENTID = " . $_GET['PATIENTID'];
  }

  if (!empty($_GET['PNACHNAME'])) {
    $conditions[] = "UPPER(PNACHNAME) like '%" . strtoupper($_GET['PNACHNAME']) . "%'";
  }

  if (!empty($_GET['PVORNAME'])) {
    $conditions[] = "UPPER(PVORNAME) like '%" . strtoupper($_GET['PVORNAME']) . "%'";
  }

 if (!empty($_GET['PPLZ'])) {
    $conditions[] = "UPPER(PPLZ) like '%" . strtoupper($_GET['PPLZ']) . "%'";
  }

 if (!empty($_GET['PORT'])) {
    $conditions[] = "UPPER(PORT) like '%" . strtoupper($_GET['PORT']) . "%'";
  }

 if (!empty($_GET['PSTRASSE'])) {
    $conditions[] = "UPPER(PSTRASSE) like '%" . strtoupper($_GET['PSTRASSE']) . "%'";
  }

 if (!empty($_GET['GEBDAT'])) {
    $conditions[] = "UPPER(GEBDAT) like '%" . strtoupper($_GET['GEBDAT']) . "%'";
  }

 if (!empty($_GET['ARZTID'])) {
    $conditions[] = "ARZTID = " . $_GET['ARZTID'];
  }

 if (!empty($_GET['DIAGNOSSE'])) {
    $conditions[] = "UPPER(DIAGNOSSE) like '%" . strtoupper($_GET['DIAGNOSSE']) . "%'";
  }

 if (!empty($_GET['AUSSTELLUNGSDATUM'])) {
    $conditions[] = "UPPER(AUSSTELLUNGSDATUM) like '%" . strtoupper($_GET['AUSSTELLUNGSDATUM']) . "%'";
  }

  if (!empty($conditions)) {
    $searchPatientSql .= " WHERE " . implode(' AND ', $conditions);
  }
}

//create PATIENT
if (!empty($_GET['action']) && $_GET['action'] == 'create') {
  $createPatientSql = "INSERT INTO Patient(pNachname, pVorname, pPLZ, pOrt, pStrasse, Gebdat, ArztID, Diagnosse, AusstellungsDatum) VALUES('" . $_POST['PNACHNAME'] . "', '"  . $_POST['PVORNAME'] . "', '" . $_POST['PPLZ'] . "', '" . $_POST['PORT'] . "', '" . $_POST['PSTRASSE'] . "', to_date('" . $_POST['GEBDAT'] . "', 'dd-mm-yyyy'),'" . $_POST['ARZTID'] . "','" . $_POST['DIAGNOSSE'] . "', to_date('" . $_POST['AUSSTELLUNGSDATUM'] . "', 'dd-mm-yyyy'))";

  $stmt = oci_parse($conn, $createPatientSql);
  oci_execute($stmt);

  header("Location: ?");
}


//delete PATIENT
if (!empty($_GET['action']) && $_GET['action'] == 'delete') {
  $deletePatientSql = "DELETE FROM Patient WHERE PATIENTID = " . $_GET['PATIENTID'];

  $stmt = oci_parse($conn, $deletePatientSql);
  oci_execute($stmt);

  header("Location: ?");
}


//update PATIENT
if (!empty($_GET['action']) && $_GET['action'] == 'update') {
  $getRowForUpdate = "SELECT * FROM Patient WHERE PATIENTID = " . $_GET['PATIENTID'];
  $stmt = oci_parse($conn, $getRowForUpdate);
  oci_execute($stmt);
  $rowForUpdate = oci_fetch_array($stmt, OCI_ASSOC);

  if (!empty($_POST)) {
    $updatePatientSql = "UPDATE Patient SET PNACHNAME = '" . $_POST['PNACHNAME'] . "', PVORNAME = '" . $_POST['PVORNAME'] . "', PPLZ = '" . $_POST['PPLZ'] . "', PORT = '" . $_POST['PORT'] . "', PSTRASSE = '" . $_POST['PSTRASSE'] . "', GEBDAT = to_date('" . $_POST['GEBDAT'] . "', 'dd-mm-yyyy'), ARZTID = '" . $_POST['ARZTID'] . "', DIAGNOSSE = '" . $_POST['DIAGNOSSE'] . "', AUSSTELLUNGSDATUM = to_date('" . $_POST['AUSSTELLUNGSDATUM'] . "', 'dd-mm-yyyy') WHERE PATIENTID = " . $_GET['PATIENTID'];

    $stmt = oci_parse($conn, $updatePatientSql);
    oci_execute($stmt);

    header("Location: ?");
  }
}
//add order for beautify
$searchPatientSql .= " ORDER BY PATIENTID";


//parse and execute sql statement
$stmt = oci_parse($conn, $searchPatientSql);
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
          <li class="active">
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
            <a href="Rechnung.php">Rechnung</a>
          </li>
      </div>

      <div class="col-md-9">



<!-- navigation -->
        <ol class="breadcrumb">
          <li><a href="index.php">Massage Praxis</a></li>
          <li class="active">Patient</li>
        </ol>
<!-- Haupt Panel mit Tabbelle -->
        <div class="panel panel-default">
          <div class="panel-body">
<!-- Tabelle Panel -->
            <form id=1 method='get'>
              <input type="hidden" name="action" value="search">
<!-- Refresh Taste-->
              <input class="btn btn-link" type="submit" value="Refresh" />



 <!-- Haupt Tabelle-->
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th width="50">PatientID</th>
                    <th width="50">pNachname</th>
                    <th width="50">pVorname</th>
                    <th width="50">pPLZ</th>
                    <th width="50">pOrt</th>
                    <th width="50">pStrasse</th>
                    <th width="50">Gebdat (dd-mm-yyyy)</th>    
                    <th width="50">ArztID</th>    
                    <th width="50">Diagnosse</th>
                    <th width="50">AusstellungsDatum (dd-mm-yyyy)</th>
                    <th width="50">update</th>   
                    <th width="50">delete</th>        
                  </tr>
                </thead>
                <tbody>

  <!-- Search Zeilen-->
                  <tr>
                    <td><input name='PATIENTID' value='<?= @$_GET['PATIENTID'] ?: '' ?>' style="width:50%" /></td>
                    <td><input name='PNACHNAME' value='<?= @$_GET['PNACHNAME'] ?: '' ?>' style="width:100%" /></td>
                    <td><input name='PVORNAME' value='<?= @$_GET['PVORNAME'] ?: '' ?>' style="width:100%" /></td>
                    <td><input name='PPLZ' value='<?= @$_GET['PPLZ'] ?: '' ?>' style="width:90%" /></td>
                    <td><input name='PORT' value='<?= @$_GET['PORT'] ?: '' ?>' style="width:70%" /></td>
                    <td><input name='PSTRASSE' value='<?= @$_GET['PSTRASSE'] ?: '' ?>' style="width:100%" /></td>
                    <td><input name='GEBDAT' value='<?= @$_GET['GEBDAT'] ?: '' ?>' style="width:100%" /></td>  
                    <td><input name='ARZTID' value='<?= @$_GET['ARZTID'] ?: '' ?>' style="width:90%" /></td>
                    <td><input name='DIAGNOSSE' value='<?= @$_GET['DIAGNOSSE'] ?: '' ?>' style="width:100%" /></td>
                    <td><input name='AUSSTELLUNGSDATUM' value='<?= @$_GET['AUSSTELLUNGSDATUM'] ?: '' ?>' style="width:100%" /></td>
                    <td></td>
                    <td></td>
                  </tr>

                  <!-- Ausgeben zeilen mit inf von Daten -->
                  <?php while($row = oci_fetch_array($stmt, OCI_ASSOC)): ?>
                  <tr>
                    <td><?= $row['PATIENTID'] ?></td>
                    <td><?= $row['PNACHNAME'] ?></td>
                    <td><?= $row['PVORNAME'] ?></td>
                    <td><?= $row['PPLZ'] ?></td>
                    <td><?= $row['PORT'] ?></td>
                    <td><?= $row['PSTRASSE'] ?></td>
                    <td><?= $row['GEBDAT'] ?></td>
                    <td><?= $row['ARZTID'] ?></td>
                    <td><?= $row['DIAGNOSSE'] ?></td>
                    <td><?= $row['AUSSTELLUNGSDATUM'] ?></td>
                    <td><a href="?action=update&PATIENTID=<?= $row["PATIENTID"] ?>">update</a></td>
                    <td><a href="?action=delete&PATIENTID=<?= $row["PATIENTID"] ?>">delete</a></td>
                  </tr>
                  <?php endwhile; ?>

                </tbody>
              </table>
            </form>
          </div>
        </div>
        

        
        <?php  oci_free_statement($stmt); ?>


  <!-- Zweite Panel Form -->
        <div class="panel panel-default">
          <div class="panel-body">
<!-- Form -->
            <form class="form-horizontal" action="?action=<?=isset($_GET['action']) ? $_GET['action'] . '&PATIENTID=' . $_GET['PATIENTID'] : 'create'?>" method='post'>

<!--  PATIENT label + input -->
                <div class="form-group">
                <label for="PATIENTID" class="col-sm-2 control-label">PATIENTID</label>
                <div class="col-sm-10">
                  <input class="form-control" name='PATIENTID' value="<?=isset($rowForUpdate) ? $rowForUpdate['PATIENTID'] : ''?>" disabled/>
                </div>
              </div>

              <!-- ÑÑ‚Ñ€Ð¾ÐºÐ° Ñ PNACHNAME label + input -->
              <div class="form-group">
                <label for="PATIENTID" class="col-sm-2 control-label">PNACHNAME</label>
                <div class="col-sm-10">
                  <input class="form-control" name='PNACHNAME' value="<?=isset($rowForUpdate) ? $rowForUpdate['PNACHNAME'] : ''?>" />
                </div>
              </div>

<!--PVORNAME label + input -->
              <div class="form-group">
                <label for="PATIENTID" class="col-sm-2 control-label">PVORNAME</label>
                <div class="col-sm-10">
                  <input class="form-control" name='PVORNAME' value="<?=isset($rowForUpdate) ? $rowForUpdate['PVORNAME'] : ''?>" />
                </div>
              </div>

<!-- PPLZ label + input -->
              <div class="form-group">
                <label for="PATIENTID" class="col-sm-2 control-label">PPLZ</label>
                <div class="col-sm-10">
                  <input class="form-control" name='PPLZ' value="<?=isset($rowForUpdate) ? $rowForUpdate['PPLZ'] : ''?>" />
                </div>
              </div>

<!-- PORT label + input -->
              <div class="form-group">
                <label for="PATIENTID" class="col-sm-2 control-label">PORT</label>
                <div class="col-sm-10">
                  <input class="form-control" name='PORT' value="<?=isset($rowForUpdate) ? $rowForUpdate['PORT'] : ''?>" />
                </div>
              </div>

<!-- PSTRASSE label + input -->
              <div class="form-group">
                <label for="PATIENTID" class="col-sm-2 control-label">PSTRASSE</label>
                <div class="col-sm-10">
                  <input class="form-control" name='PSTRASSE' value="<?=isset($rowForUpdate) ? $rowForUpdate['PSTRASSE'] : ''?>" />
                </div>
              </div>


  <!-- GEBDAT label + input -->
              <div class="form-group">
                <label for="PATIENTID" class="col-sm-2 control-label">GEBDAT</label>
                <div class="col-sm-10">
                  <input class="form-control" name='GEBDAT' value="<?=isset($rowForUpdate) ? $rowForUpdate['GEBDAT'] : ''?>" />
                </div>
              </div>
<!--  ARZTIDlabel + input -->
                <div class="form-group">
                <label for="PATIENTID" class="col-sm-2 control-label">ARZTID</label>
                <div class="col-sm-10">
                  <input class="form-control" name='ARZTID' value="<?=isset($rowForUpdate) ? $rowForUpdate['ARZTID'] : ''?>" />
                </div>
              </div>

<!--  DIAGNOSSE label + input -->
              <div class="form-group">
                <label for="PATIENTID" class="col-sm-2 control-label">DIAGNOSSE</label>
                <div class="col-sm-10">
                  <input class="form-control" name='DIAGNOSSE' value="<?=isset($rowForUpdate) ? $rowForUpdate['DIAGNOSSE'] : ''?>" />
                </div>
              </div>

<!-- AUSSTELLUNGSDATUM label + input -->
              <div class="form-group">
                <label for="PATIENTID" class="col-sm-2 control-label">AUSSTELLUNGSDATUM</label>
                <div class="col-sm-10">
                  <input class="form-control" name='AUSSTELLUNGSDATUM' value="<?=isset($rowForUpdate) ? $rowForUpdate['AUSSTELLUNGSDATUM'] : ''?>" />
                </div>
              </div>
<!-- Zeilen werfen und senden -->
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
