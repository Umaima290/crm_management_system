// Example: Highlight Active Sidebar Link
document.querySelectorAll('.sidebar ul li a').forEach(link => {
    link.addEventListener('click', () => {
        document.querySelector('.sidebar ul li a.active')?.classList.remove('active');
        link.classList.add('active');
    });
});
