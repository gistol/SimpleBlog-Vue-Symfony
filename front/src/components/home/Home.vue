<template>
    <div id="home">
        <div v-for="post in posts">
            <h2><router-link :to="'/post/' + post.slug">{{ post.title }}</router-link></h2>
            <p>{{ post.content }}</p>
        </div>
        <ul>
            <li v-for="key in paginate(number)">
                <router-link :to="'/posts/' + key">{{ key }}</router-link>
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
            })
        },
        created() {
            this.getPosts(this.$route.params.id);
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
            paginate(number) {
                const numbers = [];

                number /= this.limit;

                for(let i = 1; i <= Math.ceil(number); i++)
                    numbers.push(i);

                return numbers;
            }
        }
    }
</script>

<style>

</style>
