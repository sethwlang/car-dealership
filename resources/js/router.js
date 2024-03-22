// Import Vue and Vue Router
import { createRouter, createWebHistory } from 'vue-router';

// Import your Vue components
import CarSearch from './components/CarSearch.vue';
import DealerPage from './components/DealerPage.vue';

// Define your routes
const routes = [
  { path: '/', component: CarSearch },
  { path: '/dealers', component: DealerPage }
];

// Create a router instance
const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
