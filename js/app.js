// Get the buttons by their IDs
const signInBtn = document.getElementById('signInBtn');
const signUpBtn = document.getElementById('signUpBtn');

// Add event listener for the 'Login' button
signInBtn.addEventListener('click', function() {
    alert('Redirecting to Login.php');
    // Redirect to login.php
    window.location.href = './config/login.php';
});

// Add event listener for the 'Get Started' button
signUpBtn.addEventListener('click', function() {
    alert('Redirecting to Registration.php');
    // Redirect to registration.php
    window.location.href = './config/registration.php';
});
