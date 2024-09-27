// index.js

document.addEventListener("DOMContentLoaded", function() {
    // Target the text elements for animation
    const welcomeText = document.querySelector('.text-item h2');
    const welcomeParagraph = document.querySelector('.text-item p');
    const loginSection = document.querySelector('.login-section');
    // Create a timeline for the animation
    const tl = gsap.timeline({ defaults: { duration: 1, ease: "power4.out" } });

    // Set initial states
    tl.from(welcomeText, { y: 30, opacity: 0 })
        .from(welcomeParagraph, { y: 30, opacity: 0 })
        .from(loginSection, { opacity: 0, y: '50%', ease: "power4.out" }); // Move login section to the middle and fade in

    // Optional: Add more animations or modify as needed

    // Start the animation
    tl.play();
});
