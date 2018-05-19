<template>
    <div id="home">
        <p>{{ result }}</p>
        <button @click="fetchToApi">Send tu Api</button>
    </div>
</template>

<script>
    export default {
        name: "Home",
        data() {
            return {
                result: ''
            }
        },
        methods: {
            fetchToApi() {
                const data = new FormData();
                data.append('_username', 'test');
                data.append('_password', 'test');

                this.$http.post('http://127.0.0.1:8000/api/login_check', data)
                    .then(response => response.json())
                    .then(result => this.result = result)
                    .catch(error => this.result = error.body.message);
            }
        }
    }
</script>

<style scoped>

</style>
