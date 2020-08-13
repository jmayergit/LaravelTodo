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
</style>

<template>
    <div class="Todo">
        <div class="left">

        </div>
        <div class="right">
            <input 
                v-model="description" 
                v-bind:class="{ editing: !shielded }" 
                ref="input"
            />
            <div 
                class="shield" 
                v-bind:class="{ editing: !shielded }"
                v-on:dblclick="onDblClick"
            ></div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            shielded: true,  
            description: this.todo.description,  
        }
    },
    props: {
        todo: Object,
    },
    methods: {
        onDblClick: function () {
            this.shielded = false
            this.$refs.input.focus()
        }
    }
}
</script>