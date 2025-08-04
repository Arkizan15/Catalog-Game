// Add click handlers for game cards
document.addEventListener('DOMContentLoaded', function() {
    // Game card click handlers
    document.querySelectorAll('.game-card').forEach(card => {
        card.addEventListener('click', function() {
            const gameName = this.querySelector('.placeholder-image').textContent;
            console.log(`Clicked on: ${gameName}`);
            // You can add navigation logic here
            // Example: window.location.href = `/game/${gameName.toLowerCase().replace(/\s+/g, '-')}`;
        });
    });

    // Add smooth scrolling for horizontal game lists
    document.querySelectorAll('.game-list').forEach(list => {
        let isDown = false;
        let startX;
        let scrollLeft;

        list.addEventListener('mousedown', (e) => {
            isDown = true;
            list.style.cursor = 'grabbing';
            startX = e.pageX - list.offsetLeft;
            scrollLeft = list.scrollLeft;
        });

        list.addEventListener('mouseleave', () => {
            isDown = false;
            list.style.cursor = 'grab';
        });

        list.addEventListener('mouseup', () => {
            isDown = false;
            list.style.cursor = 'grab';
        });

        list.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - list.offsetLeft;
            const walk = (x - startX) * 2; // Scroll speed multiplier
            list.scrollLeft = scrollLeft - walk;
        });

        // Set initial cursor
        list.style.cursor = 'grab';
    });

    // Add "Show more" link functionality
    document.querySelectorAll('.section-header a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const sectionTitle = this.parentElement.querySelector('h2').textContent;
            console.log(`Show more clicked for: ${sectionTitle}`);
            // Add your navigation logic here
            // Example: window.location.href = `/category/${sectionTitle.toLowerCase().replace(/\s+/g, '-')}`;
        });
    });
});