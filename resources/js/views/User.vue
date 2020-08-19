<template>
    <div class="User">
        <h1 v-if="user">{{ user.name }}</h1>
        <Todos 
            v-bind:todos="todos"
            v-bind:loading="loading"
            v-on:remove="onRemove"
            v-on:toggle="onToggle"
            v-on:refresh="refresh"
        ></Todos>
    </div>
</template>

<script>
import Todos from '../components/Todos.vue'

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
    components: {
        Todos,
    },
    watch: {
        '$route': 'fetchData',
    },
    computed: {
        todos: function () {
            return null === this.user ? [] : this.user.todos
        },
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
        },
        async refresh () {
            const response = await axios({
                url: `/api/users/${this.$route.params.id}`,
            })
            this.user = response.data
        },
        onRemove: function (todo) {
            this.user.todos = this.user.todos.filter(e => e !== todo)
        },
        onToggle: function (id, toggled) {
            this.user.todos = this.user.todos.map(todo => {
                if (id === todo.id) {
                    return {...todo, completed: toggled}
                }

                return todo
            })
        },
    }
}
</script>