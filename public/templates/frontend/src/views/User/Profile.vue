<template>
    <div class="myprofile">
        <TopHeader />
        <Navbar />
        <Locator :title="'My Account'" />
        <div class="content">
            <AppointmentModal :current="appointment_form" :type="modalType" v-if="modal" @refresh="getMyAppointements()" @close="closeModal()" />
            <div class="profile-overview">
                <div class="sidebar">
                    <div class="profilepic-name">
                        <div class="profilepic">
                            <img :src="$file($loggedUser().image)" alt="" draggable="false">
                        </div>
                        <div class="names">{{ $loggedUser().firstname }} {{ $loggedUser().lastname }}</div>
                    </div>
                    <div class="links">
                        <button @click="menu = 'appointments'" :class="{ active: menu == 'appointments' }">Appointments</button>
                        <button @click="menu = 'myprofile'" :class="{ active: menu == 'myprofile' }">My profile</button>
                        <button @click="menu = 'security'" :class="{ active: menu == 'security' }">Security</button>
                        <button @click="logout()">Logout</button>
                    </div>
                </div>
                <div class="contents" v-if="menu == 'myprofile'">
                    <h3 class="heading">Personal Information</h3>
                    <form @submit.prevent="updateProfile()">
                        <div class="flex">
                            <div>
                                <label>First Name</label>
                                <input type="text" v-model="form.firstname" placeholder="First Name" required />
                            </div>
                            <div>
                                <label>Last Name</label>
                                <input type="text" v-model="form.lastname" placeholder="Last Name" required />
                            </div>
                        </div>
                        <div class="flex">
                            <div>
                                <label>Gender</label>
                                <select v-model="form.gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div>
                                <label>Date of birth</label>
                                <input type="date" v-model="form.dob" required />
                            </div>
                        </div>
                        <div class="flex">
                            <div>
                                <label>Phone</label>
                                <input type="text" v-model="form.phone" placeholder="Subject" required />
                            </div>
                            <div>
                                <label>Email</label>
                                <input type="email" v-model="form.email" placeholder="Email" />
                            </div>
                        </div>
                        <label>Address</label>
                        <input type="text" v-model="form.address" placeholder="Address" />
                        <button>Update profile</button>
                    </form>
                </div>
                <div class="contents" v-if="menu == 'appointments'">
                    <div class="head-wrapper">
                        <h3 class="heading">My Appointments</h3>
                        <button @click="$router.push('/appointment')">
                            <svg fill="#000000" viewBox="-2.5 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M11.56 10.11v2.046a3.827 3.827 0 1 1-7.655 0v-.45A3.61 3.61 0 0 1 .851 8.141V5.25a1.682 1.682 0 0 1 .763-1.408 1.207 1.207 0 1 1 .48 1.04.571.571 0 0 0-.135.368v2.89a2.5 2.5 0 0 0 5 0V5.25a.57.57 0 0 0-.108-.334 1.208 1.208 0 1 1 .533-1.018 1.681 1.681 0 0 1 .683 1.352v2.89a3.61 3.61 0 0 1-3.054 3.565v.45a2.719 2.719 0 0 0 5.438 0V10.11a2.144 2.144 0 1 1 1.108 0zm.48-2.07a1.035 1.035 0 1 0-1.035 1.035 1.037 1.037 0 0 0 1.036-1.035z"></path></g></svg>
                            Book Appointment
                        </button>
                    </div>
                    <div class="table" v-if="myappointments.length > 0">
                        <div class="headings">
                            <div class="heading">Department</div>
                            <div class="heading">Doctor</div>
                            <div class="heading">Date</div>
                            <div class="heading">Time</div>
                            <div class="heading"></div>
                        </div>
                        <div class="appointment" v-for="appointment in myappointments" :key="appointment.id">
                            <div class="data" v-if="appointment.department">{{ appointment.department.name }}</div>
                            <div class="data" v-else>N/A</div>
                            <div class="data" v-if="appointment.doctor">{{ appointment.doctor.firstname }} {{ appointment.doctor.lastname }}</div>
                            <div class="data" v-else>N/A</div>
                            <div class="data">{{ appointment.date }}</div>
                            <div class="data">{{ appointment.time }}</div>
                            <div class="data action">
                                <button class="edit" @click="openModal('view',appointment)"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#FFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#FFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg></button>
                                <button class="edit" v-if="appointment.active_status == 0" @click="openModal('edit',appointment)"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20.1498 7.93997L8.27978 19.81C7.21978 20.88 4.04977 21.3699 3.32977 20.6599C2.60977 19.9499 3.11978 16.78 4.17978 15.71L16.0498 3.84C16.5979 3.31801 17.3283 3.03097 18.0851 3.04019C18.842 3.04942 19.5652 3.35418 20.1004 3.88938C20.6356 4.42457 20.9403 5.14781 20.9496 5.90463C20.9588 6.66146 20.6718 7.39189 20.1498 7.93997V7.93997Z" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg></button>
                            </div>
                        </div>
                    </div>
                    <div class="nodata" v-else>No appointments yet !</div>
                </div>
                <div class="contents" v-if="menu == 'security'">
                    <h3 class="heading">Security</h3>
                    <form @submit.prevent="changePassword()">
                        <label>Previous password</label>
                        <input type="password" v-model="password_form.old_password" placeholder="Enter Previous Password" required />
                        <div class="flex">
                            <div>
                                <label>New Password</label>
                                <input type="password" v-model="password_form.new_password" placeholder="Enter New Password" required />
                            </div>
                            <div>
                                <label>Confirm Password</label>
                                <input type="password" v-model="password_form.confirm_password" placeholder="Confirm Password" required />
                            </div>
                        </div>
                        <button>Change password</button>
                    </form>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script>
import AppointmentModal from './components/AppointmentModal.vue'
export default {
    name: 'Profile',
    components: { AppointmentModal },
    data() {
        return {
            loading: false,
            modal: false,
            modalType: null,
            menu: 'appointments',
            myappointments: [],
            appointment_form: {
                department_id: '',
                doctor_id: '',
                description: '',
                date: '',
                time: ''
            },
            form: {
                firstname: this.$loggedUser().firstname ?? '',
                lastname: this.$loggedUser().lastname ?? '',
                gender: this.$loggedUser().gender ?? '',
                dob: this.$loggedUser().dob ?? '',
                phone: this.$loggedUser().phone ?? '',
                email: this.$loggedUser().email ?? '',
                address: this.$loggedUser().address ?? ''
            },
            password_form: {
                old_password: '',
                new_password: '',
                confirm_password: ''
            }
        }
    },
    methods: {
        openModal(type,content){
            this.modalType = type
            this.modal = !this.modal
            this.appointment_form = { ...content }
        },
        closeModal(){
            this.modal = false
            this.modalType = null
            this.appointment_form = { 
                department_id: '',
                doctor_id: '',
                description: '',
                date: '',
                time: ''
            }
            this.form = { 
                firstname: "",
                lastname: "",
                role_id: "",
                email: "",
                password: ""
            }
        },
        updateProfile(){
            this.$store.dispatch('UPDATE_PATIENT', this.form)
                .then(res => {
                    if(res.data.status == 'success'){
                        this.$notify({
                            text: res.data.message,
                            type: 'success'
                        })
                        localStorage.setItem('logged_user', JSON.stringify(res.data.data))
                    } else {
                        this.$notify({
                            text: res.data.message,
                            type: 'error'
                        })
                    }
                })
        },
        checkPatientAuth(){
            if(!this.$loggedUser() || this.$loggedUser().role.role != 'patient'){
                this.$router.push('/')
            }
        },
        changePassword(){
            if(this.password_form.new_password != this.password_form.confirm_password){
                this.$notify({
                    text: 'Passwords do not match',
                    type: 'error'
                })
                return
            }
            this.$store.dispatch('CHANGE_PASSWORD', this.password_form)
                .then(res => {
                    if(res.data.status == 'success'){
                        this.$notify({
                            text: res.data.message,
                            type: 'success'
                        })
                        this.password_form = {
                            old_password: '',
                            new_password: '',
                            confirm_password: ''
                        }
                    } else {
                        this.$notify({
                            text: res.data.message,
                            type: 'error'
                        })
                    }
                })
        },
        logout(){
            this.$store.dispatch('USER_LOGOUT')
                .then(res => {
                    localStorage.removeItem('logged_user')
                    localStorage.removeItem('user_token')
                    this.$router.push('/')
                    this.$notify({
                        type: 'success',
                        text: res.data.message,
                    });
                })
                .catch(err => {
                    console.log(err)
                })
        },
        getMyAppointements(){
            this.$store.dispatch('GET_ALL_APPOINTMENTS')
                .then(res => {
                    this.myappointments = res.data
                })
        }
    },
    mounted() {
        this.checkPatientAuth()
        this.getMyAppointements()
    }
}
</script>

<style lang="scss" scoped>
@import '../../scss/index.scss';
.profile-overview{
    width: 900px;
    margin: 30px auto 0;
    display: flex;
    column-gap: 20px;
    .sidebar{
        width: 200px;
        display: flex;
        flex-direction: column;
        row-gap: 20px;
        .profilepic-name{
            width: 200px;
            height: 200px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            row-gap: 15px;
            align-items: center;
            border-radius: 10px;
            background: #f46f5814;
            .profilepic{
                width: 100px;
                height: 100px;
                overflow: hidden;
                border-radius: 100%;
                position: relative;
                img{
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
            }
        }
        .links{
            display: flex;
            flex-direction: column;
            row-gap: 15px;
            button{
                padding: 7px;
                border: 1px solid $lightred;
                color: $lightred;
                border-radius: 10px;
                background: $white;
                font-size: 0.8rem;
                cursor: pointer;
                outline: none;
                transition: .6s;
                &:hover{
                    background: $lightred;
                    color: $white;
                }
                &.active{
                    background: $lightred;
                    color: $white;
                }
            }
        }
    }
    .contents{
        width: 100%;
        h3{
            width: fit-content;
            font-size: 1rem;
            font-weight: 500;
            margin: 0 0 10px;
            padding: 0 0 5px;
            border-bottom: 1px solid $lightred;
            color: $lightred;
        }

        .head-wrapper{
            display: flex;
            justify-content: space-between;
            column-gap: 10px;
            .heading{
                font-size: 0.9rem;
            }
            button{
                padding: 4px 20px;
                border: none;
                border-radius: 5px;
                background: $lightred;
                color: $white;
                font-weight: 400;
                letter-spacing: 0.1rem;
                transition: .6s;
                text-transform: uppercase;
                font-size: 0.7rem;
                cursor: pointer;
                display: flex;
                align-items: center;
                column-gap: 10px;
                svg{
                    width: 20px;
                    fill: $white;
                }
                &:hover{
                    background: $red;
                }
            }
        }
        form{
            margin: 30px 0 0;
            .flex{
                display: grid;
                grid-template-columns: 1fr 1fr;
                column-gap: 20px;
                margin: 0 0 1px;
            }
            label{
                display: block;
                font-size: 0.9rem;
                color: $realblack;
            }
            input,select{
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
                cursor: pointer;
            }
        }
        .table{
            margin: 30px 0 0;
            .headings{
                display: grid;
                grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
                margin: 0 0 15px;
                padding: 0 0 10px;
                column-gap: 10px;
                border-bottom: 1px solid #e7e7e7;
                .heading{
                    font-size: 0.9rem;
                }
            }
            .appointment{
                display: grid;
                grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
                column-gap: 10px;
                padding: 5px 0;
                margin: 15px 0;
                .data{
                    font-size: 0.8rem;
                    &.action{
                        display: flex;
                        column-gap: 7px;
                    }
                    button{
                        all: unset;
                        background-color: #f5a62361;
                        color: #905b06;
                        font-size: 0.8rem;
                        padding: 5px 15px;
                        border-radius: 5px;
                        cursor: pointer;
                        transition: .6s;
                        display: flex;
                        align-items: center;
                        column-gap: 15px;
                        width: 15px;
                        height: 15px;
                        position: relative;
                        &.edit{
                            background-color: #09f;
                        }
                        &.delete{
                            background-color: $lightred;
                        }
                        svg{
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                            width: 70%;
                            height: 70%;
                        }
                    }
                }
            }
        }
        .nodata{
            margin: 20px auto;
            text-align: center;
            display: block;
            font-size: 0.8rem;
            color: $black;
        }
    }
}
</style>