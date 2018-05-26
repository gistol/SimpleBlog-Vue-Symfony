<template>
    <div id="admin">
        <header class="header">
            <nav class="container navbar navbar-expand-lg navbar-light bg-light">
                <h1>
                    <router-link class="navbar-brand" to="/">Simple blog by Ultra</router-link>
                </h1>
                <div class="nav">
                    <ul class="nav navbar-nav">
                        <li class="nav-item">
                            <router-link class="nav-link" to="/">Admin panel</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/">Homepage</router-link>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="container">
            <router-view :key="$route.fullPath" />
        </div>
    </div>
</template>

<script>
    export default {

    }
</script>

<style scoped>

</style>
