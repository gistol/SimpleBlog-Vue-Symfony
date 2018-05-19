<template>
    <div id="home">
        <header>
            <nav>
                <ul>
                    <li><router-link to="/login">Login</router-link></li>
                    <li><router-link to="/register">Register</router-link></li>
                </ul>
            </nav>
        </header>
        <router-view/>
    </div>
</template>

<script>
    export default {

    }
</script>

<style scoped>

</style>
