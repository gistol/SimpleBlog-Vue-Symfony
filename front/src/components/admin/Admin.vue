<template>
    <div>
        <router-link to="/admin/post/add" class="btn btn-success">Add new post</router-link>
        <table class="table table-striped table-bordered text-center table-hover">
            <thead  class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="post in posts">
                    <td>{{ post.id }}</td>
                    <td>{{ post.title }}</td>
                    <td>
                        <router-link class="btn btn-info" :to="'/admin/post/edit/' + post.slug">Edit</router-link>
                    </td>
                    <td>
                        <button class="btn btn-danger" @click="deletePost(post.slug)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <ul>
            <li v-for="key in paginate(number)">
                <router-link :to="'/admin/posts/' + key">{{ key }}</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                limit: 10
            }
        },
        computed: {
            ...mapGetters({
                posts: 'posts',
                number: 'number',
                refreshPost: 'refreshPost'
            })
        },
        watch: {
            refreshPost() {
                this.getPosts(this.$route.params.id);
            }
        },
        methods: {
            getPosts(id) {
                const data = {limit: this.limit};

                if (id > 1)
                    data.start = id * data.limit - 10;
                else
                    data.start = 0;

                this.$store.dispatch('posts', data);
            },
            deletePost(slug) {
                this.$store.dispatch('deletePost', slug);
            },
            paginate(number) {
                const numbers = [];

                number /= this.limit;

                for(let i = 1; i <= Math.ceil(number); i++)
                    numbers.push(i);

                return numbers;
            }
        },
        created() {
            this.getPosts(this.$route.params.id);
        }
    }
</script>

<style scoped>
    .btn-success {
        margin-bottom: 15px;
    }
</style>
