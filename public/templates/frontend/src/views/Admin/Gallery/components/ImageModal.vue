<template>
<div class="overlay">
    <form class="form" @submit.prevent="submitform()">
        <div class="top">
            <h3 class="title">{{ type }} Gallery</h3>
            <div class="close" @click="close()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="#000" stroke-width="1.5"></circle> <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="#000" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
            </div>
        </div>
        <div class="form-inputs" v-if="type != 'delete' && form">
            <label>Title</label>
            <input type="text" v-model="form.title" placeholder="Enter image title">
            <label>Visibility</label>
            <select v-model="form.active_status" required>
                <option value="" disabled selected>Select visibility</option>
                <option :value="1">Public</option>
                <option :value="0">Unlisted</option>
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
        <label class="warn-text" v-else>Are you sure you want to remove this from gallery ?</label>
        <button>{{ type }} Gallery</button>
    </form>
</div>
</template>

<script>
export default {
    name: "GalleryModal",
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
                this.$store.dispatch("ADD_TO_GALLERY", this.form)
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
                this.$store.dispatch("UPDATE_GALLERY", this.form)
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
                this.$store.dispatch("DELETE_GALLERY", this.form.id)
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