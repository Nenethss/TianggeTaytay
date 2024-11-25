
  document.addEventListener("DOMContentLoaded", function () {
    const formContainer = document.getElementById("productFormContainer");
    const showFormButton = document.getElementById("showFormButton");
    const closeFormButton = document.getElementById("closeFormButton");

    // Show the form
    showFormButton.addEventListener("click", function () {
      formContainer.classList.remove("hidden");
    });

    // Hide the form
    closeFormButton.addEventListener("click", function () {
      formContainer.classList.add("hidden");
    });

    // Optional: Close the form when clicking outside it
    document.addEventListener("click", function (e) {
      if (!formContainer.contains(e.target) && e.target !== showFormButton) {
        formContainer.classList.add("hidden");
      }
    });
  });
