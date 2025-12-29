import './bootstrap';
import { createApp } from 'vue';
import router from './router';

import RoomComponent from './components/RoomComponent.vue';
import CreateRoom from './components/CreateRoom.vue';
import Home from './components/Home.vue';
import App from './App.vue';


const app = createApp({});

app.component('home-component', Home);
app.component('room-component', RoomComponent);
app.component('create-room', CreateRoom);

app.use(router);
app.mount('#app');
