<template>
  <div class="dashboardContent">
    <Sidebar />
    <div class="contents">
        <Topbar />
        <Loader v-if="loading" />
        <Modal v-if="modal" :current="form" :type="modalType" @close="closeModal()" @refresh="getAllAdmins()" />
        <div class="detailed-content">
            <div class="locator-search">
                <h1 class="locator">Admins & Customer care</h1>
                <div class="end">
                    <button class="btn-add" @click="openModal('add',null)">Add an admin / Customer care</button>
                </div>
            </div>
            <div class="table" v-if="admins.length > 0">
                <div class="headings">
                    <h3 class="heading">Image</h3>
                    <h3 class="heading">Names</h3>
                    <h3 class="heading">Role</h3>
                    <h3 class="heading">Email</h3>
                    <h3 class="heading"></h3>
                </div>
                <div class="service" v-for="admin in allAdmins" :key="admin.id">
                    <label class="data img"><img :src="$file(admin.image)" alt=""></label>
                    <label class="data" v-if="admin">{{ admin.firstname }} {{ admin.lastname }}</label>
                    <label class="data" v-if="admin">{{ admin.role.role }}</label>
                    <label class="data">{{ admin.email }}</label>
                    <div class="data actions">
                        <button class="btn"  @click="openModal('edit',admin)">Edit</button>
                        <button class="btn del"  @click="openModal('delete',admin)">Delete</button>
                    </div>
                </div>
            </div>
            <label v-else class="nodata">No admins recorded</label>
        </div>
    </div>
  </div>
</template>

<script>
import Modal from "./components/AdminModal.vue"
export default {
    name: "AdminTeam",
    components: { Modal },
    computed: {
        allAdmins(){
            return this.admins.filter(admin => {
                return admin.firstname.toLowerCase().includes(this.search.toLowerCase()) || admin.lastname.toLowerCase().includes(this.search.toLowerCase()) || admin.email.toLowerCase().includes(this.search.toLowerCase())
            })
        }
    },
    data() {
        return {
            loading: false,
            modal: false,
            modalType: null,
            search: "",
            form: {
                firstname: "",
                lastname: "",
                role_id: "",
                email: "",
                phone: "",
                password: ""
            },
            admins: []      
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
                role_id: "",
                email: "",
                password: ""
            }
        },
        getAllAdmins(){
            this.loading = true
            this.$store.dispatch('GET_ALL_ADMINS')
                .then(res => {
                    this.loading = false
                    this.admins = res.data.filter(admin => admin.id !== this.$loggedUser().id)
                })
                .catch(err => {
                    this.loading = false
                    console.log(err)
                })
        }
    },
    mounted() {
        this.getAllAdmins()
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
            grid-template-columns: 0.7fr 0.8fr 0.5fr 1.3fr 1fr;
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
            grid-template-columns: 0.7fr 0.8fr 0.5fr 1.3fr 1fr;
            column-gap: 10px;
            margin: 0 0 15px;
            padding: 5px 0;
            border-bottom: 1px solid #dbdbdb54;
            align-items: center;
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