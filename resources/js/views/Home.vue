<template>
    <div class="Home">
        <h1>Home</h1>
        <UserList></UserList>
    </div>
</template>

<script>
import UserList from '../components/UserList.vue'

export default {
    components: {
        UserList,
    },
}
</script>