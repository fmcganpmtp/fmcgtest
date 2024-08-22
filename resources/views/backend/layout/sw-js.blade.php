const filesToCache = [
  'offline.html',
];


const staticCacheName = 'acp-v1';

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(staticCacheName)
    .then(cache => {
      return cache.addAll(filesToCache);
    })
  );
});

self.addEventListener('fetch', event => {
  //console.log('Fetch event for ', event.request.url);
  event.respondWith(
    caches.match(event.request)
    .then(response => {
      if (response) {
        //console.log('Found ', event.request.url, ' in cache');
        return response;
      }
      //console.log('Network request for ', event.request.url);
      return fetch(event.request)
    }).catch(error => {
       return caches.match('offline.html');
    })
  );
});