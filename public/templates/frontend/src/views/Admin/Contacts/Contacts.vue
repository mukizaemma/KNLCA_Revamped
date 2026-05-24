<template>
  <div class="dashboardContent">
    <Sidebar />
    <div class="contents">
        <Topbar />
        <Loader v-if="loading" />
        <Modal v-if="modal" :current="form" :type="modalType" @reply="reply" @close="closeModal()" @refresh="getAllContacts()" />
        <ReplyOnModal v-if="replyModal" :current="replyForm" :type="modalType" @close="closeModal()" />
        <div class="detailed-content">
            <div class="locator-search">
                <h1 class="locator">Contacts</h1>
                <!-- <div class="end">
                    <div class="search">
                        <input type="text" placeholder="Search for a subscriber">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g clip-path="url(#clip0_15_152)"> <rect width="24" height="24" fill="white"></rect> <circle cx="10.5" cy="10.5" r="6.5" stroke="#ccc" stroke-linejoin="round"></circle> <path d="M19.6464 20.3536C19.8417 20.5488 20.1583 20.5488 20.3536 20.3536C20.5488 20.1583 20.5488 19.8417 20.3536 19.6464L19.6464 20.3536ZM20.3536 19.6464L15.3536 14.6464L14.6464 15.3536L19.6464 20.3536L20.3536 19.6464Z" fill="#000000"></path> </g> <defs> <clipPath id="clip0_15_152"> <rect width="24" height="24" fill="white"></rect> </clipPath> </defs> </g></svg>
                    </div>
                </div> -->
            </div>
            <div class="table" v-if="contacts.length > 0">
                <div class="headings">
                    <h3 class="heading">Names</h3>
                    <h3 class="heading">Subject</h3>
                    <h3 class="heading">Message</h3>
                    <h3 class="heading">date</h3>
                    <h3 class="heading"></h3>
                </div>
                <div class="service" v-for="contact in contacts" :key="contact.id">
                    <label class="data">{{ contact.firstname }} {{ contact.lastname }}</label>
                    <label class="data">{{ contact.subject }}</label>
                    <label class="data">{{ contact.message }}</label>
                    <label class="data">{{ contact.date }}</label>
                    <div class="data actions">
                        <button class="btn" @click="openModel('view', contact)">View</button>
                    </div>
                </div>
            </div>
            <label v-else class="nodata">No subscribers available</label>
        </div>
    </div>
  </div>
</template>

<script>
import Modal from "./components/ContactsModal.vue";
import ReplyOnModal from './components/ReplyOnModal.vue';
export default {
    name: "AdminContacts",
    components: { Modal, ReplyOnModal },
    data() {
        return {
            loading: false,
            contacts: [],
            modal: false,
            modalType: null,
            replyModal: false,
            form: {
                name: "",
                email: ""
            },
            replyForm: { reply: "" }
        }
    },
    methods: {
        getAllContacts(){
            this.loading = true;
            this.$store.dispatch('GET_ALL_CONTACTS')
                .then(res => {
                    this.loading = false;
                    this.contacts = res.data;
                })
                .catch(err => {
                    this.loading = false;
                    console.log(err);
                })
        },
        openModel(type, current){
            if(type == 'reply'){
                this.replyModal = true;
                this.type = type;
                this.replyForm.contact = current;
                return
            }
            this.modal = true;
            this.modalType = type;
            this.form = current;
        },
        reply(contact){
            this.openModel('reply', contact)
        },
        closeModal(){
            this.modal = false;
            this.modalType = null;
            this.replyModal = false;
            this.form = {
                name: "",
                email: ""
            }
            this.replyForm = { reply: "" }
        }
    },
    mounted() {
        this.getAllContacts();
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
            grid-template-columns: 1fr 1fr 1fr 1fr 0.5fr;
            column-gap: 10px;
            padding: 10px 0;
            margin: 0 0 15px;
            border-bottom: 1px solid #dbdbdb8b;
            .heading{
                font-size: 0.8rem;
                font-weight: 500;
                color: #333;
            }
        }
        .service{
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 0.5fr;
            column-gap: 10px;
            margin: 0 0 15px;
            padding: 10px 0;
            border-bottom: 1px solid #dbdbdb54;
            .data{
                font-size: 0.8rem;
                color: #333;
                height: fit-content;
                text-overflow: ellipsis;
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
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