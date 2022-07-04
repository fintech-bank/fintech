const BASE = location.protocol + "//" + location.host;
const PREFIX = "V10"
const CACHED_FILES = [
    "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700",
    "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css",
    BASE+"/assets/plugins/global/plugins.bundle.css",
    BASE+"/assets/css/style.bundle.css",
    "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"
]

self.addEventListener('install', (event) => {
    self.skipWaiting()
    event.waitUntil(
        (async () => {
            const cache = await caches.open(PREFIX);
            await cache.addAll([...CACHED_FILES, "/customer/offline"]);
        })()
    );
    console.log(`${PREFIX} Install`);
})

self.addEventListener('activate', (event) => {
    clients.claim()
    event.waitUntil(
        (async () => {
            const keys = await caches.keys();
            await Promise.all(
                keys.map((key) => {
                    if (!key.includes(PREFIX)) {
                        return caches.delete(key);
                    }
                })
            );
        })()
    );
    console.log(`${PREFIX} Active`)
})

self.addEventListener('fetch', (event) => {
    console.log(`${PREFIX} Fetching : ${event.request.url} , Mode: ${event.request.mode}`)
    if (event.request.mode == 'navigate') {
        event.respondWith(
            (async () => {
                try {
                    const preloadResponse = await event.preloadResponse
                    if (preloadResponse) {
                        return preloadResponse
                    }

                    return await fetch(event.request)
                }catch (e) {
                    const cache = await caches.open(PREFIX);
                    return await cache.match("/customer/offline");
                }
            })()
        )
    } else {
        event.respondWith(caches.match(event.request));
    }
});

self.addEventListener('push', function (e) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        //notifications aren't supported or permission not granted!
        return;
    }

    if (e.data) {
        var msg = e.data.json();
        console.log(msg)
        e.waitUntil(self.registration.showNotification(msg.title, {
            body: msg.body,
            icon: msg.icon,
            actions: msg.actions
        }));
    }
});
