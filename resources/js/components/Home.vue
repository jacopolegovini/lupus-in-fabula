<template>
    <div class="home">
        <!-- <a href="/create-room">
            <button @click="$router.push({ path: '/create-room' })">Crea stanza</button>
        </a> -->
        <a href="/create-room">
            <button>Crea stanza</button>
        </a>
        <a href="/join">
            <button>Unisciti ad una stanza</button>
        </a>
    </div>
</template>

<script>
export default {
    name: 'Home'
};
</script>
