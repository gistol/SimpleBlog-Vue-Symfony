<template>
    <div id="home">
        <header>
            <nav>
                <ul v-if="!logged">
                    <li><router-link to="/login">Login</router-link></li>
                    <li><router-link to="/register">Register</router-link></li>
                </ul>
                <ul v-else>
                    <li><button @click="logout">Logout</button></li>
                    <li v-if="roles === 'ROLE_ADMIN'"><router-link to="/admin">Admin panel</router-link></li>
                </ul>
            </nav>
        </header>
        <router-view :key="$route.fullPath" />

    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        watch: {
            logout() {
                this.$router.push({path: '/'})
            }
        },
        computed: {
            ...mapGetters({
                logged: 'logged',
                roles: 'roles'
            })
        },
        methods: {
            logout() {
                this.$store.dispatch('logout');
            },
        }
    }
</script>

<style scoped>

</style>
