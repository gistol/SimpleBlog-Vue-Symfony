<template>
    <div>
        <input type="text" v-model="post.title">
        <textarea v-model="post.content"></textarea>
        <button @click="save">Create post</button>
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
                console.log('asdasdasd')
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
