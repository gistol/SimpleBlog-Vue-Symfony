<template>
    <div id="post">
        <h1>{{ post.title }}</h1>
        <div>{{ post.content }}</div>
        <div v-for="comment in post.comments">
            <p>{{ comment.content }}</p>
            <p>{{ comment.author.username }}</p>
            <p>{{ comment.published_at }}</p>
        </div>
        <form>

        </form>
   </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import Comments from './Comment';

    export default {
        components: {
            Comments
        },
        data() {
            return {
            }
        },
        computed: {
            ...mapGetters({
                post: 'post'
            })
        },
        created() {
            this.$store.dispatch('post', this.$route.params.slug);
        },
        methods: {

        }
    }
</script>

<style>

</style>
