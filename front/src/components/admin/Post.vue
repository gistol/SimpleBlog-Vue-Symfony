<template>
    <div class="row justify-content-md-center">
        <div class="col col-10">
            <form class="card" @submit.prevent="register()">
                <header class="card-header">
                    <h2 class="text-center">Post form</h2>
                </header>
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Post title: </label>
                        <input type="text"  class="form-control" id="title"  v-model="post.title"  placeholder="Post title" title="Post title" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Post content: </label>
                        <textarea class="form-control" id="content" v-model="post.content" rows="7"  placeholder="Post content" title="Post content" required></textarea>
                    </div>
                    <button class="btn btn-success" @click="save">Save</button>
                </div>
            </form>
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
                post: 'post',
                refreshPost: 'refreshPost'
            })
        },
        watch: {
            refreshPost() {
                this.$router.push({path: '/admin'})
            }
        },
        methods: {
            save() {
                if(this.post.slug) {
                    this.$store.dispatch('updatePost', this.post)
                } else {
                    this.$store.dispatch('createPost', this.post)
                }
            }
        },
        created() {
            if(this.$route.params.slug)
                this.$store.dispatch('post', this.$route.params.slug);
        }
    }
</script>

<style scoped>

</style>
