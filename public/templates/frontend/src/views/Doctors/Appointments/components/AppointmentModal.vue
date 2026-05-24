<template>
<div class="overlay">
    <form class="form" @submit.prevent="submitform()">
        <div class="top">
            <h3 class="title">{{ type }} Appointment</h3>
            <div class="close" @click="close()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="#000" stroke-width="1.5"></circle> <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="#000" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
            </div>
        </div>
        <div class="form-inputs" v-if="(type == 'add' || type == 'edit') && form">
            <div class="flex mb-m" v-if="(type == 'edit' && !form.user_id) || type == 'add'">
                <div>
                    <label>Patient's firstname</label>
                    <input type="text" v-model="form.firstname">
                </div>
                <div>
                    <label>Patient's lastname</label>
                    <input type="text" v-model="form.lastname">
                </div>
            </div>
            <div class="flex mb-m" v-if="(type == 'edit' && !form.user_id) || type == 'add'">
                <div>
                    <label>Patient's phone</label>
                    <input type="text" v-model="form.phone">
                </div>
                <div>
                    <label>Patient's email</label>
                    <input type="email" v-model="form.email">
                </div>
            </div>
            <div class="flex">
                <div>
                    <label>Departments</label>
                    <select v-model="form.department_id">
                        <option value="" selected>Select department</option>
                        <option :value="department.id" v-for="department in departments" :key="department.id">{{ department.name }}</option>
                    </select>
                </div>
                <div>
                    <label>Doctor</label>
                    <select v-model="form.doctor_id">
                        <option value="" selected>Select doctor</option>
                        <option :value="doctor.id" v-for="doctor in doctorsByDepartment" :key="doctor.id">Dr. {{ doctor.firstname }} {{ doctor.lastname }}</option>
                    </select>
                </div>
            </div>
            <div class="flex mb-m">
                <div>
                    <label>Proposed date</label>
                    <input type="date" v-model="form.date" :min="$getMinDate()" required>
                </div>
                <div>
                    <label>Proposed time</label>
                    <input type="time" v-model="form.time" required>
                </div>
            </div>
            <label  v-if="(type == 'edit' && !form.user_id) || type == 'add'">Appointment description</label>
            <textarea  v-if="(type == 'edit' && !form.user_id) || type == 'add'" rows="5" v-model="form.description" required></textarea>
        </div>
        <div class="form-inputs" v-else-if="type == 'view' && form">
            <div class="flex mb-m">
                <div>
                    <label>Patient firstname</label>
                    <p>{{ form.firstname }}</p>
                </div>
                <div>
                    <label>Patient lastname</label>
                    <p>{{ form.lastname }}</p>
                </div>
            </div>
            <div class="flex mb-m">
                <div>
                    <label>Patient's phone</label>
                    <p>{{ form.phone }}</p>
                </div>
                <div>
                    <label>Patient's email</label>
                    <p>{{ form.email }}</p>
                </div>
            </div>
            <div class="flex mb-m">
                <div>
                    <label>Proposed date</label>
                    <p>{{ form.date }}</p>
                </div>
                <div>
                    <label>Proposed time</label>
                    <p>{{ form.time }}</p>
                </div>
            </div>
            <label>Appointment description</label>
            <p>{{ form.description }}</p>
        </div>
        <label class="warn-text" v-else-if="type == 'decline' || type == 'approve'">Are you sure you want to {{ type == 'decline' ? 'Decline' : 'Approve' }} this appointment ?</label>
        <button v-if="type != 'view'">{{ type }} Appointment</button>
        <div class="reply-btn" @click="reply" v-if="type == 'view' && (form.active_status == 1 && $loggedUser().role.role == 'doctor' || form.active_status == 0 && $loggedUser().role.role == 'customer-care' || form.active_status == 0 && $loggedUser().role.role == 'admin')">
            Reply on appointment
        </div>
    </form>
</div>
</template>

<script>
export default {
    name: "AppointmetModal",
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
            doctors: [],
            departments: []
        }
    },
    computed: {
        doctorsByDepartment(){
            return this.doctors.filter(doctor => doctor.department_id == this.form.department_id)
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
            this.form.images = JSON.stringify(this.form.images)
            if(this.type == "add"){
                this.$store.dispatch("CREATE_APPOINTMENT", this.form)
                .then(res => {
                    if(res.data.status == "success"){
                        this.$notify({
                            text: res.data.message,
                            type: "success"
                        })
                        return
                    }
                    this.$notify({
                        text: res.data.message,
                        type: "error"
                    })
                    this.$emit("close")
                    this.$emit("refresh")
                })
                .catch(err => {
                    console.log(err)
                })
            }else if(this.type == "edit"){
                this.$store.dispatch("UPDATE_APPOINTMENT", this.form)
                .then(res => {
                    if(res.data.status == "success"){
                        this.$notify({
                            text: res.data.message,
                            type: "success"
                        })
                        return
                    }
                    this.$notify({
                        text: res.data.message,
                        type: "error"
                    })
                    this.$emit("close")
                    this.$emit("refresh")
                })
                .catch(err => {
                    console.log(err)
                })
            } else if(this.type == "approve"){
                this.$store.dispatch("APPROVE_DOCTOR_APPOINTMENT", this.form)
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
            } else if(this.type == "decline"){
                this.$store.dispatch("DECLINE_DOCTOR_APPOINTMENT", this.form)
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
            }
        },
        getAllDoctors(){
            this.loading = true
            this.$store.dispatch('GET_ALL_DOCTORS')
                .then(res => {
                    this.loading = false
                    res.data.forEach(doctor => {
                        doctor.working_days = JSON.parse(doctor.working_days)
                    });
                    this.doctors = res.data
                })
                .catch(err => {
                    this.loading = false
                    console.log(err)
                })
        },
    },
    mounted() {
        this.handelform()
        this.getAllDoctors()
        this.$getAllDepartments();
    },
}
</script>

<style lang="scss" scoped>
@import "../../../../scss/index.scss";

</style>