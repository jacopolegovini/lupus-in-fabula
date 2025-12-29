<template>
    <div class="join">
        <div v-if="!chosenRole">
            <form @submit.prevent="joinRoom">
                <input v-model="name" placeholder="Nome">
                <input v-model="code" placeholder="Codice stanza">
                <button class="main-button">Entra</button>
            </form>
        </div>
        <div v-else>
            <p>{{ role }}</p>
        </div>
    </div>
</template>


<script>
import axios from 'axios';

export default {
    name: 'Join',

    data() {
        return {
            name: '',
            code: '',
            chosenRole: false,
            role: '',
        };
    },

    methods: {
        async joinRoom() {
            try {
                const response = await axios.post('/join', {
                    name: this.name,
                    code: this.code,
                });
                this.chosenRole = true;
                this.role = response.data;
                // alert(response.data);
            } catch (error) {
                alert('Errore durante l\'accesso alla stanza');
            }
        }
    }
};
</script>
