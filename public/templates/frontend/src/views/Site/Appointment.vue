<template>
    <div class="contactus">
        <Loader v-if="loading" />
        <TopHeader />
        <Navbar />  
        <Locator :title="'Request An Appointment'" />
        <div class="content">
            <div class="contact">
                <div class="contact-container">
                    <div class="right">
                        <div class="sub-heading">APPOINTMENT</div>
                        <p class="heading">Book Your Appointment</p>
                        <div class="cover-img">
                            <img src="@/assets/images/cover-1.jpg" alt="" draggable="false">
                        </div>
                    </div>
                    <form @submit.prevent="submitForm()">
                        <div class="flex" v-if="!$loggedUser() || this.$loggedUser().role.role != 'patient'">
                            <div>
                                <label>First Name</label>
                                <input type="text" v-model="form.firstname" placeholder="First Name" />
                            </div>
                            <div>
                                <label>Last Name</label>
                                <input type="text" v-model="form.lastname" placeholder="Last Name" />
                            </div>
                        </div>
                        <div class="flex"  v-if="!$loggedUser() || this.$loggedUser().role.role != 'patient'">
                            <div>
                                <label>Phone</label>
                                <input type="text" v-model="form.phone" placeholder="Subject" />
                            </div>
                            <div>
                                <label>Email</label>
                                <input type="email" v-model="form.email" placeholder="Email" />
                            </div>
                        </div>
                        <div class="flex">
                            <div>
                                <label>Department</label>
                                <select v-model="form.department_id">
                                    <option value="">Choose a department</option>
                                    <option :value="department.id" v-for="department in departments" :key="department.id">
                                        {{ department.name }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label>Doctor</label>
                                <select v-model="form.doctor_id">
                                    <option value="" disabled>Choose a doctor</option>
                                    <option :value="doctor.id" v-for="doctor in doctorsByDepartment" :key="doctor.id">
                                        {{ doctor.firstname }} {{ doctor.lastname }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="flex">
                            <div>
                                <label>Date <span>*</span></label>
                                <input type="date" v-model="form.date" required />
                            </div>
                            <div>
                                <label>Time <span>*</span></label>
                                <input type="time" v-model="form.time" required />
                            </div>
                        </div>
                        <label>Message <span>*</span></label>
                        <textarea rows="10" placeholder="Write description...." v-model="form.description" required></textarea>
                        <button>
                            Book An Appointment
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <Partners />
        <Footer />
    </div>
</template>

<script>
export default {
    name: 'Appointment',
    data() {
        return {
            loading: false,
            form: {
                firstname: '',
                lastname: '',
                email: '',
                department_id: '',
                doctor_id: '',
                phone: '',
                date: '',
                time: '',
                description: ''
            },
            departments: [],
            doctors: [],
        }
    },
    computed: {
        doctorsByDepartment(){
            return this.doctors.filter(doctor => doctor.department_id == this.form.department_id)
        }
    },
    methods: {
        submitForm(){
            this.loading = true;
            if(this.$loggedUser() && this.$loggedUser().role.role == 'patient'){
                this.form.firstname = this.$loggedUser().firstname
                this.form.lastname = this.$loggedUser().lastname
                this.form.email = this.$loggedUser().email
                this.form.phone = this.$loggedUser().phone
            }
            this.$store.dispatch('CREATE_APPOINTMENT', this.form)
                .then(res => {
                    if(res.data.status == 'success'){
                        this.$notify({
                            text: res.data.message,
                            type: "success"
                        })
                        this.form = { firstname: '', lastname: '', email: '', department_id: '', doctor_id: '', phone: '', date: '', time: '', message: ''}
                    }else{
                        this.$notify({
                            text: res.data.message,
                            type: "error"
                        })
                    }
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err)
                    this.loading = false;
                })
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
        this.$getAllDepartments();
        this.getAllDoctors();
    }
}
</script>

<style lang="scss" scoped>
@import '../../scss/index.scss';
.contact{
    width: 100%;
    margin: 40px 0;
    .sub-heading{
        font-size: 1.1rem;
        font-weight: 600;
        margin: 50px 0 5px;
        color: $lightred;
        text-transform: uppercase;
        @media(max-width: 820px){
            margin: 0;
        }
    }
    p{
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 30px;
    }
    .contact-container{
        width: 100%;
        display: grid;
        align-items: flex-end;
        column-gap: 50px;
        grid-template-columns: 1fr 1.5fr;
        @media(max-width: 820px){
            grid-template-columns: 1fr;
            // row-gap: 40px;
        }
        .right{
            width: 100%;
            .cover-img{
                width: 100%;
                height: 550px;
                overflow: hidden;
                border-radius: 8px;
                position: relative;
                @media(max-width: 820px){
                    // height: 300px;
                    display: none;
                }
                img{
                    position: relative;
                    height: 100%;
                    width: 100%;
                    object-fit: cover;
                }
            }
        }
        form{
            width: 100%;
            .flex{
                display: grid;
                grid-template-columns: 1fr 1fr;
                column-gap: 20px;
                @media(max-width: 470px){
                    grid-template-columns: 1fr;
                }
            }
            label{
                display: block;
                font-size: 0.9rem;
                color: $realblack;
                span{
                    color: $lightred;
                }
            }
            input,textarea,select{
                font-size: 0.8rem;
                width: 100%;
                padding: 10px 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                margin: 10px 0;
                &:focus{
                    outline: none;
                    border: 1px solid $lightred;
                }
            }
            button{
                width: 100%;
                font-size: 0.8rem;
                padding: 10px 0;
                border: none;
                background: $lightred;
                color: #fff;
                border-radius: 4px;
                position: relative;
            }
        }
    }
}
</style>