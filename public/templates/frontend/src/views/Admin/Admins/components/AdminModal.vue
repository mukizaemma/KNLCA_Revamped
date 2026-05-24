<template>
<div class="overlay">
    <form class="form" @submit.prevent="submitform()">
        <div class="top">
            <h3 class="title">{{ type }} Admin / Customer care</h3>
            <div class="close" @click="close()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="#000" stroke-width="1.5"></circle> <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="#000" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
            </div>
        </div>
        <div class="form-inputs" v-if="type != 'delete'">
            <div class="flex">
                <div>
                    <label>First Name</label>
                    <input type="text" v-model="form.firstname" placeholder="Enter first name" required>
                </div>
                <div>
                    <label>Last Name</label>
                    <input type="text" v-model="form.lastname" placeholder="Enter last name" required>
                </div>
            </div>
            <label>Role</label>
            <select v-model="form.role_id" required>
                <option value="" hidden selected>Select role</option>
                <option :value="role.id" v-for="role in roles" :key="role.id">{{ role.role }}</option>
            </select>
            <label>Email</label>
            <input type="email" v-model="form.email" placeholder="Enter email" required>
            <label>Phone</label>
            <input type="text" v-model="form.phone" placeholder="Enter phone" required>
            <label v-if="type == 'add'">Password</label>
            <input type="password" v-model="form.password" placeholder="Enter password" required v-if="type == 'add'">
        </div>
        <label class="warn-text" v-else>Are you sure you want to detete this admin / Customer-care ?</label>
        <button>{{ type }} Admin / Customer care</button>
    </form>
</div>
</template>

<script>
export default {
    name: "AdminModal",
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
            roles: []
        }
    },
    methods:{
        close(){
            this.$emit("close")
        },
        handelform(){
            this.form = this.current
        },
        getAllRoles(){
            this.$store.dispatch("GET_ALL_ROLES")
            .then(res => {
                this.roles = res.data.filter(role => role.role == "admin" || role.role == "customer-care")
            })
            .catch(err => {
                console.log(err)
            })
        },
        submitform(){
            if(this.type == "add"){
                this.$store.dispatch("CREATE_ADMIN", this.form)
                .then(res => {
                    if(res.data.status == "failed"){
                        this.$notify({
                            text: res.data.message,
                            type: "error"
                        })
                        return
                    }
                    this.$notify({
                        text: res.data.message,
                        type: "success"
                    })
                    this.$emit("close")
                    this.$emit("refresh")
                })
                .catch(err => {
                    console.log(err)
                })
            }else if(this.type == "edit"){
                this.$store.dispatch("UPDATE_ADMIN", this.form)
                .then(res => {
                    this.$notify({
                        text: res.data.message,
                        type: "success"
                    })
                    this.$emit("close")
                    this.$emit("refresh")
                })
                .catch(err => {
                    console.log(err)
                })
            }else if(this.type == "delete"){
                this.$store.dispatch("DELETE_USER", this.form.id)
                .then(res => {
                    this.$notify({
                        text: res.data.message,
                        type: "success"
                    })
                    this.$emit("close")
                    this.$emit("refresh")
                })
                .catch(err => {
                    console.log(err)
                })
            }
        }
    },
    mounted(){
        this.getAllRoles()
        this.handelform()
    },
}
</script>

<style lang="scss" scoped>
@import "../../../../scss/index.scss";

</style>