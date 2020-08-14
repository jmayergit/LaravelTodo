<template>
    <div class="Todo">
        <div class="left">

        </div>
        <div class="right">
            <input 
                v-model="description" 
                v-bind:class="{ editing: !shielded }" 
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
                    v-on:click="onClick"
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
        remove: Function,
    },
    computed: {
        changes: function () {
            return this.description !== this.preDescription
        }
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
        onClick: async function(e) {
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
</style>