<template>
<div class="overlay">
    <form class="form" @submit.prevent="submitform()">
        <div class="top">
            <h3 class="title">{{ type }} Contact</h3>
            <div class="close" @click="close()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="#000" stroke-width="1.5"></circle> <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="#000" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
            </div>
        </div>
        <div class="form-inputs">
            <label class="label">Names</label>
            <p>{{ form.firstname }} {{ form.lastname }}</p>
            <label class="label">Subject</label>
            <p>{{ form.subject }}</p>
            <label class="label">Message</label>
            <p>{{ form.message }}</p>
            <label class="label">Email</label>
            <p>{{ form.email }}</p>
            <label class="label">Phone</label>
            <p>{{ form.phone }}</p>
            <label class="label">Date</label>
            <p>{{ form.date }}</p>
        </div>
        <div class="reply-btn" @click="reply" v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'customer-care' || $loggedUser().role.role == 'admin'">
            Reply on notification
        </div>
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
        reply(){
            this.close()
            this.$emit("reply", this.form)
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