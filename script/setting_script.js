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

const selectElement = document.getElementById('archive-select'); // Get the select element
const sidebarItems = document.querySelectorAll('.sidebar-item'); // Get all sidebar items

// Function to activate a section based on its data-section attribute
function activateSection(section) {
    if (section) {
        // Simulate clicking the matching sidebar item
        const sidebarItem = document.querySelector(`.sidebar-item[data-section="${section}"]`);
        if (sidebarItem) {
            sidebarItem.click();
        }
    } else {
        // Default to the first section
        document.querySelector('.sidebar-item').click();
    }
}

// If a section is specified in the URL, activate it
if (sectionFromURL) {
    activateSection(sectionFromURL);
} else {
    activateSection(); // Activate the default section
}

// Add an event listener to the select element to handle changes
selectElement.addEventListener('change', (event) => {
    const selectedOption = event.target.options[event.target.selectedIndex]; // Get the selected option
    const section = selectedOption.getAttribute('data-section'); // Get the data-section attribute value

    // Update the URL query parameter without reloading the page
    const newUrl = `${window.location.pathname}?section=${section}`;
    window.history.pushState({}, '', newUrl);

    // Activate the corresponding section
    activateSection(section);
});


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
        document.getElementById('add-category-form').reset();
        document.getElementById('add-type-form').reset();

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
        const caterrorMessage = document.getElementById('cat-error-message');
            const catsuccessMessage = document.getElementById('cat-success-message');
            const typeerrorMessage = document.getElementById('type-error-message');
                const typesuccessMessage = document.getElementById('type-success-message');

        // Set a timeout to hide the messages after 3 seconds
        setTimeout(() => {
            if (errorMessage) {
                errorMessage.style.display = 'none';
                caterrorMessage.style.display = 'none';
                typeerrorMessage.style.display = 'none'; // Hide error message
            }
            if (successMessage) {
                successMessage.style.display = 'none';
                catsuccessMessage.style.display = 'none';
                typesuccessMessage.style.display = 'none'; // Hide success message
            }
        }, 3000); 

});