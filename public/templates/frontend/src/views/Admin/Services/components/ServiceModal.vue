<template>
<div class="overlay">
    <form class="form" @submit.prevent="submitform()">
        <div class="top">
            <h3 class="title">{{ type }} Service</h3>
            <div class="close" @click="close()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="#000" stroke-width="1.5"></circle> <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="#000" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
            </div>
        </div>
        <div class="form-inputs" v-if="type != 'delete' && form">
            <label>Title</label>
            <input type="text" v-model="form.name" placeholder="Enter service name" required>
            <label>Content</label>
            <VueEditor placeholder="Write service description" v-model="form.description"></VueEditor>
            <label>Departments</label>
            <select v-model="form.department_id" required>
                <option value="" hidden selected>Select department</option>
                <option :value="department.id" v-for="department in departments" :key="department.id">{{ department.name }}</option>
            </select>
            <label>Image</label>
            <Uploader
                v-if="form.image"
                :multiple="false"
                :uploadUrl="'files/upload'"
                @imagesUploaded="(data) =>{ form.image = data }"
                :value="form.image"
            />
            <Uploader
                v-else
                :multiple="false"
                :uploadUrl="'files/upload'"
                @imagesUploaded="(data) =>{ form.image = data }"
                :value="form.image"
            />
        </div>
        <label class="warn-text" v-else>Are you sure you want to detete this service ?</label>
        <button>{{ type }} Service</button>
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
            departments: [],
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
            if(this.type == "add"){
                this.$store.dispatch("CREATE_SERVICE", this.form)
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
            }else if(this.type == "edit"){
                this.$store.dispatch("UPDATE_SERVICE", this.form)
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
                this.$store.dispatch("DELETE_SERVICE", this.form.id)
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
    mounted() {
        this.$getAllDepartments()
        this.handelform()
    },
}
</script>

<style lang="scss" scoped>
@import "../../../../scss/index.scss";

</style>