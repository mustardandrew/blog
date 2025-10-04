// Keyboard shortcuts for bookmarks search
document.addEventListener('DOMContentLoaded', function() {
    // Ctrl+K to focus search in bookmarks
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            const searchInput = document.querySelector('input[type="search"][placeholder*="Пошук"]');
            if (searchInput) {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
        }
    });
});