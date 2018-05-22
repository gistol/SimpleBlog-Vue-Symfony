<template>
    <div id="home">
        <div v-for="item in items">
            <h2>{{ item.title }}</h2>
            <p>{{ item.content }}</p>
        </div>
        <ul>
            <li v-for="key in paginate(number)">
                <router-link :to="'/' + key">{{ key }}</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name: "Home",
        data() {
            return {
                limit: 10
            }
        },
        computed: {
            ...mapGetters({
                items: 'items',
                number: 'number',
            })
        },
        created() {
            this.loadPosts(this.$route.params.id);
        },
        methods: {
            loadPosts(id) {
                const data = {
                    limit: this.limit
                };
                if (id > 1)
                    data.start = id * data.limit - 10;
                else
                    data.start = 0;

                this.$store.dispatch('items', data);
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
