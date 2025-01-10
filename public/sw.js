const CACHE_NAME = "pwa-cache-v1";

// Files to cache
const urlsToCache = [
    "/", // Cache the home page
    "/offline", // Offline fallback page (create this route in Laravel)
];

// Install event - Cache specified files
self.addEventListener("install", function (event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function (cache) {
            return cache.addAll(urlsToCache);
        })
    );
});

// Fetch event - Serve cached files or fallback to offline page
self.addEventListener("fetch", function (event) {
    event.respondWith(
        caches.match(event.request.clone()).then(function (response) {
            // Return cached response if found, otherwise fetch from network
            return response || fetch(event.request.clone()).catch(() => caches.match("/offline"));
        })
    );
});

// Activate event - Clean up old caches
self.addEventListener("activate", function (event) {
    event.waitUntil(
        caches.keys().then(function (cacheNames) {
            return Promise.all(
                cacheNames.map(function (cache) {
                    if (cache !== CACHE_NAME) {
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
});
