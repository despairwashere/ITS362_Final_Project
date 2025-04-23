let animeData = [];

window.onload = () => {
  fetchAnime();
};

async function fetchAnime() {
  try {
    const res = await fetch('https://api.jikan.moe/v4/seasons/now');
    const json = await res.json();
    animeData = json.data;
    renderAnime(animeData);
  } catch (error) {
    console.error('Error fetching anime:', error);
  }
}

function renderAnime(data) {
  const container = document.getElementById('animeList');
  container.innerHTML = '';

  data.forEach(anime => {
    const card = document.createElement('div');
    card.className = 'anime-card';
    card.innerHTML = `
      <img src="${anime.images.jpg.image_url}" alt="${anime.title}">
      <h3>${anime.title}</h3>
      <p><strong>Episodes:</strong> ${anime.episodes ?? '?'}</p>
      <p><strong>Status:</strong> ${anime.status}</p>
      <p><strong>Next Ep:</strong> ${anime.broadcast?.string || 'N/A'}</p>
    `;
    container.appendChild(card);
  });
}

function handleSearch() {
  const query = document.getElementById('searchInput').value.toLowerCase();
  const filtered = animeData.filter(anime =>
    anime.title.toLowerCase().includes(query)
  );
  renderAnime(filtered);
}
