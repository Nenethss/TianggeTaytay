<?php
// Start session
session_start();
include_once '../server/connect.php';
include_once '../server/fetchstoreinfo.php';
// Ensure the user is a seller



$storeDescription = htmlspecialchars($store['description'] ?? 'N/A');
$storeName = htmlspecialchars($store['storename'] ?? 'N/A');
$storeContact = htmlspecialchars($seller['store_contact'] ?? 'N/A');
$storeEmail = htmlspecialchars($store['email'] ?? 'N/A');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Tiangge Taytay</title>
    <link rel="stylesheet" href="../style/store-info.css">
    <link rel="stylesheet" href="../style/navandfoot.css">
</head>

<style>
.hidden {
    display: none;
}

.form-hidden {
    display: none;
}


.edt-btn {
    display: flex;
    background-color: white;
    border: 1px #a5a5a5 solid;
    color: #a5a5a5;
    width: 230px;
    padding: 0 12px;
    align-items: center;
    justify-content: space-evenly;
    margin-bottom: 20px;
}

/* Hide the default file input */
input[type="file"] {
    width: 0.01px;
}

/* Style the custom button */
.custom-file-upload {
    background-color: #b6b6b666;
    color: #2d2d2d;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
}

.img-file-upload {
    background-color: #b6b6b666;
    color: #2d2d2d;
    padding: 10px 10px;
    cursor: pointer;
    border-radius: 5px;
    margin: 0 !important;
}

.edit-btn {
    display: flex;
    background-color: white;
    border: 1px #a5a5a5 solid;
    color: #a5a5a5;
    padding: 0 12px;
    align-items: center;
    justify-content: space-evenly;
    margin-bottom: 20px;
}


/* Style the container where the file will be rendered */
.file-container {
    margin-top: 20px;
    border: 2px solid #dddddd;
    border-radius: 100px;
    padding: 20px;
    width: 200px;
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.file-container input {
    width: 100px !important;
    position: absolute;
    cursor: pointer;
}

.img-container {
    margin-top: 20px;
    margin-bottom: 20px;
    border: 2px solid #dddddd;
    display: flex;
    height: 120px;
    align-items: center;
    justify-content: center;
}

.img-input {
    display: block !important;
}

.file-container label {
    margin: 0 !important;
}

.store-name {
    border-bottom: 1px solid #cccccc !important;
    border-radius: 0 !important;
}

.dropdown-menu {
    text-align: center;
}

.dropdown-menu .store-name {
    font-weight: 600;
}

.dropdown-menu a:hover {
    background-color: #fff !important;
}

.linked-account {
    display: flex;
    justify-content: space-between;
}

.linked-accounts-edit div {
    display: flex;
    flex-direction: column;
}

.pagination {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 50px;
    padding: 0 90px;
}

.pagination a {
    padding: 15px 15px;
    margin: 0 4px;
    text-decoration: none;
    color: #333;
    border: 1px solid #ccc;
}


.pagination a:hover {
    background-color: #f0f0f0;
}

.pagination .prev,
.pagination .next {
    padding: 15px 13px;
}
</style>

<body>

    <nav class="navbar">
        <div class="left-side">
            <a href="seller.php"><img src="../assets/shoppingbag.png" alt=""></a>
            <div class="input-with-icon">
                <img class="search-icon" src="../assets/Vector.png" alt="">
                <input type="text" placeholder="Search for Products...">
            </div>
        </div>
        <div class="right-side">
            <ul>
                <li class="selected"><a href="#">Home</a></li>
                <li><a href="about.php" target="_blank">About</a></li>
                <li><a href="products.php" target="_blank">Products</a></li>
                <li><a href="store.php" target="_blank">Store</a></li>
                <li><a href="contact.php" target="_blank">Contact us</a></li>
            </ul>
        </div>


        <div class="dropdown-container" id="dropdown">
            <!-- Store Image -->
            <img style="border-radius: 50px; width: 60px; height: 60px;" src="<?php echo $store_img; ?>"
                alt="Store Image">
            <!-- Arrow Icon -->
            <img id="arrow" style="width: 20px; height: 20px; transform: rotate(90deg);"
                src="../assets/arrowrightblack.png" alt="">
        </div>

        <!-- Dropdown Menu -->
        <div class="dropdown-menu" id="dropdown-menu">
            <a href="#" class="store-name"><?php echo $store_name; ?></a>
            <a href="seller-info.php">Manage Account</a>
            <a href="store-info.php">Manage Store</a>
            <a style="color: red;" href="logout.php">Logout</a>
        </div>
    </nav>

    <div id="productFormContainer" class="form-hidden">
        <form class="product-form" id="addingForm" action="../server/add_product.php" method="POST"
            enctype="multipart/form-data">
            <!-- Close Button -->
            <img src="../assets/close.png" id="closeFormButton" class="close-btn" alt="Close">

            <label>Product Name</label>
            <input type="text" name="product_name" required>

            <label>Product Description</label>
            <input type="text" name="description" required>

            <label>Price</label>
            <input type="text" name="price" required>

            <label>Category</label>
            <select name="category" id="category">
                <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['categoryid']; ?>">
                    <?php echo htmlspecialchars($category['category_name']); ?>
                </option>
                <?php endforeach; ?>
            </select>

            <label>Type</label>
            <select name="type" id="type">
                <?php foreach ($product_types as $type): ?>
                <option value="<?php echo $type['typeid']; ?>"><?php echo htmlspecialchars($type['typename']); ?>
                </option>
                <?php endforeach; ?>
            </select>

            <div id="image-container" class="img-container">
                <label for="file-upload" class="img-file-upload">Choose Files</label>
                <input type="file" id="file-upload" name="product_imgs[]" accept="image/*" multiple
                    onchange="renderFiles(event)" style="opacity: 0%;" />
            </div>


            <?php echo !empty($lazada_field) ? '<label>Link on Shopee</label> <input type="url" name="shopee_link">' : ''; ?>
            <?php echo !empty($shopee_field) ? '<label>Link on Lazada</label> <input type="url" name="lazada_link">' : ''; ?>

            <div class="add-button">
                <button type="submit">Add Product</button>
            </div>
        </form>

    </div>

    <div class="main-content">
        <div class="sidebar">
            <a href="seller-info.php">Manage Account</a>
            <a href="#" class="active">Manage Store</a>
        </div>

        <div class="edit-container">
            <button class="edt-btn" id="editStoreBtn">
                <img src="../assets/pencil.svg" alt="Edit">Edit Store Information
            </button>
        </div>

        <div id="storeInfo" class="account-info">
            <div class="store-info-card">
                <img style="border-radius: 50px; width: 100px; height: 100px;" src="<?php echo $store_img; ?>"
                    alt="Store Image">
                <p style="font-weight: 600;"><?php echo $store_name; ?></p>
            </div>
            <div class="info-card middle-info-card">
                <div class="info"><img src="../assets/shipment-box.png" alt="">
                    <p>Products: <strong><?php echo $product_count; ?></strong></p>
                </div>
                <div class="info"><img src="../assets/joined.png" alt="">
                    <p>Created At: <strong><?php echo $created_at; ?></strong></p>
                </div>
                <div class="info"><img src="../assets/stall.png" alt="">
                    <p>Stall No: <strong><?php echo htmlspecialchars(implode(' ', $stallNumbers)); ?></strong></p>
                </div>
            </div>
            <div class="info-card">
                <div class="info"><img src="../assets/telephone.png" alt="">
                    <p>Contact: <strong><?php echo $store_contact; ?></strong></p>
                </div>
                <div class="info"><img src="../assets/thread.png" alt="">
                    <p>Email: <strong><?php echo $store_email; ?></strong></p>
                </div>
            </div>
        </div>

        <div id="divider" class="divider">
            <div></div>
        </div>

        <div id="mainProducts" class="main-products-container">
            <div class="child-container">
                <div class="header-container">
                    <h2>MY PRODUCTS</h2>
                    <button id="showFormButton">Add Product</button>
                </div>

                <div class="products-container">
                    <?php if (!empty($product_details)): ?>
                    <?php foreach ($product_details as $product): ?>
                    <div class="product-card">
                        <!-- Display Product Image -->
                        <img src="<?php echo isset($product['first_image']) ? 'data:image/jpeg;base64,' . base64_encode($product['first_image']) : '../assets/default-product.png'; ?>"
                            alt="Product Image">

                        <!-- Product Name and Price -->
                        <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                        <p>₱<?php echo htmlspecialchars($product['price']); ?></p>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p>No products found for this store.</p>
                    <?php endif; ?>
                </div>

                <!-- Pagination Controls -->

            </div>
        </div>



        <form class="hidden" id="updateInfo" method="POST" action="../server/updateStore.php"
            enctype="multipart/form-data">
            <div class="basic-info rounded-box">
                <h2>Store Icon</h2>
                <div>
                    <div id="file-container" class="file-container">
                        <label for="file-upload" class="custom-file-upload">Choose File</label>
                        <input type="file" id="file-upload" name="img" accept="image/*" onchange="renderFile(event)"
                            style="opacity: 0%;" />
                    </div>
                </div>
            </div>

            <div class="basic-info rounded-box">
                <h2>About</h2>
                <div>
                    <textarea name="description" id="description"><?php echo $store_description ?></textarea>
                </div>
            </div>

            <div class="basic-info rounded-box">
                <h2>Store Details</h2>
                <div class="store-information">
                    <div class="first-child">
                        <div>
                            <label for="stallnumber">Stall No.</label>
                            <input type="text" name="stallnumber" id="stallnumber"
                                value="<?php echo htmlspecialchars(implode(' ', $stallNumbers)); ?>" />
                        </div>
                        <div>
                            <label for="contact">Contact No.</label>
                            <input type="text" name="contact" id="contact"
                                value="<?php echo htmlspecialchars($store_contact); ?>" />
                        </div>
                        <div>
                            <label for="firstname">Business Permit</label>
                            <p style="color: green; font-weight: 600;">
                                <?php 
                                // Assume $status is fetched from sellertb
                                echo htmlspecialchars($status ?? 'Unknown'); 
                                ?>
                            </p>
                        </div>
                    </div>
                    <div>
                        <div>
                            <label for="storename">Store Name</label>
                            <input type="text" name="storename" id="storename" value="<?php echo $store_name ?>"
                                readonly required />
                        </div>
                        <div>
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email"
                                value="<?php echo htmlspecialchars($store_email); ?>" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="basic-info rounded-box">
                <div class="linked-account" style="display: flex; justify-content: space-between; align-items: center;">
                    <h2>Linked Accounts</h2>
                    <button type="button" id="editAccountsButton" class="edit-button">Edit</button>
                </div>
                <div id="linkedAccountsView" class="linked-accounts-view">
                    <div style="display: flex;">
                        <label for="firstname">Lazada:</label>
                        <?php echo !empty($lazada_field) ? '<p style="color: green; font-weight: 600;">YES </p>' : '<p style="color: red; font-weight: 600;">NO </p>'; ?>
                    </div>
                    <div style="display: flex;">
                        <label for="firstname">Shopee:</label>
                        <?php echo !empty($shopee_field) ? '<p style="color: green; font-weight: 600;">YES </p>' : '<p style="color: red; font-weight: 600;">NO </p>'; ?>
                    </div>
                </div>
                <div id="linkedAccountsEdit" class="linked-accounts-edit hidden">
                    <div>
                        <label for="lazada_link">Lazada</label>
                        <input type="text" name="lazada_link" id="lazada_link"
                            value="<?php echo htmlspecialchars($lazada_field ?? ''); ?>"
                            placeholder="Enter Lazada account link" />
                    </div>
                    <div>
                        <label for="shopee_link">Shopee</label>
                        <input type="text" name="shopee_link" id="shopee_link"
                            value="<?php echo htmlspecialchars($shopee_field ?? ''); ?>"
                            placeholder="Enter Shopee account link" />
                    </div>
                </div>
            </div>


            <div class="add-button">
                <button style="margin-right: 20px;" type="button" id="cancelButton">Cancel</button>
                <button type="submit">Save</button>
            </div>
        </form>
    </div>
    <div class="pagination">

        <?php if ($current_page > 1): ?>    
        <a href="?page=<?php echo $current_page - 1; ?>" class="prev"><img  style="width: 12px; height: 12px; transform: rotate(180deg);" src="../assets/arrowrightblack.png" alt=""></a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>"
            class="page <?php echo ($i == $current_page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages): ?>
        <a href="?page=<?php echo $current_page + 1; ?>" class="next"><img style="width: 12px; height: 12px;" src="../assets/arrowrightblack.png" alt=""></a>
        <?php endif; ?>

    </div>

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

    <script src="../script/drop-down.js"></script>
    <script src="../script/formshow.js"></script>
    <script src="../script/adding-form.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const editStoreBtn = document.getElementById('editStoreBtn');
        const updateInfoForm = document.getElementById('updateInfo');
        const editContainer = document.querySelector('.edit-container');
        const accountInfo = document.getElementById('storeInfo');
        const divider = document.getElementById('divider');
        const mainProducts = document.getElementById('mainProducts');
        const closeButton = document.getElementById('cancelButton'); // Adjust the ID if necessary

        // Toggle visibility when the "Edit Store Information" button is clicked
        editStoreBtn.addEventListener('click', () => {
            console.log('Edit button clicked');
            // Show the update info form
            updateInfoForm.classList.remove('hidden');

            // Hide the other sections
            editContainer.classList.add('hidden');
            accountInfo.classList.add('hidden');
            divider.classList.add('hidden');
            mainProducts.classList.add('hidden');
        });

        // Revert visibility when the close button is clicked
        closeButton.addEventListener('click', () => {
            console.log('Close button clicked');
            // Hide the update info form
            updateInfoForm.classList.add('hidden');

            // Show the other sections
            editContainer.classList.remove('hidden');
            accountInfo.classList.remove('hidden');
            divider.classList.remove('hidden');
            mainProducts.classList.remove('hidden');
        });
    });

    function renderFile(event) {
        const container = document.getElementById("file-container");
        const file = event.target.files[0]; // Get the uploaded file

        // Remove the label only
        const label = container.querySelector("label");
        if (label) {
            container.removeChild(label);
        }

        // Clear existing preview image if present
        const existingPreview = container.querySelector("img");
        if (existingPreview) {
            container.removeChild(existingPreview);
        }

        if (file) {
            // Create a new image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.style.width = "200px";
                img.style.height = "200px";
                img.style.borderRadius = "100px";
                container.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    }

    function renderFiles(event) {
        const container = document.getElementById("image-container");
        const files = event.target.files; // Get the uploaded files

        // Clear the container
        const label = container.querySelector("label");
        if (label) {
            container.removeChild(label);
        }

        if (files.length) {
            Array.from(files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.style.maxWidth = "100px";
                    img.style.maxHeight = "100px";
                    img.style.margin = "5px";
                    container.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        } else {
            container.innerHTML = 'No files selected';
        }
    }

    document.getElementById('editAccountsButton').addEventListener('click', function() {
        const viewMode = document.getElementById('linkedAccountsView');
        const editMode = document.getElementById('linkedAccountsEdit');
        const isHidden = editMode.classList.contains('hidden');

        if (isHidden) {
            editMode.classList.remove('hidden');
            viewMode.classList.add('hidden');
            this.textContent = 'Cancel';
        } else {
            editMode.classList.add('hidden');
            viewMode.classList.remove('hidden');
            this.textContent = 'Edit';
        }
    });
    </script>
</body>

</html>