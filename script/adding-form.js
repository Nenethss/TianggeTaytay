// Get elements
const editButtons = document.querySelectorAll('.edit-btn'); // All edit buttons
const cancelButton = document.getElementById('cancelButton');
const accountInfo = document.getElementById('accountInfo');
const personalInfo = document.getElementById('personalInfo');
const updateForm = document.getElementById('updateInfo');

// Function to hide account/personal info and show the form
const showEditForm = () => {
    accountInfo.classList.add('hidden');
    personalInfo.classList.add('hidden');
    updateForm.classList.remove('hidden');
};

// Function to show account/personal info and hide the form
const hideEditForm = () => {
    accountInfo.classList.remove('hidden');
    personalInfo.classList.remove('hidden');
    updateForm.classList.add('hidden');
};

// Show the update form and hide account/personal info on Edit button click
editButtons.forEach(button => {
    button.addEventListener('click', showEditForm);
});

// Hide the update form and show account/personal info on Cancel button click
cancelButton.addEventListener('click', hideEditForm);