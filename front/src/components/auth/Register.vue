<template>
    <form @submit.prevent="register()">
        <input type="text" v-model="registerData.username" required>
        <input type="text" v-model="registerData.name" required>
        <input type="text" v-model="registerData.surname" required>
        <input type="email" v-model="registerData.email" required>
        <input type="password" v-model="registerData.password" required>
        <button type="submit">Register</button>
    </form>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                registerData: {
                    username: '',
                    name: '',
                    surname: '',
                    email: '',
                    password: ''
                }
            }
        },
        watch: {
            registered() {
                this.$router.push({path: '/login'});
            }
        },
        computed: {
            ...mapGetters({
                registered: 'registered'
            })
        },
        methods: {
            register() {
                this.$store.dispatch('register', this.registerData)

            }
        }
    }
</script>

<style scoped>

</style>
