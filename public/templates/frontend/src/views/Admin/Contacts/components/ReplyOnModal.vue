<template>
<div class="overlay">
    <Loader v-if="loading" />
    <form class="form" @submit.prevent="submitform()">
        <div class="top">
            <h3 class="title">Reply On Contact Message</h3>
            <div class="close" @click="close()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="#000" stroke-width="1.5"></circle> <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="#000" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
            </div>
        </div>
        <div class="form-inputs">
            <label>Reply</label>
            <textarea v-model="form.reply" placeholder="Write something" required rows="5"></textarea>
            <button>
                Reply to appointment
            </button>
        </div>
    </form>
</div>
</template>

<script>
export default {
    name: "ReplyOnModal",
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
            this.loading = true
            this.$store.dispatch('REPLY_CONTACT', this.form)
                .then(res => {
                    this.loading = false
                    if(res.data.status == 'success'){
                        this.$notify({
                            text: res.data.message,
                            type: "success"
                        })
                        this.$emit("close")
                        return
                    }
                    this.$notify({
                        text: res.data.message,
                        type: "error"
                    })
                })
                .catch(err => {
                    this.loading = false
                    console.log(err)
                })
        },
    },
    mounted() {
        this.handelform()
    },
}
</script>

<style lang="scss" scoped>
@import "../../../../scss/index.scss";

</style>