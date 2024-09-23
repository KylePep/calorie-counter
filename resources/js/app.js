import '@mdi/font/css/materialdesignicons.css'
import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'CalorieCount';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    // resolve: (name) => {
    //     const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    //     let page = pages[`./Pages/${name}.vue`]
    //     page.default.layout = name.startsWith('Public/') ? undefined : AuthenticatedLayout
    //     return page
    // },
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component("Link", Link)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
