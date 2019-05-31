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
$searchArztSql = "SELECT * FROM Arzt";


//search Arzt
if (!empty($_GET['action']) && $_GET['action'] == 'search') {
  //prepare conditions for query if they was passed
  if (!empty($_GET['ARZTID'])) {
    $conditions[] = "ARZTID = " . $_GET['ARZTID'];
  }

  if (!empty($_GET['ANACHNAME'])) {
    $conditions[] = "UPPER(ANACHNAME) like '%" . strtoupper($_GET['ANACHNAME']) . "%'";
  }

  if (!empty($_GET['AVORNAME'])) {
    $conditions[] = "UPPER(AVORNAME) like '%" . strtoupper($_GET['AVORNAME']) . "%'";
  }

 if (!empty($_GET['AFACHGEBIET'])) {
    $conditions[] = "UPPER(AFACHGEBIET) like '%" . strtoupper($_GET['AFACHGEBIET']) . "%'";
  }

  if (!empty($conditions)) {
    $searchArztSql .= " WHERE " . implode(' AND ', $conditions);
  }
}

//create Arzt
if (!empty($_GET['action']) && $_GET['action'] == 'create') {
  $createArztSql = "INSERT INTO Arzt (aNachname, aVorname, aFachgebiet) VALUES('" . $_POST['ANACHNAME'] . "','" . $_POST['AVORNAME'] . "', '" . $_POST['AFACHGEBIET'] . "')";

  $stmt = oci_parse($conn, $createArztSql);
  oci_execute($stmt);

  header("Location: ?");
}


//delete Arzt
if (!empty($_GET['action']) && $_GET['action'] == 'delete') {
  $deleteArztSql = "DELETE FROM Arzt WHERE ARZTID = " . $_GET['ARZTID'];

  $stmt = oci_parse($conn, $deleteArztSql);
  oci_execute($stmt);

  header("Location: ?");
}




//update Arzt
if (!empty($_GET['action']) && $_GET['action'] == 'update') {
  $getRowForUpdate = "SELECT * FROM Arzt WHERE ARZTID = " . $_GET['ARZTID'];
  $stmt = oci_parse($conn, $getRowForUpdate);
  oci_execute($stmt);
  $rowForUpdate = oci_fetch_array($stmt, OCI_ASSOC);

  if (!empty($_POST)) {
    $updateArztSql = "UPDATE Arzt SET ANACHNAME = '" . $_POST['ANACHNAME'] . "', AVORNAME = '" . $_POST['AVORNAME'] . "', AFACHGEBIET = '" . $_POST['AFACHGEBIET'] . "' WHERE ARZTID = " . $_GET['ARZTID'];

    $stmt = oci_parse($conn, $updateArztSql);
    oci_execute($stmt);

    header("Location: ?");
  }
}
//add order for beautify
$searchArztSql .= " ORDER BY ARZTID";


//parse and execute sql statement
$stmt = oci_parse($conn, $searchArztSql);
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
          <li class="active">
            <a href="Arzt.php">Arzt</a>
          </li>
          <li>
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
          <li class="active">Arzt</li>
        </ol>
<!-- haupt panel mit Tabell  -->
        <div class="panel panel-default">
          <div class="panel-body">
<!-- Panel Tabelle-->
            <form id=1 method='get'>
              <input type="hidden" name="action" value="search">
<!-- Refresch drucken -->
              <input class="btn btn-link" type="submit" value="Refresh" />



 <!-- Haupt Tabelle -->
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="th1" width="50">ArztID</th>
                    <th width="100">aNachname</th>
                    <th width="100">aVorname</th>
                    <th width="100">aFachgebiet</th>  
                    <th width="50">update</th> 
                    <th width="50">delete</th>      
                  </tr>
                </thead>
                <tbody>

  <!-- Search linie-->
                  <tr>
                    <td><input name='ARZTID' value='<?= @$_GET['ARZTID'] ?: '' ?>' style="width:70%" /></td>
                    <td><input name='ANACHNAME' value='<?= @$_GET['ANACHNAME'] ?: '' ?>' style="width:70%" /></td>
                    <td><input name='AVORNAME' value='<?= @$_GET['AVORNAME'] ?: '' ?>' style="width:70%" /></td>
                    <td><input name='AFACHGEBIET' value='<?= @$_GET['AFACHGEBIET'] ?: '' ?>' style="width:70%" /></td>
                    <td></td>
                    <td></td>
                  </tr>

                  <!-- Ausgeben linie (Informationen) von Daten -->
                  <?php while($row = oci_fetch_array($stmt, OCI_ASSOC)): ?>
                  <tr>
                    <td class="th1"><?= $row['ARZTID'] ?></td>
                    <td class="th1"><?= $row['ANACHNAME'] ?></td>
                    <td class="th1"><?= $row['AVORNAME'] ?></td>
                    <td class="th1"><?= $row['AFACHGEBIET'] ?></td>
                    <td><a href="?action=update&ARZTID=<?= $row["ARZTID"] ?>">update</a></td>
                    <td><a href="?action=delete&ARZTID=<?= $row["ARZTID"] ?>">delete</a></td>
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
            <form class="form-horizontal" action="?action=<?=isset($_GET['action']) ? $_GET['action'] . '&ARZTID=' . $_GET['ARZTID'] : 'create'?>" method='post'>

<!-- Zeile ARZTID label + input -->
 <div class="form-group">
                <label for="ARZTID" class="col-sm-2 control-label">ARZTID</label>
                <div class="col-sm-10">
                  <input class="form-control" name='ARZTID' value="<?=isset($rowForUpdate) ? $rowForUpdate['ARZTID'] : ''?>" disabled/>
                </div>
              </div>

              <!-- Zeile ANACHANME label + input -->
              <div class="form-group">
                <label for="ARZTID" class="col-sm-2 control-label">ANACHNAME</label>
                <div class="col-sm-10">
                  <input class="form-control" name='ANACHNAME' value="<?=isset($rowForUpdate) ? $rowForUpdate['ANACHNAME'] : ''?>" />
                </div>
              </div>
              
              <!-- Zeile AVORNAME label + input -->
              <div class="form-group">
                <label for="ARZTID" class="col-sm-2 control-label">AVORNAME</label>
                <div class="col-sm-10">
                  <input class="form-control" name='AVORNAME' value="<?=isset($rowForUpdate) ? $rowForUpdate['AVORNAME'] : ''?>" />
                </div>
              </div>

            
              <!-- Zeile AFACHGEBIET label + input -->
              <div class="form-group">
                <label for="ARZTID" class="col-sm-2 control-label">AFACHGEBIET</label>
                <div class="col-sm-10">
                  <input class="form-control" name='AFACHGEBIET' value="<?=isset($rowForUpdate) ? $rowForUpdate['AFACHGEBIET'] : ''?>" />
                </div>
              </div>

<!-- Zeile Werfen und senden Form -->
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
