<template>
    <div id="home">
        <h1>{{ item.title }}</h1>
        <div>{{ item.content }}</div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
            }
        },
        computed: {
            ...mapGetters({
                item: 'item'
            })
        },
        created() {
            this.$store.dispatch('item', this.$route.params.slug);
        }
    }
</script>

<style>

</style>
