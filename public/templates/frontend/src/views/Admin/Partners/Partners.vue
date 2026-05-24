<template>
  <div class="dashboardContent">
    <Sidebar />
    <div class="contents">
        <Topbar />
        <Loader v-if="loading" />
        <Modal v-if="modal" :current="form" :type="modalType" @close="closeModal()" @refresh="$getAllPartners()" />
        <div class="detailed-content">
            <div class="locator-search">
                <h1 class="locator">Partners</h1>
                <div class="end">
                    <button class="btn-add" @click="openModal('add',null)">Add partner</button>
                </div>
            </div>
            <div class="table" v-if="partners.length > 0">
                <div class="headings">
                    <h3 class="heading">Image</h3>
                    <h3 class="heading">Name</h3>
                    <h3 class="heading">Description</h3>
                    <h3 class="heading"></h3>
                </div>
                <div class="service" v-for="partner in partners" :key="partner.id">
                    <label class="data img"><img :src="$file(partner.image)" :alt="partner.name"></label>
                    <label class="data">{{ partner.name }}</label>
                    <label class="data">{{ partner.description }}</label>
                    <label class="data visibility" :class="{ 'public' : partner.active_status == 1 }">
                        {{ partner.active_status == 1 ? 'public' : 'private' }}
                    </label>
                    <div class="data actions">
                        <button class="btn" @click="openModal('edit',partner)">Edit</button>
                        <button class="btn del" @click="openModal('delete',partner)">Delete</button>
                    </div>
                </div>
            </div>
            <label v-else class="nodata">No records available</label>
        </div>
    </div>
  </div>
</template>

<script>
import Modal from './components/PartnerModal.vue';
export default {
    name: "AdminPartners",
    components: { Modal },
    computed: {
    },
    data() {
        return {
            loading: false,
            partners: [],
            modal: false,
            modalType: null,
            form: {
                name: '',
                type: '',
                category: '',
                link: '',
                image: '',
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
                link: '',
                image: '',
            };
        },
    },
    mounted() {
        this.$getAllPartners();
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
            grid-template-columns: 0.5fr 0.8fr 0.7fr 0.5fr 0.7fr;
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
            grid-template-columns: 0.5fr 0.8fr 0.7fr 0.5fr 0.7fr;
            column-gap: 10px;
            margin: 0 0 15px;
            padding: 5px 0;
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