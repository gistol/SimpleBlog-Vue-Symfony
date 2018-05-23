<template>
    <div id="home">
        <div v-for="comment in comments">
            {{ comment.content }}
            {{ comment.author.username }}
        </div>
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
                comments: 'comments'
            })
        },
        created() {
            this.$store.dispatch('comments', this.$route.params.slug);
        }
    }
</script>

<style>

</style>
