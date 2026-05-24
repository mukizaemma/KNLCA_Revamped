<template>
<div class="overlay">
    <form class="form" @submit.prevent="submitform()">
        <div class="top">
            <h3 class="title">{{ type }} Suggestion</h3>
            <div class="close" @click="close()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="#000" stroke-width="1.5"></circle> <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="#000" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
            </div>
        </div>
        <div class="form-inputs">
            <label class="label">Message</label>
            <p>{{ form.message }}</p>
            <label class="label">Date</label>
            <p>{{ form.date }}</p>
        </div>
    </form>
</div>
</template>

<script>
export default {
    name: "SuggestionModal",
    props: {
        current: {
            type: Object,
            default: null
        },
        type: {
            type: String,
            default: null
        }
    },
    data() {
        return {
            loading: false,
            form: {},
        }
    },
    methods:{
        close(){
            this.$emit("close")
        },
        handelform(){
            this.form = this.current
        }
    },
    mounted() {
        this.handelform()
    },
}
</script>

<style lang="scss" scoped>
@import "../../../../scss/index.scss";

</style>