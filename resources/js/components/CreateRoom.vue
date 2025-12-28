<template>
    <div class="create-room">
        <h1>Crea Stanza</h1>

        <form @submit.prevent="createRoom">
            <label>
                Max giocatori:
                <input type="number" v-model.number="maxPlayers" min="1" />
            </label>
            <label>
                Lupi:
                <input type="number" v-model.number="maxLupi" min="0" />
            </label>
            <label>
                Veggenti:
                <input type="number" v-model.number="maxVeggenti" min="0" />
            </label>
            <label>
                Contadini:
                <input type="number" v-model.number="maxContadini" min="0" />
            </label>

            <button type="submit">Crea stanza</button>
        </form>

        <p v-if="message">{{ message }}</p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            maxPlayers: 8,
            maxLupi: 2,
            maxVeggenti: 1,
            maxContadini: 5,
            message: ''
        };
    },
    methods: {
        async createRoom() {
            try {
                const response = await axios.post('/create-room', {
                    max_players: this.maxPlayers,
                    max_lupi: this.maxLupi,
                    max_veggenti: this.maxVeggenti,
                    max_contadini: this.maxContadini
                });
                this.message = "Stanza creata! Codice: " + response.data;
            } catch (error) {
                this.message = 'Errore nella creazione della stanza';
                console.error(error);
            }
        }
    }
};
</script>
