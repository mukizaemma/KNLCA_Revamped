<template>
<div class="overlay">
    <form class="form" @submit.prevent="submitform()">
        <div class="top">
            <h3 class="title">{{ type }} Appointment</h3>
            <div class="close" @click="close()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="#000" stroke-width="1.5"></circle> <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="#000" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
            </div>
        </div>
        <div class="form-inputs" v-if="type == 'edit'">
            <label>Departments</label>
            <select v-model="form.department_id">
                <option value="" hidden selected>Select department</option>
                <option :value="department.id" v-for="department in departments" :key="department.id">{{ department.name }}</option>
            </select>
            <label>Doctor</label>
            <select v-model="form.doctor_id">
                <option value="" hidden selected>Select doctor</option>
                <option :value="doctor.id" v-for="doctor in doctorsByDepartment" :key="doctor.id">Dr. {{ doctor.firstname }} {{ doctor.lastname }}</option>
            </select>
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
                    <label>Date</label>
                    <input type="date" v-model="form.date" required>
                </div>
                <div>
                    <label>Time</label>
                    <input type="time" v-model="form.time" required>
                </div>
            </div>
            <label>Description</label>
            <textarea rows="5" placeholder="Write description...." v-model="form.description" required></textarea>
        </div>
        <div class="form-inputs" v-else-if="type == 'view'">
            <div class="flex">
                <div>
                    <label>Department</label>
                    <p v-if="form.department">{{ form.department.name }}</p>
                    <p v-else>N/A</p>
                </div>
                <div>
                    <label>Doctor</label>
                    <p v-if="form.doctor">Dr. {{ form.doctor.firstname }} {{ form.doctor.lastname }}</p>
                    <p v-else>N/A</p>
                </div>
            </div>
            <div class="flex">
                <div>
                    <label>Phone</label>
                    <p>{{ form.phone }}</p>
                </div>
                <div>
                    <label>Email</label>
                    <p>{{ form.email }}</p>
                </div>
            </div>
            <div class="flex">
                <div>
                    <label>Date</label>
                    <p>{{ form.date }}</p>
                </div>
                <div>
                    <label>Time</label>
                    <p>{{ form.time }}</p>
                </div>
            </div>
            <label>Status</label>
            <p>{{ form.active_status == 0 ? 'Pending' : (form.active_status == 1 ? 'Accepted' : 'Declined') }}</p>
            <label>Description</label>
            <p>{{ form.description }}</p>
        </div>
        <button v-if="type == 'edit'">{{ type }} Appointment</button>
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
            doctors: [],
            departments: [],
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
        submitform(){
            if(this.type == "edit"){
                this.$store.dispatch("UPDATE_APPOINTMENT", this.form)
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
        }
    },
    mounted(){
        this.handelform()
        this.getAllDoctors()
        this.$getAllDepartments();
    },
}
</script>

<style lang="scss" scoped>
@import "../../../scss/index.scss";

</style>