import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';
import DashboardMagang from './components/DashboardMagang.vue';

window.Alpine = Alpine;

Alpine.start();

const app = createApp({});
app.component('dashboard-magang', DashboardMagang);
app.mount('#app');
