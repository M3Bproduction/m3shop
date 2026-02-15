self.addEventListener('install', event => {
  event.waitUntil(
    caches.open('m3shop-cache').then(cache => {
      return cache.addAll([
        '/',
        '/index.html',
        '/products.html',
        '/cart.html',
        '/css/style.css'
      ]);
    })
  );
});
