<template>
    <div id="post">
        <h1>{{ post.title }}</h1>
        <div>{{ post.content }}</div>
        <div>
            <p>{{ contentWrong }}</p>
            <textarea v-model="content"></textarea>
            <button @click="addComment">Add comment</button>
        </div>
        <div v-for="comment in post.comments">
            <p>{{ comment.content }}</p>
            <p>{{ comment.author.username }}</p>
            <p>{{ comment.published_at }}</p>
        </div>
   </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                content: '',
                contentWrong: ''
            }
        },
        computed: {
            ...mapGetters({
                post: 'post',
                refreshComment: 'refreshComment'
            })
        },
        watch: {
            refreshComment () {
                this.$store.dispatch('post', this.$route.params.slug);
            }
        },
        methods: {
            addComment() {
                if(this.content.length >= 15) {
                    this.$store.dispatch('addComment', {
                        content :this.content,
                        slug: this.$route.params.slug
                    });
                    this.content = '';
                    this.contentWrong = '';
                } else {
                    this.contentWrong = 'The comment must be at least 15 characters long';
                }
            }
        },
        created() {
            this.$store.dispatch('post', this.$route.params.slug);
        }
    }
</script>

<style>

</style>
