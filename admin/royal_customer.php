
<?php
session_start();
require '../config/config.php';
require '../config/common.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('Location: login.php');
}

if ($_SESSION['role'] != 1) {
  header('Location: login.php');
}

if ($_POST) {
  setcookie('search',$_POST['search'], time() + (86400 * 30), "/");
}else{
  if (empty($_GET['pageno'])) {
    unset($_COOKIE['search']); 
    setcookie('search', null, -1, '/'); 
  }
}

?>

<?php include('header.php') ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Weekly Report</h3>
              </div>
              <?php 
                $stmt = $pdo->prepare("SELECT * FROM sale_orders WHERE total_price > '40000' ORDER BY id DESC");
                $stmt->execute();
                $result = $stmt->fetchAll();
          
              ?>
            
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered" id="d-table">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>UserID</th>
                      <th>Total Amount</th>
                      <th>Order Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    if ($result) {
                      $i = 1;
                      foreach ($result as $value) { ?>

                      <?php 
                        $userStmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['user_id']);
                        $userStmt->execute();
                        $userResult = $userStmt->fetchAll(); 
                         
                      ?> 

                      <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo escape($userResult[0]['name']); ?></td>
                          <td><?php echo escape($value['total_price']); ?></td>
                          <td><?php echo escape(date("Y-m-d",strtotime($value['order_date']))); ?></td>
                    </tr>

                  <?php 
                      $i++;
                    }
                  }
                  ?>
                   
                  </tbody>
                </table> <br>
              </div>
              <!-- /.card-body -->
            </div>
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php include('footer.html') ?>
 <script type="">
   $(document).ready(function() {
    $('#d-table').DataTable();
} );
 </script>