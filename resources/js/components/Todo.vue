<template>
    <div class="Todo">
        <div 
            class="left"
            v-bind:class="{ editing: !shielded, completed: todo.completed }"
            v-on:click="onToggle"
        ></div>
        <div class="right">
            <input 
                v-model="description" 
                v-bind:class="{ editing: !shielded, completed: todo.completed }" 
                ref="input"
                v-on:blur="onBlur"
                v-on:keyup.esc="onEsc"
                v-on:keyup.enter="onEnter"
            />
            <div 
                class="shield" 
                v-bind:class="{ editing: !shielded }"
                v-on:dblclick="onDblClick"
            >
                <div
                    v-on:click="onRemove"
                    v-on:dblclick="preventPropagation"
                    class="destroy"
                >
                    ✕
                    <div class="screen"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            shielded: true,  
            description: this.todo.description,
            preDescription: this.todo.description,
        }
    },
    props: {
        todo: Object,
    },
    computed: {
        changes: function () {
            return this.description !== this.preDescription
        },
    },
    methods: {
        onDblClick: function () {
            this.shielded = false
            this.$refs.input.focus()
        },
        onBlur: function () {
            if (this.changes) {
                this.onEnter()
            } else {
                this.shielded = true
            }
        },
        onEsc: function () {
            if (this.changes) {
                this.description = this.preDescription
            }

            this.$refs.input.blur()
        },
        onEnter: async function () {
            if (!this.changes) {
                this.$refs.input.blur()
                return
            }

            try {
                const response = await axios({
                    method: 'put',
                    url: `/api/todos/${this.todo.id}`,
                    data: {
                        description: this.description,
                    },
                })

                this.preDescription = this.description
                this.$refs.input.blur()
            } catch (error) {
                if (error.response) {
                    console.log(error.response.data.message)
                }
            }
        },
        onRemove: async function(e) {
            try {
                const response = await axios({
                    method: 'delete',
                    url: `/api/todos/${this.todo.id}`,
                })

                this.$emit('remove', this.todo)
            } catch (error) {
                if (error.response) {
                    console.log(error.response.data.message)
                }
            }
        },
        onToggle: async function(e) {
            try {
                const toggled = this.todo.completed ? 0 : 1

                const response = await axios({
                    method: 'put',
                    url: `/api/todos/${this.todo.id}`,
                    data: {
                        description: this.description,
                        completed: toggled,
                    },
                })

                this.$emit('toggle', this.todo.id, toggled)
            } catch (error) {
                if (error.response) {
                    console.log(error.response.data.message)
                }
            }
        },
        preventPropagation: function(e) {
            e.stopPropagation()
        },
    }
}
</script>

<style scoped>
.Todo {
    height: 60px;
    width: 100%;
    display: flex;
    border-top: 1px solid rgba(0,0,0,.2);
}

.Todo:last-child {
    border-bottom: 1px solid rgba(0,0,0,.2);
}

.left {
    flex-basis: 40px;
}

.right {
    flex-basis: calc(100% - 40px);
    position: relative;
}

.right > * {
    width: 100%;
    height: 100%;
}

input {
    margin: 0;
    padding: 0;
    border: none;
    padding-left: calc(60px - 40px);
    font-size: inherit;
    box-sizing: border-box;
    color: inherit;
    position: relative;
}

input.editing {
    box-shadow: inset 0px 0px 5px 0px rgba(184,184,184,1);
}

input.completed:not(.editing) {
    text-decoration: line-through;
    color: rgba(0,0,0,.2);
}

.shield {
    position: absolute;
    top: 0;
    left: 0;
}

.shield.editing {
    z-index: -1;
}

.shield .destroy {
    visibility: hidden;
    color: rgba(187, 53, 53, 0.637);
    cursor: inherit;
    position: absolute;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
    user-select: none;
}

.shield:hover .destroy {
    visibility: visible;
}

.shield .destroy:hover {
    color: rgb(187, 53, 53);
}

.destroy .screen {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
}

.left {
    background-size: auto;
    background-position: center;
    background-repeat: no-repeat;
    background-image: url('data:image/svg+xml;utf8,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%2240%22%20height%3D%2240%22%20viewBox%3D%22-10%20-18%20100%20135%22%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%2250%22%20fill%3D%22none%22%20stroke%3D%22%23ededed%22%20stroke-width%3D%223%22/%3E%3C/svg%3E');
}

.left.completed {
    background-image: url('data:image/svg+xml;utf8,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%2240%22%20height%3D%2240%22%20viewBox%3D%22-10%20-18%20100%20135%22%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%2250%22%20fill%3D%22none%22%20stroke%3D%22%23bddad5%22%20stroke-width%3D%223%22/%3E%3Cpath%20fill%3D%22%235dc2af%22%20d%3D%22M72%2025L42%2071%2027%2056l-4%204%2020%2020%2034-52z%22/%3E%3C/svg%3E');
}

.left.editing {
    background: white;
}
</style>