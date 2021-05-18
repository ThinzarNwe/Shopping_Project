<?php include('header.php') ?>

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <?php if (!empty($_SESSION['cart'])):?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                require 'config/config.php';

                                $total = 0;
                                foreach ($_SESSION['cart'] as $key => $qty):
                                $id = str_replace('id','',$key);

                                $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                $total += $result['price'] * $qty;
                            ?>

                             <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="admin/images/<?php echo escape($result['image']) ?>" width="100px" height="100px">
                                        </div>
                                        <div class="media-body">
                                            <p><?php echo escape($result['name']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo escape($result['price']); ?></h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="text" value="<?php echo $qty; ?>" title="Quantity:"
                                            class="input-text qty" readonly="">
                                        
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo escape($result['price'] * $qty); ?></h5>
                                </td>
                                <td>
                                    <a href="cart_item_clear.php?pid=<?php echo $result['id'] ?>" class="primary-btn" style="line-height: 29px;border-radius: 90px;">Clear</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    <h5>Subtotal</h5>
                                </td>
                                <td>
                                    <h5><?php echo $total ?></h5>
                                </td>
                            </tr>
                           
                            <tr class="out_button_area">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                        <a class="gray_btn" href="clearall.php">CLEAR ALL</a>
                                        <a class="primary-btn" href="index.php">Continue Shopping</a>
                                        <a class="gray_btn" href="sale_order.php">ORDER SUBMIT</a>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif ?>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

    <!-- start footer Area -->
<footer class="footer-area section_gap">
<div class="container">
<div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
  <p class="footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
<strong>Copyright &copy; 2020-2021 <a href="#">ThinzarNwe</a>.</strong> All rights reserved.
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
</p>
</div>
</div>
</footer>
    <!-- End footer Area -->

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<!--gmaps Js-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="js/gmaps.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>
