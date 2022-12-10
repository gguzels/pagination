<!DOCTYPE html>
<html lang="en">
<head>
  <title>Fan Club List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    
<?php
    
    $genders = [1 => 'PHD', 2 => 'Post Graduate', 3 => 'Graduate', 4 => 'HSC', 5 => 'SSC', 6 => 'JSC'];
    
    
    $servername = "localhost";
    $username = "jago_fanclub";
    $password = "clubFanJago2018";
    $dbname = "jago_fanclub";
    
    $limit = 50;
    
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    $s = $db->prepare("SELECT * FROM club_fans");
    $s->execute();
    $allResp = $s->fetchAll(PDO::FETCH_ASSOC);
    // echo '<pre>';
    // var_dump($allResp);
    $total_results = $s->rowCount();
    $total_pages = ceil($total_results/$limit);
    
    if (!isset($_GET['page'])) {
        $page = 1;
    } else{
        $page = $_GET['page'];
    }


    $start = ($page-1)*$limit;

    $stmt = $db->prepare("SELECT * FROM club_fans ORDER BY id DESC LIMIT $start, $limit");
    $stmt->execute();

    // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    
    $results = $stmt->fetchAll();
       
    $conn = null;
    
    // var_dump($results);
    
    $no = $page > 1 ? $start+1 : 1;


?>

<div class="container">
  <h2 class="">Fan Club List <span class="badge">Total: <?= $total_results; ?></span></h2>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Gender</th>
        <th>Education</th>
        <th>Ref Person</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach($results as $result){?>
          <tr>
            <td><?= $no; ?></td>
            <td><?= $result->name; ?></td>
            <td><?= $result->email; ?></td>
            <td><?= $result->phone; ?></td>
            <td><?= $result->gender == 1 ? 'Male' : 'Female'; ?></td>
            <td><?= $genders[$result->education]; ?></td>
            <?php
                $refPerson = $db->prepare("SELECT name FROM club_fans where id=$result->reference_id");
                $refPerson->execute();
                $refPerson = $refPerson->fetch(PDO::FETCH_OBJ);
            
            ?>
            <td><?= $refPerson->name;?></td>
          </tr>
        <?php $no++; } ?>
    </tbody>
  </table>
    <ul class="pagination">
        <li><a href="?page=1">First</a></li>
        
        <?php for($p=1; $p<=$total_pages; $p++){?>
            
            <li class="<?= $page == $p ? 'active' : ''; ?>"><a href="<?= '?page='.$p; ?>"><?= $p; ?></a></li>
        <?php }?>
        <li><a href="?page=<?= $total_pages; ?>">Last</a></li>
    </ul> 
</div>

</body>
</html>