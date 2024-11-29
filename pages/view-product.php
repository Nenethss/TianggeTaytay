<?php 


include_once '../server/fetchproduct.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/reset.css">
    <link rel="stylesheet" href="../style/viewproduct.css">
    <link rel="stylesheet" href="../style/navandfoot.css">
    <title>e-Tiangge Taytay</title>
</head>

<body>
    <div class="register">
        <p>Become a Seller? <a href="register.php">Register Now</a></p>
    </div>
    <nav class="navbar">
        <div class="left-side">
            <a href="#"><img src="../assets/shoppingbag.png" alt=""></a>
            <div class="input-with-icon">
                <img class="search-icon" src="../assets/Vector.png" alt="">
                <input type="text" placeholder="Search for Products...">
            </div>
        </div>
        <div class="right-side">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li class="selected"><a href="products.php">Products</a></li>
                <li><a href="store.php">Store</a></li>
                <li><a href="contact.php">Contact us</a></li>
            </ul>
        </div>
    </nav>

    <main class="container">
        <div class="content">
            <div class="selected-product">
                <div class="breadcrumbs">
                    <span>Home</span>
                    <img src="../assets/arrowrightblack.png" alt="">
                    <span>Products</span>
                    <img src="../assets/arrowrightblack.png" alt="">
                    <span>Men's Fashion</span>
                    <img src="../assets/arrowrightblack.png" alt="">
                    <span class="selected">T-shirts</span>
                </div>

                <div class="main-product">
                    <div class="main-product-images">
                        <div class="image-list">
                            <div class="selected-image">
                                <img src="https://lookhuman.com/cdn/shop/files/product-giant-468681-3300-athletic_gray-sm.jpg?v=1719001989&width=823"
                                    alt="">
                            </div>
                            <div>
                                <img src="https://lookhuman.com/cdn/shop/files/product-giant-468681-6400-charcoal-sm.jpg?v=1716955366&width=823"
                                    alt="">
                            </div>
                            <div>
                                <img src="https://lookhuman.com/cdn/shop/files/product-giant-468681-6400-red-sm.jpg?v=1716955367&width=823"
                                    alt="">
                            </div>
                        </div>
                        <div class="prev-image">
                            <img src="https://lookhuman.com/cdn/shop/files/product-giant-468681-3300-athletic_gray-sm.jpg?v=1719001989&width=823"
                                alt="">
                        </div>
                    </div>

                    <div class="main-product-info">
                        <div class="product-description">
                            <div class="description">
                                <p>One-Life Graphic TShirt</p>
                                <p>&#8369; 399</p>
                                <p>This graphic t-shirt which is perfect for any occasion. Crafted from a soft and
                                    breathable fabric, it offers superior comfort and style. </p>
                            </div>

                            <div class="availability">
                                <p>Available on:</p>
                                <div>
                                    <img src="../assets/shopee.png" alt="">
                                    <img src="../assets/lazada.png" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="product-store">
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
                                    STYL E.BOSS offers a curated selection of trendy, high-quality clothing and
                                    accessories designed to let you stand out. From everyday essentials to statement
                                    pieces, we’ve got everything you need to express your unique style without breaking
                                    the bank.
                                </p>

                                <p>As a proud member of the Taytay Tiangge community, we specialize in Ready-to-Wear
                                    (RTW) garments, sourced and crafted with care, ensuring that every piece reflects
                                    Taytay’s renowned quality and affordability. Whether you’re dressing for work, a
                                    casual day out, or a special occasion, STYL E.BOSS has you covered.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div>
                <div class="related-products products">
                    <p>From the same same shop</p>
                    <div class="product-list">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="../assets/Frame 32 (8).png" />
                            </div>
                            <p>One-Life Graphiic T-Shirt</p>
                            <p>&#8369; <span>399</span></p>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="../assets/Frame 32 (9).png" />
                            </div>
                            <p>One-Life Graphiic T-Shirt</p>
                            <p>&#8369; <span>399</span></p>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="../assets/Frame 32 (10).png" />
                            </div>
                            <p>One-Life Graphiic T-Shirt</p>
                            <p>&#8369; <span>399</span></p>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="../assets/Frame 32 (11).png" />
                            </div>
                            <p>One-Life Graphiic T-Shirt</p>
                            <p>&#8369; <span>399</span></p>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="../assets/Frame 32.png" />
                            </div>
                            <p>One-Life Graphiic T-Shirt</p>
                            <p>&#8369; <span>399</span></p>
                        </div>
                    </div>
                </div>

                <div class="you-may-like products">
                    <p>you may also like</p>
                    <div class="product-list">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="../assets/Frame 32.png" />
                            </div>
                            <p>One-Life Graphiic T-Shirt</p>
                            <p>&#8369; <span>399</span></p>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="../assets/Frame 32 (1).png" />
                            </div>
                            <p>One-Life Graphiic T-Shirt</p>
                            <p>&#8369; <span>399</span></p>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="../assets/Frame 32 (2).png" />
                            </div>
                            <p>One-Life Graphiic T-Shirt</p>
                            <p>&#8369; <span>399</span></p>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="../assets/Frame 32 (3).png" />
                            </div>
                            <p>One-Life Graphiic T-Shirt</p>
                            <p>&#8369; <span>399</span></p>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="../assets/Frame 32 (4).png" />
                            </div>
                            <p>One-Life Graphiic T-Shirt</p>
                            <p>&#8369; <span>399</span></p>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="../assets/Frame 32 (5).png" />
                            </div>
                            <p>One-Life Graphiic T-Shirt</p>
                            <p>&#8369; <span>399</span></p>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="../assets/Frame 32 (6).png" />
                            </div>
                            <p>One-Life Graphiic T-Shirt</p>
                            <p>&#8369; <span>399</span></p>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="../assets/Frame 32 (7).png" />
                            </div>
                            <p>One-Life Graphiic T-Shirt</p>
                            <p>&#8369; <span>399</span></p>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="../assets/Frame 32 (11).png" />
                            </div>
                            <p>One-Life Graphiic T-Shirt</p>
                            <p>&#8369; <span>399</span></p>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="../assets/Frame 32.png" />
                            </div>
                            <p>One-Life Graphiic T-Shirt</p>
                            <p>&#8369; <span>399</span></p>
                        </div>
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
                    <li><a href="about.php">About</a></li>
                    <li><a href="terms.php">Terms & Conditions</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-info">
                <h4 class="second-category">Categories</h4>
                <ul>
                    <li><a href="products.php">Men's Fashion</a></li>
                    <li><a href="products.php">Women's Fashion</a></li>
                    <li><a href="products.php">Kid's</a></li>
                </ul>
                <div class="footer-products-shortcut">
                    <a style="color: #029f6f;" href="products.php">Find More</a> <img src="../assets/greenright.png"
                        alt="">
                </div>
            </div>
            <div class="footer-info">
                <h4 class="third-category">Help & Support</h4>
                <ul>
                    <li><a href="contact.php">Contact Us</a></li>
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

</html>