<template>
    <div class="UserList">
        <h1>Users</h1>
        <div v-if="loading">
            Loading
        </div>
        <div v-else class="container">
            <div 
                v-for="user in users" 
                :key="user.id"
                class="user"
            >
                <router-link 
                    :to="{ name: 'user', params: { id: user.id }}"
                    class="link"
                >
                    <img src="../../../public/account_box.svg" alt="" /> {{ user.name }}
                </router-link>
            </div>
        </div>
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
                url: '/api/users',
            })
            this.users = response.data
            this.loading = false
        }
    }
}
</script>

<style scoped>
.container {
    background-color: white;
    width: 360px;
    font-size: 1rem;
    padding: 6px 0px;
}

.user {
    background-color: rgb(0 0 0 / 0%);
    transition: background-color 150ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
}

.user:hover {
    cursor: pointer;
    background-color: rgb(0 0 0 / 4%);
}

.link {
    text-decoration: none;
    color: rgb(0 0 0 / 87%);
    padding: 8px 16px;
    display: flex;
    align-items: center;
}

.link img {
    padding-right: 20px;
}
</style>