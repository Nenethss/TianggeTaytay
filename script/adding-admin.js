document.addEventListener('DOMContentLoaded', function() {
    // Function to update the URL without reloading the page
    function updateURL(sectionName) {
        const url = new URL(window.location);
        url.searchParams.set('section', sectionName); // Set the section query parameter
        history.pushState(null, null, url); // Update the URL
    }

    // Add event listeners to sidebar items
    document.querySelectorAll('.sidebar-item').forEach(item => {
        item.addEventListener('click', function() {
            // Remove active class from all sidebar items
            document.querySelectorAll('.sidebar-item').forEach(sidebar => sidebar.classList
                .remove('active'));

            // Add active class to the clicked sidebar item
            this.classList.add('active');

            // Hide all sections
            document.querySelectorAll('.section-container').forEach(section => {
                section.classList.add('hidden'); // Hide all sections
                section.classList.remove(
                    'active'); // Ensure no section stays active
            });

            // Get the section name from the clicked sidebar item using data-section
            const sectionName = this.getAttribute('data-section');
            console.log("Active section name:",
                sectionName); // Debug: Check the section name

            // Find the section by the generated name
            const activeSection = document.querySelector(`.${sectionName}-section`);
            if (activeSection) {
                // Show the relevant section if found
                activeSection.classList.remove('hidden');
                activeSection.classList.add('active');
                console.log("Showing section:",
                    sectionName); // Debug: Check if section is shown
                updateURL(sectionName); // Update the URL with the section name
            } else {
                console.log("No matching section found for:",
                    sectionName); // Debug: Check if section is found
            }
        });
    });

    // On page load, check the URL to determine the active section
    const urlParams = new URLSearchParams(window.location.search);
    const sectionFromURL = urlParams.get('section'); // Get the section from the URL query parameter

    if (sectionFromURL) {
        const sidebarItem = document.querySelector(`.sidebar-item[data-section="${sectionFromURL}"]`);
        if (sidebarItem) {
            sidebarItem.click(); // Trigger a click on the sidebar item corresponding to the URL
        }
    } else {
        // Default to the first section if no section is specified in the URL
        document.querySelector('.sidebar-item').click();
    }

    // Listen for input events on the form fields to remove the error or success messages when user starts typing
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function() {
            // Hide both error and success messages when the user starts typing
            const errorMessageElement = document.getElementById('error-message');
            const successMessageElement = document.getElementById('success-message');
            if (errorMessageElement) {
                errorMessageElement.style.display = 'none';
            }
            if (successMessageElement) {
                successMessageElement.style.display = 'none';
            }
        });
    });

    // Custom Cancel button functionality
    document.getElementById('clearBtn').addEventListener('click', function() {
        // Reset all form fields
        document.getElementById('adminForm').reset();

        // Clear any error or success message if visible
        const errorMessageElement = document.getElementById('error-message');
        const successMessageElement = document.getElementById('success-message');
        if (errorMessageElement) {
            errorMessageElement.style.display = 'none';
        }
        if (successMessageElement) {
            successMessageElement.style.display = 'none';
        }
    });

    const errorMessage = document.getElementById('error-message');
        const successMessage = document.getElementById('success-message');

        // Set a timeout to hide the messages after 3 seconds
        setTimeout(() => {
            if (errorMessage) {
                errorMessage.style.display = 'none'; // Hide error message
            }
            if (successMessage) {
                successMessage.style.display = 'none'; // Hide success message
            }
        }, 3000); 

});