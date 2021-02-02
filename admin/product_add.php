
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

  if(empty($_POST['name']) || empty($_POST['description']) || empty($_POST['category']) 
      || empty($_POST['quantity']) || empty($_POST['price']) || empty($_FILES['image'])) {
    if(empty($_POST['name'])){
      $nameError = 'Category cannot be null';
    }

    if(empty($_POST['description'])){
      $descriptionError = 'Description cannot be null';
    }
    if(empty($_POST['category'])){
      $catError = 'Category cannot be null';
    }

    if(empty($_POST['quantity'])){
      $qtyError = 'Quantity cannot be null';
    }elseif(is_numeric($_POST['quantity']) !=1){
      $qtyError = 'Quantity should be integer value';
    }

    if(empty($_POST['price'])){
      $priceError = 'Price cannot be null';
    }elseif(is_numeric($_POST['price']) !=1){
      $priceError = 'Price should be integer value';
    }

    if(empty($_FILES['image'])){
      $imageError = 'Image cannot be null';
    }

  }else{
    $file = 'images/'.($_FILES['image']['name']);
    $imageType = pathinfo($file,PATHINFO_EXTENSION);

    if($imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'png') {
      echo "<script>alert('Image should be jpg,jpeg,png');</script>";
    }else{
      $name = $_POST['name'];
      $description = $_POST['description'];
      $category = $_POST['category'];
      $qty = $_POST['quantity'];
      $price = $_POST['price'];
      $image = $_FILES['image']['name'];

      move_uploaded_file($_FILES['image']['tmp_name'], $file);

      $stmt = $pdo->prepare("INSERT INTO products(name,description,category_id,price,quantity,image)
        VALUES (:name,:description,:category,:price,:quantity,:image)");
      $result = $stmt->execute(
        array (':name'=>$name,':description'=>$description,':category'=>$category,':price'=>$price,':quantity'=>$qty,':image'=>$image));

        if($result) {
          echo "<script>alert('Product is added');window.location.href='index.php';</script>";
        }
      

    }
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
              <div class="card-body">
                <form class="" action="product_add.php" method="post" enctype="multipart/form-data">
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="form-group">
                    <label for="">Name</label> <p class="text-danger"><?php echo empty($nameError) ? '' : '*'. $nameError ?></p>
                    <input type="text" class="form-control" name="name" value="">
                  </div>

                  <div class="form-group">
                    <label for="">Description</label><p class="text-danger"><?php echo empty($descriptionError) ? '' : '*'. $descriptionError ?></p>
                    <textarea class="form-control" name="description" rows="8" cols="80"></textarea>
                  </div>

                  <div class="form-group">

                    <?php 
                      $catStmt=$pdo->prepare("SELECT * FROM categories");
                      $catStmt->execute();
                      $catResult = $catStmt->fetchAll();
                    ?>
                    <label for="">Category</label><p class="text-danger"><?php echo empty($catError) ? '' : '*'. $catError ?></p>
                   <select class="form-control" name="category">
                     <option value="">SELECT CATEGORY</option>
                     <?php foreach ($catResult as $value) { ?>
                       <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                    <?php } ?>
                   </select>
                  </div>

                  <div class="form-group">
                    <label for="">Quantity</label><p class="text-danger"><?php echo empty($qtyError) ? '' : '*'. $qtyError ?></p>
                    <input type="number" name="quantity" class="form-control" value="">
                  </div>

                  <div class="form-group">
                    <label for="">Price</label><p class="text-danger"><?php echo empty($priceError) ? '' : '*'. $priceError ?></p>
                    <input type="number" name="price" class="form-control" value="">
                  </div>

                  <div class="form-group">
                    <label for="">Image</label><p class="text-danger"><?php echo empty($imageError) ? '' : '*'. $imageError ?></p>
                    <input type="file" name="image" class="" value="">
                  </div>


                  <div class="form-group">
                    <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                    <a href="index.php" class="btn btn-warning">Back</a>
                  </div>
                </form>
              </div>
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