<template>
    <div class="component-room">
        <h1>Stanza {{ roomCode }}</h1>
        <ul>
            <li v-for="player in players" :key="player.id" @click="selectPlayer(player.id)"
                :class="{ 'player-eliminate': selectedPlayerIds.includes(player.id) }">
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
            selectedPlayerIds: [],
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
            const index = this.selectedPlayerIds.indexOf(playerId);

            if (index === -1) {
                this.selectedPlayerIds.push(playerId);
            } else {
                this.selectedPlayerIds.splice(index, 1);
            }
        }
    },
};
</script>
