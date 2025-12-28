import './bootstrap';
import { createApp } from 'vue';
import RoomComponent from './components/RoomComponent.vue';
import CreateRoom from './components/CreateRoom.vue';

const app = createApp({});

app.component('room-component', RoomComponent);
app.component('create-room', CreateRoom);
app.mount('#app');
