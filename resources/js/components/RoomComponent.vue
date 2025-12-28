<template>
    <div>
        <h1>Stanza {{ roomCode }}</h1>
        <ul>
            <li v-for="player in players" :key="player.id">
                {{ player.name }} - {{ player.role }}
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    roomCode: String,
});

console.log('roomCode:', props.roomCode);

const players = ref([]);

const fetchPlayers = async () => {
    try {
        const response = await axios.get(`/room/${props.roomCode}/players`);
        players.value = response.data;
    } catch (error) {
        console.error(error);
    }
};

onMounted(() => {
    fetchPlayers();
    setInterval(fetchPlayers, 5000); // aggiorna ogni 5 secondi
});
</script>
