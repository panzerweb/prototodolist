
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


// HTML Dialog Modal Function Show
const closeBtn = document.getElementById("close-modal-btn");

document.addEventListener('DOMContentLoaded', function(){
    let dialog = document.getElementById("dialog");
    setTimeout(() => {
        dialog.showModal(); 
    }, 300);
})

closeBtn.addEventListener("click", function(){
    dialog.close();
})

