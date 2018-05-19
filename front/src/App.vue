<template>
    <div id="app">
        <!--<Home/>-->
        <Login/>
    </div>
</template>

<script>

    import Home from "./components/Home";
    import Login from "./components/auth/Login";

    export default {
        name: 'app',
        components: {
            Home,
            Login
        }
    }
</script>

<style>

</style>
