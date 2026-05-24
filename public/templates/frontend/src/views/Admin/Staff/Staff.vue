<template>
  <div class="dashboardContent">
    <Sidebar />
    <div class="contents">
        <Topbar />
        <Loader v-if="loading" />
        <Modal v-if="modal" :current="form" :type="modalType" @close="closeModal()" @refresh="$getAllStaff()" />
        <div class="detailed-content">
            <div class="locator-search">
                <h1 class="locator">Leadership team</h1>
                <div class="end">
                    <button class="btn-add" @click="openModal('add',null)">Add member</button>
                </div>
            </div>
            <div class="table" v-if="staff.length > 0">
                <div class="headings">
                    <h3 class="heading">Image</h3>
                    <h3 class="heading">Names</h3>
                    <h3 class="heading">Position</h3>
                    <h3 class="heading"></h3>
                </div>
                <div class="service" v-for="member in allStaff" :key="member.id">
                    <label class="data img"><img :src="$file(member.image)" alt=""></label>
                    <label class="data">{{ member.names }}</label>
                    <label class="data">{{ member.position }}</label>
                    <label class="data visibility" :class="{ 'public' : member.active_status == 1 }">
                        {{ member.active_status == 1 ? 'public' : 'unlisted' }}
                    </label>
                    <div class="data actions">
                        <button class="btn"  @click="openModal('edit',member)">Edit</button>
                        <button class="btn del"  @click="openModal('delete',member)">Delete</button>
                    </div>
                </div>
            </div>
            <label v-else class="nodata">No members recorded</label>
        </div>
    </div>
  </div>
</template>

<script>
import Modal from "./components/MemberModal.vue"
export default {
    name: "AdminStaff",
    components: { Modal },
    computed: {
        allStaff(){
            return this.staff.filter(member => {
                return member.names.toLowerCase().includes(this.search.toLowerCase()) || member.position.toLowerCase().includes(this.search.toLowerCase())
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
                names: "",
                position: "",
                bio: "",
                email: "",
                phone: "",
                twitter: "",
                facebook: "",
                instagram: "",
                image: "",
                active_status: ""
            },
            staff: []      
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
                names: "",
                position: "",
                image: "",
                active_status: ""
            }
        },
    },
    mounted() {
        this.$getAllStaff()
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
            grid-template-columns: 0.7fr 1.3fr 0.8fr 0.5fr 1fr;
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
            grid-template-columns: 0.7fr 1.3fr 0.8fr 0.5fr 1fr;
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