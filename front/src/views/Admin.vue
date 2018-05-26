<template>
    <div id="admin">
        <router-link to="/">Homepage</router-link>
        <router-view :key="$route.fullPath" />
    </div>
</template>

<script>
    export default {

    }
</script>

<style scoped>

</style>
