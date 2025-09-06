document.addEventListener('DOMContentLoaded', function() {
  const shuffleBtn = document.getElementById('shuffle-btn');
  const galleryItems = document.querySelectorAll('.gallery-item');
  const imageUrls = [
    'https://images.unsplash.com/photo-1501854140801-50d01698950b?...',
    'https://images.unsplash.com/photo-1496568816309-51d7c20e3b21?...',
    'https://images.unsplash.com/photo-1487958449943-2429e8be8625?...',
    'https://images.unsplash.com/photo-1532274402911-5a369e4c4bb5?...',
    'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?...',
    'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?...',
    'https://images.unsplash.com/photo-1474511320723-9a56873867b5?...',
    'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?...',
    'https://images.unsplash.com/photo-1509316785289-025f5b846b35?...',
    'https://images.unsplash.com/photo-1510784722466-f2aa9c52fff6?...',
    'https://images.unsplash.com/photo-1506744038136-46273834b3fb?...',
    'https://images.unsplash.com/photo-1511497584788-876760111969?...',
    'https://images.unsplash.com/photo-1433086966358-54859d0ed716?...',
    'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?...',
    'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?...'
  ];
  function getRandomImageUrl() {
    const randomIndex = Math.floor(Math.random() * imageUrls.length);
    return `${imageUrls[randomIndex]}&t=${Date.now()}`;
  }
  shuffleBtn.addEventListener('click', function() {
    galleryItems.forEach(item => {
      const img = item.querySelector('.gallery-img');
      img.src = getRandomImageUrl();
      img.style.opacity = '0.5';
      setTimeout(() => { img.style.opacity = '1'; }, 300);
    });
  });
  galleryItems.forEach((item, index) => {
    item.style.opacity = '0';
    item.style.transform = 'translateY(20px)';
    setTimeout(() => {
      item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
      item.style.opacity = '1';
      item.style.transform = 'translateY(0)';
    }, index * 100);
  });
});
