<template>
    <div class="row justify-content-md-center">
        <div class="col col-6">
            <form class="card" @submit.prevent="register()">
                <header class="card-header">
                    <h2 class="text-center">Register on the blog</h2>
                </header>
                <div class="card-body">
                    <div class="form-group">
                        <label for="username">Username: </label>
                        <input type="text"  class="form-control" id="username"  v-model="registerData.username"  placeholder="Username" title="Your username" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Name: </label>
                        <input type="text"  class="form-control" id="name"  v-model="registerData.name"  placeholder="Name" title="Your name" required>
                    </div>
                    <div class="form-group">
                        <label for="surname">Surname: </label>
                        <input type="text"  class="form-control" id="surname"  v-model="registerData.surname"  placeholder="Surname" title="Your surname" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: </label>
                        <input type="text"  class="form-control" id="email"  v-model="registerData.email"  placeholder="Email" title="Your email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: </label>
                        <input type="text"  class="form-control" id="password"  v-model="registerData.password"  placeholder="Password" title="Your password" required>
                    </div>
                    <button type="submit" class="btn btn-success">Register</button>
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
