<template>
    <div id="post">
        <article>
            <header>
                <h2 class="h1 text-center">{{ post.title }}</h2>
            </header>
            <p>{{ post.content }}</p>
        </article>

        <article>
            <div>
                <p>{{ contentWrong }}</p>
                <div class="form-group">
                    <label for="content">Comment content: </label>
                    <textarea class="form-control" id="content" title="Comment content" placeholder="Comment content" rows="6" v-model="content"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" @click="addComment">Add comment</button>
                </div>
            </div>
            <section class="card card-body" v-for="comment in post.comments">
                <p>{{ comment.content }}</p>
                <footer content="card-footer">
                    <p class="">{{ comment.author.username }}</p>
                    <time :datetime="comment.published_at">{{ comment.published_at }}</time>
                </footer>
            </section>
        </article>
   </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                content: '',
                contentWrong: '',
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
