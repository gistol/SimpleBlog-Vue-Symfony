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
                data: {
                    start: 0,
                    limit: 10,
                    id: this.$route.params.id
                },
            }
        },
        computed: {
            ...mapGetters({
                items: 'items',
                number: 'number',
            })
        },
        watch: {
            '$route'(to, from) {
                this.data.id = to.params.id;
                let id = this.data.id ? this.data.id : 1;

                if(id === 1) this.data.start =  0;
                else this.data.start = id * this.data.limit - 10;

                this.$store.dispatch('items', this.data);
            }
        },
        methods: {
            paginate(number) {
                const numbers = [];

                number /= this.data.limit;

                for(let i = 1; i <= Math.ceil(number); i++)
                    numbers.push(i);

                return numbers;
            },
        },
        created() {
            let id = this.data.id ? this.data.id : 1;

            if(id === 1) this.data.start =  0;
            else this.data.start = id * this.data.limit - 10;


            this.$store.dispatch('items', this.data);
        }
    }
</script>

<style>

</style>
