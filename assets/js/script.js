// The header JS 
document.addEventListener("DOMContentLoaded", function() {
    let citySelect = document.getElementById("citySelect");
    let searchInput = document.getElementById("searchInput");
    let searchButton = document.getElementById("searchButton");

    // Page reload hone par URL check karega
    let urlParams = new URLSearchParams(window.location.search);
    let city = urlParams.get('city'); // URL se 'city' value get karega
    let searchQuery = urlParams.get("search"); // URL se 'search' value get kare

    if (city) {
        citySelect.value = city;
    }
    if (searchQuery) {
        searchInput.value = searchQuery;
    }

    citySelect.addEventListener("change", function() {
        let city = this.value;

        let url = new URL(window.location.href);

        if (city) {
            url.searchParams.set('city', city);
        } else {
            url.searchParams.delete('city');
        }

        window.history.pushState({}, '', url); // Update URL without reloading
    });

    searchButton.addEventListener("click", function() {
        let query = searchInput.value.trim();
        let url = new URL(window.location.href);

        if (query) {
            url.searchParams.set("search", query); 
        } else {
            url.searchParams.delete("search"); 
        }

        window.history.pushState({}, "", url);
    });
});