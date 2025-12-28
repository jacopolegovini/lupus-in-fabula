import './bootstrap';
import { createApp } from 'vue';
import RoomComponent from './components/RoomComponent.vue';

const app = createApp({});

app.component('room-component', RoomComponent);
app.mount('#app');
