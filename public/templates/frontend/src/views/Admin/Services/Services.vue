<template>
  <div class="dashboardContent">
    <Sidebar />
    <div class="contents">
        <!-- <Topbar /> -->
        <Loader v-if="loading" />
        <Modal v-if="modal" :current="form" :type="modalType" @close="closeModal()" @refresh="$getAllServices()" />
        <div class="detailed-content">
            <div class="locator-search">
                <h1 class="locator">Services</h1>
                <div class="end">
                    <div class="search">
                        <input type="text" placeholder="Search for services">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g clip-path="url(#clip0_15_152)"> <rect width="24" height="24" fill="white"></rect> <circle cx="10.5" cy="10.5" r="6.5" stroke="#ccc" stroke-linejoin="round"></circle> <path d="M19.6464 20.3536C19.8417 20.5488 20.1583 20.5488 20.3536 20.3536C20.5488 20.1583 20.5488 19.8417 20.3536 19.6464L19.6464 20.3536ZM20.3536 19.6464L15.3536 14.6464L14.6464 15.3536L19.6464 20.3536L20.3536 19.6464Z" fill="#000000"></path> </g> <defs> <clipPath id="clip0_15_152"> <rect width="24" height="24" fill="white"></rect> </clipPath> </defs> </g></svg>
                    </div>
                    <button class="btn-add" @click="openModal('add',null)">Add service</button>
                </div>
            </div>
            <div class="table" v-if="services.length > 0">
                <div class="headings">
                    <h3 class="heading">Image</h3>
                    <h3 class="heading">Name</h3>
                    <h3 class="heading">Description</h3>
                    <h3 class="heading"></h3>
                </div>
                <div class="service" v-for="service in services" :key="service.id">
                    <label class="data img"><img :src="$file(service.image)" :alt="service.name"></label>
                    <label class="data">{{ service.name }}</label>
                    <label class="data" v-html="service.description"></label>
                    <div class="data actions">
                        <button class="btn" @click="openModal('edit',service)">Edit</button>
                        <button class="btn del" @click="openModal('delete',service)">Delete</button>
                    </div>
                </div>
            </div>
            <label v-else class="nodata">No services recorded</label>
        </div>
    </div>
  </div>
</template>

<script>
import Modal from './components/ServiceModal.vue';
export default {
    name: "AdminServices",
    components: { Modal },
    computed: {
    },
    data() {
        return {
            loading: false,
            services: [],
            modal: false,
            modalType: null,
            form: {
                name: '',
                description: '',
                image: '',
                department_id: '',
            },
        }
    },
    methods:{
        openModal(type,content){
            this.modalType = type
            this.modal = !this.modal
            type !== "add" ? this.form = { ...content } : ''
        },
        closeModal(){
            this.modal = false;
            this.modalType = null;
            this.form = {
                name: '',
                description: '',
                image: null
            };
        },
    },
    mounted() {
        this.$getAllServices();
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
            grid-template-columns: 0.5fr 0.8fr 1fr 0.7fr;
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
            align-items: center;
            grid-template-columns: 0.5fr 0.8fr 1fr 0.7fr;
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
                &.img{
                    img{
                        width: 100px;
                        height: 60px;
                        border-radius: 5px;
                        object-fit: contain;
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
            }
        }
    }
}
</style>