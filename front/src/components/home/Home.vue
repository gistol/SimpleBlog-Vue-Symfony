<template>
    <div id="home">
        <p>{{ result }}</p>
        <input type="text" v-model="text">
        <button @click="fetchToApi">Send tu Api</button>
    </div>
</template>

<script>
    export default {
        name: "Home",
        data() {
            return {
                result: '',
                text: 'asd'
            }
        },
        methods: {
            fetchToApi() {
                //Wyślij coś
                this.$http.post('test', {
                    text: this.text
                })
                    .then(result => this.result = result.body)
                ;
            }
        }
    }
</script>

<style scoped>

</style>
