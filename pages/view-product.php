<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/viewproduct1.css">
    <link rel="stylesheet" href="../style/navandfoot.css">
    <title>Document</title>
</head>

<body>
    <div class="register">
        <p>Become a Seller? <a href="register.php">Register Now</a></p>
    </div>

    <?php
        include("../components/nav.php");
    ?>

    <main class="container">
        <div class="content">
            <div class="selected-product">
                <div class="breadcrumbs">
                    <span>Home</span>
                    <img src="../assets/arrow-icon.png" alt="">
                    <span>Products</span>
                    <img src="../assets/arrow-icon.png" alt="">
                    <span>Men's Fashion</span>
                    <img src="../assets/arrow-icon.png" alt="">
                    <span class="selected">T-shirts</span>
                </div>

                <div class="main-product">
                    <div class="main-product-images">
                        <div class="image-list">
                            <!-- <div>
                                <img src="https://lookhuman.com/cdn/shop/files/product-giant-468681-3300-athletic_gray-sm.jpg?v=1719001989&width=823" alt="">
                            </div>
                            <div>
                                <img src="https://lookhuman.com/cdn/shop/files/product-giant-468681-6400-charcoal-sm.jpg?v=1716955366&width=823" alt="">
                            </div>
                            <div>
                                <img src="https://lookhuman.com/cdn/shop/files/product-giant-468681-6400-red-sm.jpg?v=1716955367&width=823" alt="">
                            </div> -->
                        </div>
                        <div class="prev-image">
                            <img src="https://t4.ftcdn.net/jpg/03/13/99/15/360_F_313991528_xkWq6AjZIkRu21XCF1jDqRFDx9v93M7r.jpg" alt="">
                        </div>
                    </div>

                    <div class="main-product-info">
                        <div class="product-description">
                            <div class="description">
                                <p class="product-name"></p>
                                <p class="product-price"></p>
                                <p class="product-desc"></p>
                            </div>
                        </div>

                        <div class="product-divider"></div>

                        <div class="product-details">
                            <div>
                                <p>Category</p>
                                <div class="categories">
                                    <div>Men's Fashion</div>
                                </div>
                            </div>

                            <div>
                                <p>Type</p>
                                <div class="types">
                                    <div>Shirt</div>
                                </div>
                            </div>

                            <div class="availability">
                                <p>Available on:</p>
                                <div class="links">
                                    <img class="shopee" src="../assets/shopee.png" alt="">
                                    <img class="lazada" src="../assets/lazada.png" alt="">
                                </div>
                            </div>
                        </div>


                        <!-- <div class="product-store">
                            <div class="store">
                                <div>
                                    <img src="../assets/shopping-sm.png" alt="">
                                    <p>STYL E.BOSS</p>
                                </div>

                                <div>
                                    <img src="../assets/shop.png" alt="">
                                    <p>View Shop</p>
                                </div>
                            </div>

                            <div>
                                <p>
                                    STYL E.BOSS offers a curated selection of trendy, high-quality clothing and accessories designed to let you stand out. From everyday essentials to statement pieces, we’ve got everything you need to express your unique style without breaking the bank.
                                </p>

                                <p>As a proud member of the Taytay Tiangge community, we specialize in Ready-to-Wear (RTW) garments, sourced and crafted with care, ensuring that every piece reflects Taytay’s renowned quality and affordability. Whether you’re dressing for work, a casual day out, or a special occasion, STYL E.BOSS has you covered.</p>
                            </div>
                        </div> -->

                    </div>
                </div>
            </div>

            <div class="products-container">
                <div class="store">
                    <div>
                        <img src="../assets/shopping-sm.png" alt="">
                        <p class="store-name"></p>
                    </div>

                    <div>
                        <img src="../assets/shop-icon.png" alt="">
                        <p class="view-shop">View Shop</p>
                    </div>
                </div>

                <div class="product-divider"></div>

                <div class="store-products">
                    <div class="store-products-header">
                        <p>from the same shop</p>

                        <div>
                            <select class="custom-select categories-select">
                                <option value="All Products">All Categories</option>
                            </select>

                            <select class="custom-select types-select">
                                <option value="All Products">All Products</option>
                            </select>
                        </div>
                    </div>

                    <div class="products">
                    </div>
                </div>

                <div class="pagination">
                    <p class="results"></p>

                    <div class="pages">
                        <!-- <div class="button back-page">
                    <img src="../assets/pagination-right.png" alt="">
                </div>
                <div class="button next-page">
                    <img src="../assets/pagination-next.png" alt="">
                </div> -->
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="top-footer">
            <div class="footer-logo">
                <img src="../assets/tianggeportal.png" alt="">
                <p>Find quality clothes and<br> garments in Taytay Tiangge<br> anytime and anywhere you are!</p>
            </div>

            <div class="footer-info">
                <h4 class="first-category">Information</h4>
                <ul>
                    <li><a href="">About</a></li>
                    <li><a href="">Terms & Conditions</a></li>
                    <li><a href="">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-info">
                <h4 class="second-category">Categories</h4>
                <ul>
                    <li><a href="">Men's Fashion</a></li>
                    <li><a href="">Women's Fashion</a></li>
                    <li><a href="">Kid's</a></li>
                </ul>
                <div class="footer-products-shortcut">
                    <a style="color: #029f6f;" href="">Find More</a> <img src="../assets/greenright.png" alt="">
                </div>
            </div>
            <div class="footer-info">
                <h4 class="third-category">Help & Support</h4>
                <ul>
                    <li><a href="">Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div class="bottom-footer">
            <p>e-Tiangge Portal © 2024.<br>
                All Rights Reserved.</p>
            <img src="../assets/municipalitylogo.png" alt="">
            <img src="../assets/smiletaytay.png" alt="">
        </div>
    </footer>
</body>
<script src="../script/view-product1.js"></script>
<script src="../script/view-product-ui1.js"></script>

</html>