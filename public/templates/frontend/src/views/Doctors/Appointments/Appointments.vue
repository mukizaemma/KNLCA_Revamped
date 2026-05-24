<template>
  <div class="dashboardContent">
    <Sidebar />
    <div class="contents">
        <Topbar />
        <Loader v-if="loading" />
        <Modal v-if="modal" :current="form" :type="modalType" @close="closeModal()" @reply="reply" @refresh="getAllAppointments()" />
        <ReplyOnModal v-if="replyModal" :current="replyForm" :type="modalType" @close="closeModal()" />
        <div class="detailed-content">
            <div class="locator-search">
                <h1 class="locator">Appointments</h1>
                <div class="end" v-if="this.$loggedUser().role.role == 'customer-care'">
                    <button class="btn-add" @click="openModal('add', null)">Add an appointment</button>
                </div>
            </div>
            <div class="table" v-if="appointments.length > 0">
                <div class="headings" :class="{ receptionist: this.$loggedUser().role.role == 'customer-care'}">
                    <h3 class="heading">Names</h3>
                    <h3 class="heading" v-if="this.$loggedUser().role.role == 'customer-care'">Doctor</h3>
                    <h3 class="heading">Description</h3>
                    <h3 class="heading">Status</h3>
                    <h3 class="heading">Created On</h3>
                    <h3 class="heading"></h3>
                </div>
                <div class="project" v-for="appointment in appointments" :key="appointment.id"  :class="{ receptionist: this.$loggedUser().role.role == 'customer-care'}">
                    <label class="data">{{ appointment.firstname }} {{ appointment.lastname }}</label>
                    <label class="data" v-if="$loggedUser().role.role == 'customer-care' && appointment.doctor">
                        Dr. {{ appointment.doctor.firstname }} {{ appointment.doctor.lastname }}
                    </label>
                    <label class="data" v-else-if="$loggedUser().role.role == 'customer-care' && !appointment.doctor">N/A</label>
                    <label class="data">{{ appointment.description }}</label>
                    <label class="data visibility" :class="{ 'public' : appointment.active_status == 1 , 'pending': appointment.active_status == 0}">
                        {{ appointment.active_status == 1 ? 'Approved' : (appointment.active_status == 0 ? "Pending" : "Declined") }}
                    </label>
                    <label class="data">{{ appointment.date }}</label>
                    <div class="data actions">
                        <button class="btn" @click="openModal('view', appointment)">View</button>
                        <button class="btn approve" v-if="$loggedUser().role.role == 'doctor'" @click="openModal('approve', appointment)">Approve</button>
                        <button class="btn approve" v-else-if="appointment.active_status == 0" @click="openModal('edit', appointment)">Edit</button>
                        <button class="btn del" v-if="appointment.active_status == 0" @click="openModal('decline', appointment)">Decline</button>
                    </div>
                </div>
            </div>
            <label v-else class="nodata">No appointments requested</label>
        </div>
    </div>
  </div>
</template>

<script>
import Modal from './components/AppointmentModal.vue';
import ReplyOnModal from './components/ReplyOnModal.vue';
export default {
    name: "AdminAppointments",
    components: { Modal, ReplyOnModal },
    data() {
        return {
            loading: false,
            modal: false,
            modalType: null,
            replyModal: false,
            appointments: [],
            form: {
                title: "",
                category: "",
                description: "",
                link: "",
                images: ""
            },
            replyForm: { reply: "" }
        }
    },
    methods: {
        closeModal(){
            this.modal = false;
            this.modalType = null;
            this.form = { active_status: '' },
            this.replyModal = false;
            this.replyForm = { reply: "" }
        },
        openModal(type, content, modaltype){
            this.modalType = type;
            if(modaltype != 'reply'){
                this.modal = true;
                type != 'add' ? { ...this.form } = content : ''
                return
            }
            this.replyModal = true;
            this.type = type;
            this.replyForm.appointment = content;
        },
        reply(appointment){
            this.openModal('reply', appointment, 'reply')
        },
        getAllAppointments(){
            this.loading = true;
            if(this.$loggedUser().role.role == 'doctor'){
                this.$store.dispatch('GET_ALL_DOCTORS_APPOINTMENTS')
                    .then(res => {
                        this.loading = false;
                        this.appointments = res.data;
                    })
                    .catch(err => {
                        this.loading = false;
                        console.log(err);
                    })
            } else {
                this.$store.dispatch('GET_ALL_PATIENTS_APPOINTMENTS')
                    .then(res => {
                        this.loading = false;
                        this.appointments = res.data;
                    })
                    .catch(err => {
                        this.loading = false;
                        console.log(err);
                    })
            }
        },
    },
    mounted() {
        this.getAllAppointments();
        this.$checkAuth()
    },
}
</script>

<style lang="scss" scoped>
@import "../../../scss/index.scss";
.detailed-content{
    padding: 20px;
    .tabs{
        display: flex;
        align-items: center;
        margin: 20px 0px;
        column-gap: 30px;
        .tab{
            font-size: 0.8rem;
            font-weight: 500;
            color: #333;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: .6s;
            &:hover{
                background-color: #f1f1f1;
            }
            &.active{
                background-color: #f5a62361;
                color: #905b06;
            }
        }
    }
    .table{
        margin: 20px;
        .headings{
            display: grid;
            grid-template-columns: 0.7fr 1.3fr 0.5fr 0.5fr 1.5fr;
            column-gap: 10px;
            padding: 10px 0;
            margin: 0 0 15px;
            border-bottom: 1px solid #dbdbdb8b;
            &.receptionist{
                grid-template-columns: 0.7fr 0.8fr 1.3fr 0.5fr 0.5fr 1.5fr;
            }
            .heading{
                font-size: 0.8rem;
                font-weight: 500;
                color: #333;
            }
        }
        .project{
            display: grid;
            grid-template-columns: 0.7fr 1.3fr 0.5fr 0.5fr 1.5fr;
            align-items: center;
            column-gap: 10px;
            margin: 0 0 15px;
            padding: 10px 0;
            border-bottom: 1px solid #dbdbdb54;
            &.receptionist{
                grid-template-columns: 0.7fr 0.8fr 1.3fr 0.5fr 0.5fr 1.5fr;
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
                        width: 100px;
                        height: 60px;
                        border-radius: 5px;
                        object-fit: cover;
                    }
                }
                &.link{
                    a{
                        svg{
                            width: 20px;
                            height: 20px;
                        }
                    }
                }
                &.status{
                    width: fit-content;
                    padding: 3px 10px;
                    border-radius: 4px;
                    &.completed{
                        background: #0984e361;
                        color: #0984e3;
                    }
                    &.ongoing{
                        background: #f5235f61;
                        color: #d61d61;
                    }
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
                        &.approve{
                            background-color: #0985e33f;
                            color: #0984e3;
                        }
                    }
                }
                &.visibility{
                    color: #58092f;
                    background-color: #de8b7c;
                    padding: 5px 10px;
                    border-radius: 5px;
                    width: fit-content;
                    text-transform: capitalize;
                }
                &.public{
                    color: #09580c;
                    background-color: #7cde7f;
                    padding: 5px 10px;
                    border-radius: 5px;
                    width: fit-content;
                }
                &.pending{
                    color: #093a58;
                    background-color: #7cd6de;
                    padding: 5px 10px;
                    border-radius: 5px;
                    width: fit-content;
                }
            }
        }
    }
}
</style>