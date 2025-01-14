const categorySelect = document.querySelector(".categories-select");
const typeSelect = document.querySelector(".types-select");
const pagesField = document.querySelector(".pages");
const results = document.querySelector(".results");
const storename = document
  .querySelector(".products")
  .getAttribute("data-storename");
let currentPage = 1; // Default to page 1
let category = "";
let type = "";
const productContainer = document.querySelector(".products");

const highlightCurrentPage = () => {
  const prevSelected = document.querySelector(".pages > .page p.selected");
  if (prevSelected) prevSelected.classList.remove("selected");

  const currentPageElement = document.querySelector(
    `.pages > .page:nth-of-type(${currentPage}) p`
  );
  if (currentPageElement) currentPageElement.classList.add("selected");
};

const showEmptyState = (container, message) => {
  container.innerHTML = `<p class="empty-state">${message}</p>`;
};

const createOption = (value, text) => {
  const option = document.createElement("option");
  option.value = value;
  option.textContent = text;
  return option;
};


const ProductCard = (id, img, name, price) => {
  const div = document.createElement("div");
  div.className = "product-card";

  const productImage = document.createElement("img");
  productImage.className = "product-image";
  productImage.src = img ? `data:image/png;base64,${img}` : defaultImage;
  productImage.loading = "lazy";
  productImage.onerror = () => {
    productImage.src = defaultImage; // Fallback for broken images
  };

  const productName = document.createElement("p");
  productName.textContent = name;

  // Create a container for price and delete icon
  const priceDeleteContainer = document.createElement("div");
  priceDeleteContainer.className = "price-delete-container";

  const productPrice = document.createElement("p");
  productPrice.innerHTML = `&#8369; <span>${price}</span>`;

  
  productImage.addEventListener("click", () => {
    window.open(`http://localhost/eTianggeTaytay/pages/view-product.php?id=${id}`, "_blank");
  });


  const productDelete = document.createElement("img");
  productDelete.className = "product-delete";
  productDelete.src = "../assets/trashbin.png"; // Set the image source
  productDelete.alt = "Delete";
  productDelete.title = "Remove Product"; // Tooltip for the icon
  productDelete.addEventListener("click", (e) => {
    e.stopPropagation(); // Prevent triggering the card click event
    deleteProduct(id); // Call a delete function
  });
  

  const productEdit = document.createElement("button");
  productEdit.className = "product-edit";
  productEdit.textContent = "Edit";
  productEdit.addEventListener("click", (e) => {
    e.stopPropagation(); // Prevent triggering the card click event
    openEditModal(id, name, price); // Open a modal for editing
  });

  // Append price and delete icon to the container
  priceDeleteContainer.appendChild(productPrice);
  priceDeleteContainer.appendChild(productDelete);
  priceDeleteContainer.appendChild(productEdit);
  

  div.appendChild(productImage);
  div.appendChild(productName);
  div.appendChild(priceDeleteContainer); // Append the container to the main div

  return div;
};



const openEditModal = (id, name, price) => {
  const modal = document.querySelector("#editModal");
  const closeModal = document.querySelector("#closeModal");
  const editForm = document.querySelector("#editProductForm");

  // Populate the form with existing values
  document.querySelector("#editName").value = name;
  document.querySelector("#editPrice").value = price;

  modal.style.display = "block";

  // Close the modal
  closeModal.onclick = () => {
    modal.style.display = "none";
  };

  // Handle form submission
  editForm.onsubmit = (e) => {
    e.preventDefault();
    const updatedName = document.querySelector("#editName").value;
    const updatedPrice = document.querySelector("#editPrice").value;
    const updatedDescription = document.querySelector("#editDescription").value;

    updateProduct(id, updatedName, updatedPrice, updatedDescription);
    modal.style.display = "none"; // Close modal after saving
  };
};

// Update product details using fetch
const updateProduct = (id, name, price, description) => {
  fetch("http://localhost/eTianggeTaytay/server/update_product.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ id, name, price, description }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert(data.message);
        renderPage(); // Re-render product list
      } else {
        alert(data.message);
      }
    })
    .catch((error) => {
      console.error("Error updating product:", error);
    });
};




const deleteProduct = (id) => {
  if (confirm("Are you sure you want to delete this product?")) {
    fetch("http://localhost/eTianggeTaytay/server/delete_product.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert(data.message);
          renderPage(); // Re-fetch and render the updated product list
        } else {
          alert(data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Failed to delete the product.");
      });
  }
};






const fetchCategories = async () => {
  try {
    const response = await fetch(
      "http://localhost/eTianggeTaytay/server/products-fetch-ui.php?component=category"
    );

    if (!response.ok) {
      throw new Error(`Failed to fetch categories: ${response.statusText}`);
    }

    const data = await response.json();

    if (!data.categories || !Array.isArray(data.categories)) {
      throw new Error("Invalid categories data format.");
    }

    categorySelect.innerHTML = ""; // Clear previous options
    categorySelect.appendChild(createOption("", "All Categories")); // Default option

    data.categories.forEach((category) => {
      categorySelect.appendChild(createOption(category, category));
    });
  } catch (error) {
    console.error("Error fetching categories:", error);
  }
};

/** Fetch Types */
const fetchTypes = async () => {
  if (!typeSelect) {
    console.error("Type select element not found in the DOM.");
    return;
  }

  try {
    const response = await fetch(
      "http://localhost/eTianggeTaytay/server/products-fetch-ui.php?component=type"
    );

    if (!response.ok) {
      throw new Error(`Failed to fetch types: ${response.statusText}`);
    }

    const data = await response.json();

    typeSelect.innerHTML = ""; // Clear previous options
    typeSelect.appendChild(createOption("", "All Types")); // Default option

    data.product_types.forEach((product_type) => {
      typeSelect.appendChild(createOption(product_type, product_type));
    });
  } catch (error) {
    console.error("Error fetching types:", error);
  }
};

const fetchProducts = async (storename) => {
  try {
    const response = await fetch(
      `http://localhost/eTianggeTaytay/server/fetch_product.php?store=${storename}&category=${category}&type=${type}&max=${10}&page=${currentPage}`
    );

    if (!response.ok) {
      throw new Error(`Failed to fetch products: ${response.statusText}`);
    }

    const data = await response.json();
    const { data: products, total_records, start, end, pages, page } = data;

    if (!products || products.length === 0) {
      showEmptyState(
        productContainer,
        "No products found for the selected filters."
      );
      return;
    }

    productContainer.innerHTML = ""; // Clear previous products
    products.forEach((product) => {
      const productCard = ProductCard(
        product.product_id,
        product.img,
        product.product_name,
        product.price
      );
      productContainer.appendChild(productCard);
    });

    pagesField.innerHTML = "";

    //Render pagination
    Array.from({ length: pages }, (_, i) => i + 1).forEach((pageNumber) => {
      const pageDiv = document.createElement("div");
      pageDiv.className = "page";
      pageDiv.innerHTML = `<p>${pageNumber}</p>`;
      pageDiv.addEventListener("click", async () => {
        currentPage = pageNumber;
        await fetchProducts(storename);
        scrollToTop();
      });

      pagesField.appendChild(pageDiv);

      highlightCurrentPage();
    });

    results.textContent = `Showing ${start} to ${end} of ${total_records} results`;
  } catch (error) {
    console.error("Error fetching products:", error);
  }
};

const renderPage = async () => {
  await fetchCategories();
  await fetchTypes();
  await fetchProducts(storename);

  categorySelect.addEventListener("change", () => {
    category = categorySelect.value;
    fetchProducts(storename);
  });

  typeSelect.addEventListener("change", () => {
    type = typeSelect.value;
    fetchProducts(storename);
  });
};

window.addEventListener("DOMContentLoaded", renderPage);