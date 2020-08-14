<template>
    <div class="Todos">
        <h1>todos</h1>
        <div class="wrapper">
            <div class="header">
                <input 
                    v-model="description"
                    v-on:keyup.enter="onEnter"
                    placeholder="What needs to be done?"
                />
            </div>
            <Todo v-for="todo in todos" v-bind:todo="todo" :key="todo.id"></Todo>
            <footer>
                <div class="left">
                    item left
                </div>
                <div class="middle">
                    <div>All</div>
                    <div>Active</div>
                    <div>Completed</div>
                </div>
                <div class="right">
                    Clear completed
                </div>
            </footer>
        </div>
    </div>
</template>

<script>
import Todo from './Todo.vue'

export default {
    data () {
        return {
            description: '',
        }
    },
    props: {
        todos: Array,
    },
    components: {
        Todo,
    },
    computed: {
        empty: function () {
            return 0 === this.todos.length
        },
    },
    methods: {
        onEnter: async function () {
            if ('' === this.description) return

            try {
                const response = await axios({
                    method: 'post',
                    url: '/api/todos',
                    data: {
                        description: this.description,
                        user_id: this.$route.params.id,
                    },
                })

                this.todos.push(response.data)
                this.description = ''
            } catch (error) {
                if (error.response) {
                    console.log(error.response.data.message)
                }
            }
        }
    }
}
</script>

<style scoped>
.Todos {
    max-width: 450px;
    margin: 0 auto;
    text-align: center;
    color: rgba(0,0,0,.5);
}

.wrapper {
    box-shadow: 2px 4px 5px 0px rgba(184,184,184,1);
    background: white;
    font-size: 1.5rem;
}

h1 {
    font-size: 100px;
    color:tomato;
    margin: 10px 0px;
    font-weight: lighter;
}

.header input {
    height: 60px;
    padding-left: 60px;
    width: 100%;
    border: none;
    font-weight: lighter;
    box-sizing: border-box;
    font-size: inherit;
}

.header input::placeholder {
    color: rgba(0,0,0,.2)
}

footer {
    height: 30px;
    display: flex;
    align-items: center;
    font-size: 1rem;
}

footer .left {
    flex-basis: 25%;
}
footer .middle {
    flex-basis: 50%;
    display: flex;
    justify-content: space-around;
}
footer .right {
    flex-basis: 25%;
}
</style>