<template>
    <div class="User">
        <h1>User</h1>
        <div v-if="loading">
            Loading...
        </div>
        <div v-else>
            {{ user.name }}
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            loading: false,
            user: null,
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
            this.error = this.user = null
            this.loading = true
            const response = await axios({
                url: `/api/users/${this.$route.params.id}`,
            })
            this.user = response.data
            this.loading = false
        }
    }
}
</script>