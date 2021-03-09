<?php include('header.php') ?>

<?php 

require 'config/config.php';

$stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
$stmt->execute();
$result = $stmt->fetchAll();


foreach ($result as $key => $value) {
$categoryId = $result[0]['category_id']; 
$stmtcat = $pdo->prepare("SELECT * FROM categories WHERE id=$categoryId");
$stmtcat->execute();
$catResult[]= $stmtcat->fetchAll();
}

?>
<!--================Single Product Area =================-->
<div class="product_image_area">
  <div class="container">
    <div class="row s_product_inner">
      <div class="col-lg-6">
        <div class="">
          <div class="single-prd-item">
            <img class="img-fluid w-100" src="admin/images/<?php echo $result[0]['image'] ?>" alt="">
          </div>
        </div>
      </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text">
          <h3><?php echo $result[0]['name'] ?></h3>

          <h2><?php echo $result[0]['price'] ?></h2>
          <ul class="list">
            <li><a class="active" href="#"><span>Category</span> : <?php echo ($catResult[$key][0]['name']); ?></a></li>
            <li><a href="#"><span>Availibility</span> : In Stock</a></li>
          </ul>
          <p><?php echo $result[0]['description'] ?></p>
          <div class="product_count">
            <label for="qty">Quantity:</label>
            <input type="text" name="qty" id="sst" maxlength="12" value="<?php echo $result[0]['quantity'] ?>" title="Quantity:" class="input-text qty">
            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
             class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
             class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
          </div>
          <div class="card_area d-flex align-items-center">
            <a class="primary-btn" href="#">Add to Cart</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
