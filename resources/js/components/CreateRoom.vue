<template>
    <div class="create-room">
        <h1>Creazione Stanza</h1>

        <form @submit.prevent="createRoom">
            <label>
                Max giocatori:
                <input type="number" v-model.number="maxPlayers" min="2" />
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
                Meretrici:
                <input type="number" v-model.number="maxMeretrici" min="0" />
            </label>
            <label>
                Contadini:
                <input type="number" v-model.number="maxContadini" min="0" />
            </label>

            <button class="main-button" type="submit">Crea stanza</button>
        </form>

        <div v-if="message">
            <p>{{ message }}</p>
            <a v-if="showMessage" :href="'/room/' + code">
                <button class="secondary-button">Entra come narratore</button>
            </a>
        </div>
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
            maxMeretrici: 1,
            maxContadini: 4,
            message: '',
            code: '',
            showMessage: false,
        };
    },

    watch: {
        maxPlayers(newValue) {
            this.adjustRoles(newValue);
        }
    },

    methods: {
        adjustRoles(players) {
            // Almeno 1 lupo se ci sono >= 2 giocatori
            const maxLupi = players >= 2
                ? Math.max(1, Math.floor(players / 4))
                : 0;

            const maxVeggenti = players >= 3 ? 1 : 0;
            const maxMeretrici = players >= 5 ? 1 : 0;

            const used = maxLupi + maxVeggenti + maxMeretrici;

            this.maxLupi = maxLupi;
            this.maxVeggenti = maxVeggenti;
            this.maxMeretrici = maxMeretrici;
            this.maxContadini = Math.max(0, players - used);
        },


        async createRoom() {
            try {
                const response = await axios.post('/create-room', {
                    max_players: this.maxPlayers,
                    max_lupi: this.maxLupi,
                    max_veggenti: this.maxVeggenti,
                    max_meretrici: this.maxMeretrici,
                    max_contadini: this.maxContadini,
                    code: this.code,
                });

                this.showMessage = true;
                this.code = response.data;

                this.message = "Stanza creata! Codice: " + response.data;
            } catch (error) {
                this.message = 'Errore nella creazione della stanza';
            }
        }
    },

    mounted() {
        this.adjustRoles(this.maxPlayers);
    }
};

</script>
