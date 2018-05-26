<template>
    <div class="row justify-content-md-center">
        <div class="col col-6">
            <form class="card" @submit.prevent="login()">
                <header class="card-header">
                    <h2 class="text-center">Login account</h2>
                </header>
                <div class="card-body">
                    <div class="form-group">
                        <label for="username">Username: </label>
                        <input type="text" class="form-control" id="username" v-model="loginData.username" placeholder="Username" title="Your username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: </label>
                        <input type="password" class="form-control" id="password" v-model="loginData.password" placeholder="Password" title="Your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                loginData: {
                    username: '',
                    password: ''
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
