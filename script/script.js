const heroContent = {
    1: {
        title: "Register",
        description: "Create your seller account to post and market your products!",
    },
    2: {
        title: "Register",
        description: "Create your seller account to post and market your products!",
    },
    3: {
        title: "Register",
        description: "Create your seller account to post and market your products!",
    },
    4: {
        title: "Register",
        description: "Create your seller account to post and market your products!",
    },
    5: {
        title: "We’re Excited to Have You Onboard!",
        description: "",
    },
};

function updateHeroContent(step) {
    const heroTitle = document.getElementById("hero-title");
    const heroDescription = document.getElementById("hero-description");
    if (heroContent[step]) {
        heroTitle.textContent = heroContent[step].title;
        heroDescription.textContent = heroContent[step].description;
    }
}

function nextStep(currentStep) {
    var currentForm = document.getElementById('step' + currentStep);
    var nextForm = document.getElementById('step' + (currentStep + 1));

    var allValid = true;


    if (allValid) {
        currentForm.classList.remove('active');
        nextForm.classList.add('active');

        // Update hero section visibility
        document.getElementById('hero-text').classList.add('active');
        updateHeroContent(currentStep + 1);
    }
}

function previousStep(currentStep) {
    var currentForm = document.getElementById('step' + currentStep);
    var previousForm = document.getElementById('step' + (currentStep - 1));

    currentForm.classList.remove('active');
    previousForm.classList.add('active');

    // Update hero section visibility
    updateHeroContent(currentStep - 1);
}

function submitRegistrationForm(formData) {
    fetch('../server/save_registration.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Hide all steps
            for (let i = 1; i <= 4; i++) {
                document.getElementById('step' + i)?.classList.remove('active');
            }
            // Show Step 5
            document.getElementById('step5').classList.add('active');
            updateHeroContent(5);
        } else {
            alert('Registration failed. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}

document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(this);
    submitRegistrationForm(formData);
});
