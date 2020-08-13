<template>
    <div class="UserList">
        <h1>Users</h1>
        <ul>
            <li v-for="user in users" :key="user.id">
                <router-link :to="{ name: 'user', params: { id: user.id }}">{{ user.name }}</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data () {
        return {
            loading: false,
            users: null,
            error: null,
        }
    },
    created () {
        this.fetchData()
    },
    watch: {
        '$route': 'fetchData',
    },
    methods: {
        async fetchData () {
            this.error = this.users = null
            this.loading = true
            const response = await axios({
                url: '/users',
            })
            this.users = response.data
        }
    }
}
</script>