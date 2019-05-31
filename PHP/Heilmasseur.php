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

//preparing sql query for heilamsseur search

$conditions = array();
$searchHeilmasseurSql = "SELECT * FROM Heilmasseur";


//search Heilmasseur
if (!empty($_GET['action']) && $_GET['action'] == 'search') {
  //prepare conditions for query if they was passed
  if (!empty($_GET['HEILMASSEURID'])) {
    $conditions[] = "HEILMASSEURID = " . $_GET['HEILMASSEURID'];
  }

  if (!empty($_GET['HNACHANME'])) {
    $conditions[] = "UPPER(HNACHNAME) like '%" . strtoupper($_GET['HNACHNAME']) . "%'";
  }

  if (!empty($_GET['HVORNAME'])) {
    $conditions[] = "UPPER(HVORNAME) like '%" . strtoupper($_GET['HVORNAME']) . "%'";
  }

 if (!empty($_GET['ALT'])) {
    $conditions[] = "UPPER(ALT) like '%" . strtoupper($_GET['ALT']) . "%'";
  }

 if (!empty($_GET['TNUMMER'])) {
    $conditions[] = "TNUMMER = " . $_GET['TNUMMER'];
  }

 if (!empty($_GET['LEITETHEILMASSEURID'])) {
    $conditions[] = "LEITETHEILMASSEURID = " . $_GET['LEITETHEILMASSEURID'];
  }


  if (!empty($conditions)) {
    $searchHeilmasseurSql .= " WHERE " . implode(' AND ', $conditions);
  }
}



//create HEILMASSEUR
if (!empty($_GET['action']) && $_GET['action'] == 'create') {
  $createHeilmasseurSql = "INSERT INTO Heilmasseur(hNachname, hVorname, Alt, Tnummer, leitetHeilmasseurID) VALUES('" . $_POST['HNACHNAME'] . "', '"  . $_POST['HVORNAME'] . "', '" . $_POST['ALT'] . "', '" . $_POST['TNUMMER'] . "','" . $_POST['LEITETHEILMASSEURID'] . "')";

  $stmt = oci_parse($conn, $createHeilmasseurSql);
  oci_execute($stmt);

  header("Location: ?");
}

//delete HEILMASSEUR
if (!empty($_GET['action']) && $_GET['action'] == 'delete') {
  $deleteHeilmasseurSql = "DELETE FROM Heilmasseur WHERE HEILMASSEURID = " . $_GET['HEILMASSEURID'];

  $stmt = oci_parse($conn, $deleteHeilmasseurSql);
  oci_execute($stmt);

  header("Location: ?");
}

//update HEILMASSEUR
if (!empty($_GET['action']) && $_GET['action'] == 'update') {
  $getRowForUpdate = "SELECT * FROM Heilmasseur WHERE HEILMASSEURID = " . $_GET['HEILMASSEURID'];
  $stmt = oci_parse($conn, $getRowForUpdate);
  oci_execute($stmt);
  $rowForUpdate = oci_fetch_array($stmt, OCI_ASSOC);

  if (!empty($_POST)) {
    $updateHeilmasseurSql = "UPDATE Heilmasseur SET HNACHNAME = '" . $_POST['HNACHNAME'] . "', HVORNAME = '" . $_POST['HVORNAME'] . "', ALT = '" . $_POST['ALT'] . "', TNUMMER = '" . $_POST['TNUMMER'] . "', LEITETHEILMASSEURID = '" . $_POST['LEITETHEILMASSEURID'] . "' WHERE HEILMASSEURID = " . $_GET['HEILMASSEURID'];

    $stmt = oci_parse($conn, $updateHeilmasseurSql);
    oci_execute($stmt);

    header("Location: ?");
  }
}
//add order for beautify
$searchHeilmasseurSql .= " ORDER BY HEILMASSEURID";


//parse and execute sql statement
$stmt = oci_parse($conn, $searchHeilmasseurSql);
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
          </li>
            <a href="Patient.php">Patient</a>
          </li>
          <li>
          <li class="active">
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
          <li class="active">Heilmasseur</li>
        </ol>
<!-- Haupt panel mit tabelle -->
        <div class="panel panel-default">
          <div class="panel-body">
<!-- Tabelle Panel -->
            <form id=1 method='get'>
              <input type="hidden" name="action" value="search">
<!-- Refresh Taste -->
              <input class="btn btn-link" type="submit" value="Refresh" />



 <!-- Haupt Tabelle -->
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th width="50">HeilmassuerID</th>
                    <th width="200">hNachname</th>
                    <th width="200">hVorname</th>   
                    <th width="50">Alt</th>    
                    <th width="200">Tnummer</th>
                    <th width="200">leitetHeilmasseurID</th>
                    <th width="200">update</th>   
                    <th width="50">delete</th>        
                  </tr>
                </thead>
                <tbody>

  <!-- Search zeile-->
                  <tr>
                    <td><input name='HEILMASSEURID' value='<?= @$_GET['HEILMASSEURID'] ?: '' ?>' style="width:70%" /></td>
                    <td><input name='HNACHNAME' value='<?= @$_GET['HNACHNAME'] ?: '' ?>' style="width:100%" /></td>
                    <td><input name='HVORNAME' value='<?= @$_GET['HVORNAME'] ?: '' ?>' style="width:100%" /></td>
                    <td><input name='ALT' value='<?= @$_GET['ALT'] ?: '' ?>' style="width:100%" /></td>
                    <td><input name='TNUMMER' value='<?= @$_GET['TNUMMER'] ?: '' ?>' style="width:100%" /></td>
                    <td><input name='LEITETHEILMASSEURID' value='<?= @$_GET['LEITETHEILMASSEURID'] ?: '' ?>' style="width:100%" /></td>
                    <td></td>
                    <td></td>
                  </tr>

                  <!-- Ausgeben zeilen (Informationen) von Daten-->
                  <?php while($row = oci_fetch_array($stmt, OCI_ASSOC)): ?>
                  <tr>
                    <td><?= $row['HEILMASSEURID'] ?></td>
                    <td><?= $row['HNACHNAME'] ?></td>
                    <td><?= $row['HVORNAME'] ?></td>
                    <td><?= $row['ALT'] ?></td>
                    <td><?= $row['TNUMMER'] ?></td>
                    <td><?= $row['LEITETHEILMASSEURID'] ?></td>
                    <td><a href="?action=update&HEILMASSEURID=<?= $row["HEILMASSEURID"] ?>">update</a></td>
                    <td><a href="?action=delete&HEILMASSEURID=<?= $row["HEILMASSEURID"] ?>">delete</a></td>
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
<!--Form -->
            <form class="form-horizontal" action="?action=<?=isset($_GET['action']) ? $_GET['action'] . '&HEILMASSEURID=' . $_GET['HEILMASSEURID'] : 'create'?>" method='post'>

<!-- Zeile HEILMASSEURID label + input -->
                <div class="form-group">
                <label for="HEILMASSEURID" class="col-sm-2 control-label">HEILMASSEURID</label>
                <div class="col-sm-10">
                  <input class="form-control" name='HEILMASSEURID' value="<?=isset($rowForUpdate) ? $rowForUpdate['HEILMASSEURID'] : ''?>" disabled/>
                </div>
              </div>

              <!-- Zeile HNACHNAME label + input -->
              <div class="form-group">
                <label for="HEILMASSEURID" class="col-sm-2 control-label">HNACHNAME</label>
                <div class="col-sm-10">
                  <input class="form-control" name='HNACHNAME' value="<?=isset($rowForUpdate) ? $rowForUpdate['HNACHNAME'] : ''?>" />
                </div>
              </div>

<!-- Zeile HVORNAME label + input -->
              <div class="form-group">
                <label for="HEILMASSEURID" class="col-sm-2 control-label">HVORNAME</label>
                <div class="col-sm-10">
                  <input class="form-control" name='HVORNAME' value="<?=isset($rowForUpdate) ? $rowForUpdate['HVORNAME'] : ''?>" />
                </div>
              </div>

  <!--Zeile ALT + input -->
                <div class="form-group">
                <label for="HEILMASSEURID" class="col-sm-2 control-label">ALT</label>
                <div class="col-sm-10">
                  <input class="form-control" name='ALT' value="<?=isset($rowForUpdate) ? $rowForUpdate['ALT'] : ''?>" />
                </div>
              </div>


<!-- Zeile TNUMMER label + input -->
              <div class="form-group">
                <label for="HEILMASSEURID" class="col-sm-2 control-label">TNUMMER</label>
                <div class="col-sm-10">
                  <input class="form-control" name='TNUMMER' value="<?=isset($rowForUpdate) ? $rowForUpdate['TNUMMER'] : ''?>" />
                </div>
              </div>

<!-- Zeile LEITETHEILMASSEURID label + input -->
              <div class="form-group">
                <label for="HEILMASSEURID" class="col-sm-2 control-label">LEITETHEILMASSEURID</label>
                <div class="col-sm-10">
                  <input class="form-control" name='LEITETHEILMASSEURID' value="<?=isset($rowForUpdate) ? $rowForUpdate['LEITETHEILMASSEURID'] : ''?>" />
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
