<template>
    <div class="Todos">
        <h1>todos</h1>
        <div class="wrapper">
            <div class="header">
                <div 
                    class="toggleAll"
                    v-if="!empty"
                    v-on:click="updateMultiple"
                >
                    ❯
                </div>
                <input 
                    v-model="description"
                    v-on:keyup.enter="onEnter"
                    placeholder="What needs to be done?"
                />
            </div>
            <div 
                v-if="loading"
                class="todoLoder"
            >
                loading...
            </div>
            <div v-if="'all' === filter">
                <Todo 
                    v-for="todo in todos" 
                    v-bind:todo="todo" 
                    v-on="$listeners"
                    :key="todo.id"
                ></Todo>
            </div>
            <div v-else-if="'active' === filter">
                <Todo 
                    v-for="todo in active" 
                    v-bind:todo="todo" 
                    v-on="$listeners"
                    :key="todo.id"
                ></Todo>
            </div>
            <div v-else-if="'completed' === filter">
                <Todo 
                    v-for="todo in completed" 
                    v-bind:todo="todo" 
                    v-on="$listeners"
                    :key="todo.id"
                ></Todo>
            </div>
            <footer v-if="!empty">
                <div class="left">
                    {{ itemsLeft }} item{{ 1 !== itemsLeft ? 's' : '' }} left
                </div>
                <div class="middle">
                    <button 
                        v-on:click="setFilter('all')"
                        v-bind:class="{ selected: 'all' === filter}"
                    >
                        All
                    </button>
                    <button 
                        v-on:click="setFilter('active')"
                        v-bind:class="{ selected: 'active' === filter}"
                    >
                        Active
                    </button>
                    <button 
                        v-on:click="setFilter('completed')"
                        v-bind:class="{ selected: 'completed' === filter}"
                    >
                        Completed
                    </button>
                </div>
                <div class="right">
                    <button
                        v-on:click="clearCompleted"
                    >
                        Clear completed
                    </button>
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
            filter: 'all',
        }
    },
    props: {
        todos: Array,
        loading: Boolean,
    },
    components: {
        Todo,
    },
    computed: {
        empty: function () {
            return 0 === this.todos.length
        },
        itemsLeft: function () {
            let remaining = 0
            for (var i = 0; i < this.todos.length; i++) {
                let todo = this.todos[i]
                if (!todo.completed) remaining ++
            }
            return remaining
        },
        active: function () {
            return this.todos.filter(todo => !todo.completed)
        },
        completed: function () {
            return this.todos.filter(todo => todo.completed)
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
        },
        updateMultiple: async function () {
            try {
                let toggle = 0
                const ids = this.todos.map(todo => {
                    if (0 === toggle && 0 === todo.completed) {
                        toggle = 1
                    }
                    return todo.id
                })

                const response = await axios({
                    method: 'put',
                    url: `/api/todos/multiple`,
                    data: {
                        ids,
                        completed: toggle,
                    },
                })

                this.$emit('refresh')
            } catch (error) {
                if (error.response) {
                    console.log(error.response.data.message)
                }
            }
        },
        clearCompleted: async function () {
            try {
                const ids = this.todos.filter(todo => todo.completed).map(todo => todo.id)
                if (0 === ids.length) return

                const response = await axios({
                    method: 'delete',
                    url: '/api/todos/multiple',
                    data: {
                        ids,
                    }
                })

                this.$emit('refresh');
            } catch (error) {
                if (error.response) {
                    console.log(error.response.data.message)
                }
            }
        },
        setFilter: function (filter) {
            this.filter = filter
        },
    }
}
</script>

<style scoped>
.Todos {
    max-width: 550px;
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
    color: rgb(150 77 69 / 23%);
    margin: 10px 0px;
    font-weight: lighter;
}

.header {
    position: relative;
    background: rgb(116 116 191 / 1%);
}

.header .toggleAll {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translate(0%, -50%) rotate(90deg);
    cursor: default;
}

header .toggleAll:hover {
    cursor: inherit;
    user-select: none;
}

.header input {
    height: 60px;
    margin-left: 60px;
    width: calc(100% - 60px);
    border: none;
    font-weight: lighter;
    box-sizing: border-box;
    font-size: inherit;
    background: rgb(116 116 191 / 1%);
}

.header input::placeholder {
    color: rgba(0,0,0,.2)
}

footer {
    display: flex;
    align-items: center;
    font-size: 0.9rem;
    flex-wrap: nowrap;
    padding: 5px 15px;
    box-shadow:
    /* The top layer shadow */
    0 1px 1px rgba(0,0,0,0.15),
    /* The second layer */
    0 10px 0 -5px #eee,
    /* The second layer shadow */
    0 10px 1px -4px rgba(0,0,0,0.15),
     /* The third layer */
    0 20px 0 -10px #eee,
    /* The third layer shadow */
    0 20px 1px -9px rgba(0,0,0,0.15);
}

footer .left {
    text-align: left;
    flex-basis: 25%;
}

footer .middle {
    flex-basis: 50%;
    display: flex;
    justify-content: center;
}

footer .middle > :nth-child(2) {
    margin-left: 15px;
    margin-right: 15px;
}

footer .right {
    flex-basis: 25%;
    text-align: right;
}

footer button {
    border: none;
    background: none;
    color: inherit;
    font-size: inherit;
    white-space: nowrap;
    border-radius: 4px;
}

footer button:hover {
    cursor: pointer;
}

footer .middle button {
    border: 1px solid rgba(255, 255, 255, 0);
    padding: 4px 6px;
}

footer .middle button:hover:not(.selected) {
    border-color: rgb(150 77 69 / 15%);
}

footer .middle button.selected {
    border-color: rgb(150 77 69 / 23%);
}

footer .right button {
    padding: 0px;
}

footer .right button:hover {
    text-decoration: underline;
}

.todoLoader {
    height: 60px;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

@media screen and (max-width: 430px) {
    footer {
        flex-wrap: wrap;
    }

    footer .left {
        flex-basis: 50%;
    }

    footer .middle {
        flex-basis: 100%;
        order: 3;
    }

    footer .right {
        flex-basis: 50%;
        order: 2;
    }
}
</style>