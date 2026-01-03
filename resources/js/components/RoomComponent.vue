<template>
    <div class="component-room">
        <h1>Stanza {{ roomCode }}</h1>
        <ul>
            <li v-for="player in players" :key="player.id" @click="selectPlayer(player.id)"
                :class="{ 'player-eliminate': selectedPlayerId === player.id }">
                {{ player.name }} - {{ player.role }}
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        roomCode: String,
    },
    data() {
        return {
            players: [],
            selectedPlayerId: null,
        };
    },
    mounted() {
        this.fetchPlayers();
        setInterval(this.fetchPlayers, 5000);
    },
    methods: {
        async fetchPlayers() {
            try {
                const response = await axios.get(`/room/${this.roomCode}/players`);
                this.players = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        selectPlayer(playerId) {
            if (this.selectedPlayerId === playerId) {
                this.selectedPlayerId = null;
            } else {
                this.selectedPlayerId = playerId;
            }
        }
    },
};
</script>
