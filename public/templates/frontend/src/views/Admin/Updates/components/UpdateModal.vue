<template>
<div class="overlay">
    <form class="form article" @submit.prevent="submitform()">
        <div class="top">
            <h3 class="title">{{ type }} An Article</h3>
            <div class="close" @click="close()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="#000" stroke-width="1.5"></circle> <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="#000" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
            </div>
        </div>
        <div class="form-inputs" v-if="type != 'delete'">
            <label>Title</label>
            <input type="text" v-model="form.title" placeholder="Enter title name" required>
            <label>Description</label>
            <VueEditor placeholder="Write article description" v-model="form.description"></VueEditor>
            <label v-if="type == 'edit'">Visibility</label>
            <select v-if="type == 'edit'" v-model="form.published_status" required>
                <option value="" disabled selected>Select visibility</option>
                <option :value="1">Publish</option>
                <option :value="0">Private</option>
            </select>
            <label>Image</label>
            <div>
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
        </div>
        <label class="warn-text" v-else>Are you sure you want to detete this article ?</label>
        <button>{{ type }} Article</button>
    </form>
</div>
</template>

<script>
export default {
    name: "ArticleModal",
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
            if(this.type == "add"){
                this.$store.dispatch("CREATE_UPDATE", this.form)
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
                this.$store.dispatch("UPDATE_UPDATE", this.form)
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
                this.$store.dispatch("DELETE_UPDATE", this.form.id)
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
        this.handelform()
    },
}
</script>

<style lang="scss" scoped>
@import "../../../../scss/index.scss";

</style>