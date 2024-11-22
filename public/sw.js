const filesToCache = [
    '/',
    '/offline.html'
];

const preLoad = function () {
    return caches.open("offline").then(function (cache) {
        return cache.addAll(filesToCache);
    });
};

self.addEventListener("install", function (event) {
    event.waitUntil(preLoad());
});

const checkResponse = function (request) {
    return fetch(request).then(function (response) {
        if (response.status !== 404) {
            return response;
        } else {
            throw new Error("Not Found");
        }
    });
};

const addToCache = function (request) {
    return caches.open("offline").then(function (cache) {
        return fetch(request).then(function (response) {
            if (response.ok) {
                return cache.put(request, response.clone());
            }
        });
    });
};

const returnFromCache = function (request) {
    return caches.open("offline").then(function (cache) {
        return cache.match(request).then(function (matching) {
            return matching || cache.match("/offline.html");
        });
    });
};

self.addEventListener("fetch", function (event) {
    if (event.request.url.startsWith("http")) {
        event.respondWith(
            checkResponse(event.request).catch(function () {
                return returnFromCache(event.request);
            })
        );

        event.waitUntil(addToCache(event.request));
    } else {
        console.warn("Unsupported request scheme:", event.request.url);
    }
});