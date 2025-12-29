<template>
    <div class="home">
        <!-- Metterai la route dopo -->
        <!-- <a href="/create-room">
            <button @click="$router.push({ path: '/create-room' })">Crea stanza</button>
        </a> -->
        <a class="main-button" href="/create-room">
            Crea stanza
        </a>
        <a class="secondary-button" href="/join">
            Unisciti ad una stanza
        </a>
    </div>
</template>

<script>
export default {
    name: 'Home'
};
</script>
