<template>
<div class="overlay">
    <Loader v-if="loading" />
    <form class="form" @submit.prevent="submitform()">
        <div class="top">
            <h3 class="title">{{ type }} Doctor</h3>
            <div class="close" @click="close()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="#000" stroke-width="1.5"></circle> <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="#000" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
            </div>
        </div>
        <div class="form-inputs" v-if="type != 'delete' && type != 'working days'">
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
            <div class="flex">
                <div>
                    <label>Phone</label>
                    <input type="text" v-model="form.phone" placeholder="Enter phone" required>
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" v-model="form.email" placeholder="Enter email" required>
                </div>
            </div>
            <div class="flex">
                <div>
                    <label>Departments</label>
                    <select v-model="form.department_id" required>
                        <option value="" hidden selected>Select department</option>
                        <option :value="department.id" v-for="department in departments" :key="department.id">{{ department.name }}</option>
                    </select>
                </div>
                <div>
                    <label>Position</label>
                    <input type="text" v-model="form.position" placeholder="Enter position">
                </div>
            </div>
            <div>
                <label>Reg no</label>
                <input type="text" v-model="form.reg_no" placeholder="Enter REG-NO">
            </div>
            <label>Gender</label>
            <select v-model="form.gender" required>
                <option value="" disabled selected>Select gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <label>Bio</label>
            <VueEditor placeholder="Enter description" v-model="form.bio"></VueEditor>
            <label>Twitter</label>
            <input type="text" v-model="form.twitter" placeholder="Enter twitter link">
            <label>Facebook</label>
            <input type="text" v-model="form.facebook" placeholder="Enter twitter link">
            <label>Instagram</label>
            <input type="text" v-model="form.instagram" placeholder="Enter twitter link">
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
        <div class="form-inputs" v-if="type == 'working days'">
            <label class="center">Monday</label>
            <div class="flex">
                <span @click="() => { days[0].from = days[0].to = ''}">Reset Day</span>
                <div>
                    <label>From</label>
                    <input type="time" v-model="days[0].from">
                </div>
                <div>
                    <label>To</label>
                    <input type="time" v-model="days[0].to" :min="days[0].from">
                </div>
            </div>
            <label class="center">Tuesday</label>
            <div class="flex">
                <span @click="() => { days[1].from = days[1].to = ''}">Reset Day</span>
                <div>
                    <label>From</label>
                    <input type="time" v-model="days[1].from">
                </div>
                <div>
                    <label>To</label>
                    <input type="time" v-model="days[1].to" :min="days[1].from">
                </div>
            </div>
            <label class="center">Wednesday</label>
            <div class="flex">
                <span @click="() => { days[2].from = days[2].to = ''}">Reset Day</span>
                <div>
                    <label>From</label>
                    <input type="time" v-model="days[2].from">
                </div>
                <div>
                    <label>To</label>
                    <input type="time" v-model="days[2].to" :min="days[2].from">
                </div>
            </div>
            <label class="center">Thursday</label>
            <div class="flex">
                <span @click="() => { days[3].from = days[3].to = ''}">Reset Day</span>
                <div>
                    <label>From</label>
                    <input type="time" v-model="days[3].from">
                </div>
                <div>
                    <label>To</label>
                    <input type="time" v-model="days[3].to" :min="days[3].from">
                </div>
            </div>
            <label class="center">Friday</label>
            <div class="flex">
                <span @click="() => { days[4].from = days[4].to = ''}">Reset Day</span>
                <div>
                    <label>From</label>
                    <input type="time" v-model="days[4].from">
                </div>
                <div>
                    <label>To</label>
                    <input type="time" v-model="days[4].to" :min="days[4].from">
                </div>
            </div>
            <label class="center">Saturday</label>
            <div class="flex">
                <span @click="() => { days[5].from = days[5].to = ''}">Reset Day</span>
                <div>
                    <label>From</label>
                    <input type="time" v-model="days[5].from">
                </div>
                <div>
                    <label>To</label>
                    <input type="time" v-model="days[5].to" :min="days[5].from">
                </div>
            </div>
            <label class="center">Sunday</label>
            <div class="flex">
                <span @click="() => { days[6].from = days[6].to = ''}">Reset Day</span>
                <div>
                    <label>From</label>
                    <input type="time" v-model="days[6].from">
                </div>
                <div>
                    <label>To</label>
                    <input type="time" v-model="days[6].to" :min="days[6].from">
                </div>
            </div>
        </div>
        <label class="warn-text" v-if="type == 'delete'">Are you sure you want to detete this doctor ?</label>
        <button v-if="type == 'working days'">Edit Working days</button>
        <button v-else>{{ type }} Doctor</button>
    </form>
</div>
</template>

<script>
export default {
    name: "DoctorModal",
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
            roles: [],
            departments: [],
            days: [
                { day: "Monday", from: "", to: ""},
                { day: "Tuesday", from: "", to: ""},
                { day: "Wednesday", from: "", to: ""},
                { day: "Thursday", from: "", to: ""},
                { day: "Friday", from: "", to: ""},
                { day: "Saturday", from: "", to: ""},
                { day: "Sunday", from: "", to: ""},
            ],
        }
    },
    methods:{
        close(){
            this.$emit("close")
        },
        handelform(){
            this.form = this.current
            if(this.current.working_days == null || this.current.working_days == ""){
                this.days = [
                    { day: "Monday", from: "", to: ""},
                    { day: "Tuesday", from: "", to: ""},
                    { day: "Wednesday", from: "", to: ""},
                    { day: "Thursday", from: "", to: ""},
                    { day: "Friday", from: "", to: ""},
                    { day: "Saturday", from: "", to: ""},
                    { day: "Sunday", from: "", to: ""},
                ]
                return
            }
            this.days = JSON.parse(this.current.working_days)
        },
        submitform(){
            this.loading = true
            if(this.type == "add"){
                this.$store.dispatch("CREATE_DOCTOR", this.form)
                .then(res => {
                    if(res.data.status == "failed"){
                        this.$notify({
                            text: res.data.message,
                            type: "error"
                        })
                        this.loading = false
                        return
                    }
                    this.$notify({
                        text: res.data.message,
                        type: "success"
                    })
                    this.loading = false
                    this.$emit("close")
                    this.$emit("refresh")
                })
                .catch(err => {
                    console.log(err)
                })
            }else if(this.type == "edit" || this.type == "working days"){
                this.form.working_days = JSON.stringify(this.days)
                this.$store.dispatch("UPDATE_DOCTOR", this.form)
                .then(res => {
                    if(res.data.status == "failed"){
                        this.$notify({
                            text: res.data.message,
                            type: "error"
                        })
                        this.loading = false
                        return
                    }
                    this.$notify({
                        text: res.data.message,
                        type: "success"
                    })
                    if(this.$loggedUser().role.role == "doctor"){
                        localStorage.setItem("logged_user", JSON.stringify(res.data.data))
                    }
                    this.loading = false
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
                    this.loading = false
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
        if(this.type != "working days" && this.type != "delete"){
            this.$getAllDepartments()
        }
        this.handelform()
    },
}
</script>

<style lang="scss" scoped>
@import "../../../../scss/index.scss";

</style>