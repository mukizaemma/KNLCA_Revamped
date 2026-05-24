<template>
<div class="overlay">
    <form class="form" @submit.prevent="submitform()">
        <div class="top">
            <h3 class="title">{{ type }} Subscription</h3>
            <div class="close" @click="close()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="#000" stroke-width="1.5"></circle> <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="#000" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
            </div>
        </div>
        <label class="warn-text">Are you sure you want to detete this subscription ?</label>
        <button>{{ type }} Subscription</button>
    </form>
</div>
</template>

<script>
export default {
    name: "ServiceModal",
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
        },
        submitform(){
            if(this.type == 'delete'){
                this.$store.dispatch('DELETE_SUBSCRIBER', this.form)
                    .then(res => {
                        if(res.data.message == 'Subscriber deleted successfully'){
                            this.$notify({
                                text: res.data.message,
                                type: 'success'
                            })
                            this.close()
                            this.$emit("refresh")
                        }else{
                            this.$notify({
                                text: res.data.message,
                                type: 'error'
                            })
                        }
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
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