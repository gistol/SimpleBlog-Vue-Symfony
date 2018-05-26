<template>
    <div id="home">
        <header class="header">
            <nav class="container navbar navbar-expand-lg navbar-light bg-light">
                <h1>
                    <router-link class="navbar-brand" to="/">Simple blog by Ultra</router-link>
                </h1>
                <b-navbar-toggle target="nav"></b-navbar-toggle>

                <b-collapse is-nav id="nav">
                    <ul class="nav navbar-nav ml-auto ">
                        <li class="nav-item" v-if="!logged">
                            <router-link class="nav-link" to="/login">Login</router-link>
                        </li>
                        <li class="nav-item" v-if="!logged">
                            <router-link class="nav-link" to="/register">Register</router-link>
                        </li>
                        <li class="nav-item" v-if="logged">
                            <router-link class="nav-link" to="/">Homepage</router-link>
                        </li>
                        <li class="nav-item" v-if="roles === 'ROLE_ADMIN'">
                            <router-link class="nav-link" to="/admin">Admin panel</router-link>
                        </li>
                        <li class="nav-item" v-if="logged">
                            <button class="nav-link button-link" @click="logout">Logout</button>
                        </li>
                    </ul>
                </b-collapse>
            </nav>
        </header>
        <div class="container">
            <router-view :key="$route.fullPath" />
        </div>
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

<style>
    .header {
        background: #fff;
        margin-bottom: 20px;
    }

    .button-link {
        border: none;
        background: #fff;
        cursor: pointer;
    }
</style>
