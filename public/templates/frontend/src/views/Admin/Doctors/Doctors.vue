<template>
  <div class="dashboardContent">
    <Sidebar />
    <div class="contents">
        <Topbar />
        <Loader v-if="loading" />
        <Modal v-if="modal" :current="form" :type="modalType" @close="closeModal()" @refresh="getAllDoctors()" />
        <div class="detailed-content">
            <div class="locator-search">
                <h1 class="locator">Doctors</h1>
                <div class="end">
                    <button v-if="this.$loggedUser().role.role != 'receptionist'" class="btn-add" @click="openModal('add',null)">Add a Doctor</button>
                </div>
            </div>
            <div class="table" v-if="doctors.length > 0">
                <div class="headings" :class="{ receptionist: this.$loggedUser().role.role == 'receptionist' }">
                    <h3 class="heading">Image</h3>
                    <h3 class="heading">Names</h3>
                    <h3 class="heading">Department</h3>
                    <h3 class="heading">REG NO</h3>
                    <h3 class="heading"></h3>
                    <h3 class="heading" v-if="this.$loggedUser().role.role == 'receptionist'"></h3>
                </div>
                <div class="service" v-for="doctor in doctors" :key="doctor.id"  :class="{ receptionist: this.$loggedUser().role.role == 'receptionist' }">
                    <label class="data img"><img :src="$file(doctor.image)" alt=""></label>
                    <label class="data" v-if="doctor">{{ doctor.firstname }} {{ doctor.lastname }}</label>
                    <label class="data" v-if="doctor.department">{{ doctor.department.name }}</label>
                    <label class="data" v-else>N/A</label>
                    <label class="data" v-if="doctor.reg_no">{{ doctor.reg_no }}</label>
                    <label class="data" v-else>N/A</label>
                    <label class="data label" @click="openModal('working days',doctor)">Working days</label>
                    <div class="data actions" v-if="this.$loggedUser().role.role != 'receptionist'">
                        <button class="btn"  @click="openModal('edit',doctor)">Edit</button>
                        <button class="btn del"  @click="openModal('delete',doctor)">Delete</button>
                    </div>
                </div>
            </div>
            <label v-else class="nodata">No doctors recorded</label>
        </div>
    </div>
  </div>
</template>

<script>
import Modal from "./components/DoctorModal.vue"
export default {
    name: "AdminDoctors",
    components: { Modal },
    data() {
        return {
            loading: false,
            modal: false,
            modalType: null,
            search: "",
            form: {
                firstname: "",
                lastname: "",
                role_id: 5,
                email: "",
                gender: "",
                description: "",
                phone: "",
                bio: "",
                department_id: "",
                reg_no: "",
                working_days: "",
                twitter: "",
                facebook: "",
                instagram: "",
                image: ""
            },
            doctors: []      
        }
    },
    methods:{
        openModal(type,content){
            this.modalType = type
            this.modal = !this.modal
            type !== "add" ? this.form = { ...content } : ''
        },
        closeModal(){
            this.modal = false
            this.modalType = null
            this.form = { 
                firstname: "",
                lastname: "",
                role_id: 5,
                email: "",
                gender: "",
                descrption: "",
                phone: "",
                password: "",
                department_id: "",
                reg_no: "",
                working_days: "",
                twitter: "",
                facebook: "",
                instagram: "",
                image: ""
            }
        },
        getAllDoctors(){
            this.loading = true
            this.$store.dispatch('GET_ALL_DOCTORS')
                .then(res => {
                    this.loading = false
                    this.doctors = res.data
                })
                .catch(err => {
                    this.loading = false
                    console.log(err)
                })
        },
    },
    mounted() {
        this.getAllDoctors()
        this.$checkAuth()
    },
}
</script>

<style lang="scss" scoped>
@import "../../../scss/index.scss";
.detailed-content{
    padding: 20px;
    .table{
        margin: 20px;
        .headings{
            display: grid;
            grid-template-columns: 0.5fr 0.8fr 0.8fr 0.7fr 1fr 1fr;
            column-gap: 10px;
            padding: 10px 0;
            margin: 0 0 15px;
            border-bottom: 1px solid #dbdbdb8b;
            &.receptionist{
                grid-template-columns: 0.5fr 0.8fr 0.7fr 1fr 1fr;
            }
            .heading{
                font-size: 0.8rem;
                font-weight: 500;
                color: #333;
            }
        }
        .service{
            display: grid;
            grid-template-columns: 0.5fr 0.8fr 0.8fr 0.7fr 1fr 1fr;
            column-gap: 10px;
            margin: 0 0 15px;
            padding: 5px 0;
            border-bottom: 1px solid #dbdbdb54;
            align-items: center;
            &.receptionist{
                grid-template-columns: 0.5fr 0.8fr 0.7fr 1fr 1fr;
            }
            .data{
                font-size: 0.8rem;
                color: #333;
                height: fit-content;
                text-overflow: ellipsis;
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                &.img{
                    img{
                        width: 50px;
                        height: 50px;
                        border-radius: 100%;
                        object-fit: cover;
                    }
                }
                &.label{
                    font-size: 0.7rem;
                    padding: 5px 10px;
                    border-radius: 4px;
                    width: fit-content;
                    background-color: rgb(68, 162, 225);
                    cursor: pointer;
                    color: #fff;
                }
                &.actions{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    column-gap: 10px;
                    button{
                        padding: 5px 20px;
                        cursor: pointer;
                        border: none;
                        border-radius: 5px;
                        background-color: #f1f1f1;
                        font-size: 0.8rem;
                        font-weight: 500;
                        color: #333;
                        cursor: pointer;
                        transition: .6s;
                        &:hover{
                            background-color: #ccc;
                        }
                        &.del{
                            background-color: salmon;
                            color: #fff;
                        }
                    }
                }
            }
        }
    }
}
</style>