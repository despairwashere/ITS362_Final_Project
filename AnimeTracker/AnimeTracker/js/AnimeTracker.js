document.addEventListener("DOMContentLoaded", () => {
    const animeListContainer = document.getElementById("animeList");

    // Create search input + button
    const searchBar = document.createElement("div");
    searchBar.innerHTML = `
        <input type="text" id="searchInput" placeholder="Search for an anime..." style="padding: 0.5rem; width: 300px; border-radius: 4px; border: none; margin-right: 10px;">
        <button id="searchBtn" style="padding: 0.5rem 1rem; border: none; background-color: #ff66cc; color: white; border-radius: 4px;">Search</button>
    `;
    animeListContainer.before(searchBar);

    let animeList = [];

    async function fetchAnime() {
        try {
            const response = await fetch("https://api.jikan.moe/v4/seasons/now");
            const data = await response.json();
            animeList = data.data;
            displayAnime(animeList);
        } catch (err) {
            animeListContainer.innerHTML = "<p style='color: red;'>Failed to load anime. Please try again later.</p>";
            console.error(err);
        }
    }

    function displayAnime(list) {
        animeListContainer.innerHTML = ""; // Clear before display

        list.forEach(anime => {
            const card = document.createElement("div");
            card.style = "background-color: #1a1a2e; color: white; padding: 1rem; margin: 1rem 0; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.3);";
            card.innerHTML = `
                <h3>${anime.title}</h3>
                <p><strong>Episodes:</strong> ${anime.episodes ?? 'Unknown'}</p>
                <p><strong>Status:</strong> ${anime.status}</p>
                <p><strong>Next Episode:</strong> ${anime.broadcast?.string ?? 'N/A'}</p>
            `;
            animeListContainer.appendChild(card);
        });
    }

    // Search functionality
    document.getElementById("searchBtn").addEventListener("click", () => {
        const query = document.getElementById("searchInput").value.toLowerCase();
        const filtered = animeList.filter(anime => anime.title.toLowerCase().includes(query));
        displayAnime(filtered);
    });

    // Fetch anime on load
    fetchAnime();
});
