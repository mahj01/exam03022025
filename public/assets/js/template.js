// Toggle Sidebar for Mobile
const sidebar = document.getElementById('sidebar');
const menuToggle = document.getElementById('menuToggle');

menuToggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
});

// Navigation Menu Item Click Handler
const navLinks = document.querySelectorAll('.nav-menu a');

navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        // Remove active class from all links
        navLinks.forEach(l => l.classList.remove('active'));
        
        // Add active class to clicked link
        e.currentTarget.classList.add('active');
        
        // On mobile, close sidebar after selection
        if (window.innerWidth <= 768) {
            sidebar.classList.remove('active');
        }
    });
});

// Optional: Close sidebar if clicked outside on mobile
document.addEventListener('click', (e) => {
    if (window.innerWidth <= 768 && 
        !sidebar.contains(e.target) && 
        !menuToggle.contains(e.target)) {
        sidebar.classList.remove('active');
    }
});