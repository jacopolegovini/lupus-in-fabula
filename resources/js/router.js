import { createRouter, createWebHistory } from 'vue-router';
import Home from './components/Home.vue';
import CreateRoom from './components/CreateRoom.vue';
import RoomComponent from './components/RoomComponent.vue';

const routes = [
    { path: '/', component: Home },
    { path: '/create-room', component: CreateRoom },
    { path: '/room/:code', component: RoomComponent },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
