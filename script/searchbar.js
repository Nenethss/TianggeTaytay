const searchBar = document.querySelector("#searchbar");
const searchResults = document.querySelector(".search-results");

const renderResults = (results) => {
  searchResults.innerHTML = "";

  if (results.length === 0) {
    const noResultsElement = document.createElement("p");
    noResultsElement.textContent = "No results found...";
    searchResults.appendChild(noResultsElement);
    return;
  } else {
    results.forEach((result) => {
      const resultElement = document.createElement("p");
      resultElement.textContent = result.product_name;
      searchResults.appendChild(resultElement);
    });
  }
};

const getResults = async (searchTerm) => {
  try {
    const response = await fetch(
      "http://localhost:3000/server/search_products.php",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ search_term: searchTerm }),
      }
    );
    const data = await response.json();
    renderResults(data);
  } catch (error) {
    console.log(error);
  }
};

searchBar.addEventListener("input", (e) => {
  const searchTerm = e.target.value.toLowerCase();
  if (searchTerm.length > 0) {
    searchResults.classList.add("open");
  } else {
    searchResults.classList.remove("open");
  }
  getResults(searchTerm);
});
