
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
                <h3 class="card-title">Order Listing</h3>
              </div>
                <?php 
                if (!empty($_GET['pageno'])){
                  $pageno = $_GET['pageno'];
                }else{
                  $pageno = 1;
                }
                $numOfrecs = 2;
                $offset = ($pageno - 1)* $numOfrecs;

                $stmt = $pdo->prepare("SELECT * FROM sale_order_detail WHERE sale_order_id=".$_GET['id']);
                  $stmt->execute();
                  $rawResult = $stmt->fetchAll();
                  $total_pages = ceil(count($rawResult) / $numOfrecs);

                  $stmt = $pdo->prepare("SELECT * FROM sale_order_detail WHERE sale_order_id=".$_GET['id']." LIMIT $offset,$numOfrecs");
                  $stmt->execute();
                  $result = $stmt->fetchAll();

               ?>
              <!-- /.card-header -->
              <div class="card-body">
                <div>
                <a href="order_list.php" type="button" class="btn btn-secondary">Back</a>
              </div> <br>

                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Product</th>
                      <th>Quantity</th>
                      <th>Order Date</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                       <?php 
                    if ($result) {
                      $i = 1;
                      foreach ($result as $value) { ?>
                        <?php 
                        $pStmt = $pdo->prepare("SELECT * FROM products WHERE id=".$value['product_id']);
                        $pStmt->execute();
                        $pResult = $pStmt->fetchAll(); 
                         
                      ?> 

                        <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo escape($pResult[0]['name']); ?></td>
                          <td><?php echo escape($value['quantity']); ?></td>
                          <td><?php echo escape(date('Y-m-d',strtotime($value['order_date']))) ?></td>
                    </tr>

                  <?php 
                      $i++;
                    }
                  }
                  ?>
                   
                  </tbody>
                </table> <br>
                 <nav aria-label="Page navigation example" style="float:right;margin-right: 0px">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?id=<?php echo $_GET['id'] ?>&pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno <= 1){ echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno <= 1) {echo '#';}else{ echo "?id=".$_GET['id']."$pageno=".($pageno-1);}?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno >= $total_pages) {echo '#';}else{ echo  "?id=".$_GET['id']."&pageno=".($pageno+1);}?>">Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?id=<?php echo $_GET['id'] ?>&pageno=<?php echo $total_pages?>">Last</a></li>
                  </ul>
                </nav>

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