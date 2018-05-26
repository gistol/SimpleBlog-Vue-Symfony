<template>
    <div id="home">
        <article>
            <section class="card" v-for="post in posts">
                <header class="card-header text-center">
                    <h2 class="card-title"><router-link :to="'/post/' + post.slug">{{ post.title }}</router-link></h2>
                </header>
                <div class="card-body">
                    <p class="card-text">{{ post.content }}</p>
                </div>
                <div class="card-footer text-center">
                    <router-link class="btn btn-primary center" :to="'/post/' + post.slug">Read more</router-link>
                </div>
            </section>
        </article>
        <nav>
            <ul class="pagination">
                <li class="page-item" :class="{ disabled:id === 1 || $route.params.id === undefined }">
                    <router-link class="page-link" :to="'/posts/' + (id - 1)">Prev</router-link>
                </li>
                <li class="page-item" v-for="key in paginate(number)" :class="{ active: parseInt(key) === id }">
                    <router-link class="page-link" :to="'/posts/' + key">{{ key }}</router-link>
                </li>
                <li class="page-item" :class="{ disabled: id === Math.ceil(number / limit) }">
                    <router-link class="page-link" :to="'/posts/' + (id + 1)">Next</router-link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                id: this.$route.params.id !== undefined ? parseInt(this.$route.params.id) : 1,
                limit: 10
            }
        },
        computed: {
            ...mapGetters({
                posts: 'posts',
                number: 'number',
            })
        },
        watch: {
            posts() {
                this.limitContent();
            }
        },
        created() {
            this.getPosts(this.id);
            window.scrollTo(0, 0)
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
            },
            limitContent() {
                this.posts.forEach(post => {
                    if(post.content.length > 150) {
                        post.content = post.content.substring(0, 150);
                        post.content += ' ...'
                    }
                })
            }
        }
    }
</script>

<style>
    .card {
        margin-bottom: 60px;
    }
</style>
