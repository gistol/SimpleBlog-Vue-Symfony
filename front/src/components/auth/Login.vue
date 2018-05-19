<template>
    <form @submit.prevent="login()">
        <input type="text" v-model="loginData._username" required>
        <input type="password" v-model="loginData._password" required>
        <button type="submit">Login</button>
    </form>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                loginData: {
                    _username: '',
                    _password: ''
                }
            }
        },
        watch: {
            logged() {
                this.$router.push({path: '/'});
            }
        },
        computed: {
            ...mapGetters({
                logged: 'logged'
            })
        },
        methods: {
            login() {
                this.$store.dispatch('login', this.loginData)
            }
        }
    }
</script>

<style scoped>

</style>
