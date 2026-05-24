<template>
  <div class="dashboardContent">
    <Sidebar />
    <div class="contents">
        <Topbar />
        <Loader v-if="loading" />
        <Modal v-if="modal" :current="form" :type="modalType" @close="closeModal()" @refresh="$getAllArticles();" />
        <div class="detailed-content">
            <div class="locator-search">
                <h1 class="locator">Updates</h1>
                <div class="end">
                    <div class="search">
                        <input type="text" v-model="search" placeholder="Search for an article">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g clip-path="url(#clip0_15_152)"> <rect width="24" height="24" fill="white"></rect> <circle cx="10.5" cy="10.5" r="6.5" stroke="#ccc" stroke-linejoin="round"></circle> <path d="M19.6464 20.3536C19.8417 20.5488 20.1583 20.5488 20.3536 20.3536C20.5488 20.1583 20.5488 19.8417 20.3536 19.6464L19.6464 20.3536ZM20.3536 19.6464L15.3536 14.6464L14.6464 15.3536L19.6464 20.3536L20.3536 19.6464Z" fill="#000000"></path> </g> <defs> <clipPath id="clip0_15_152"> <rect width="24" height="24" fill="white"></rect> </clipPath> </defs> </g></svg>
                    </div>
                    <button class="btn-add" @click="openModal('add',null)">Add article</button>
                </div>
            </div>
            <div class="table" v-if="articles.length > 0">
                <div class="headings">
                    <h3 class="heading">Image</h3>
                    <h3 class="heading">Title</h3>
                    <h3 class="heading">Description</h3>
                    <h3 class="heading">Visibility</h3>
                    <h3 class="heading">Created On</h3>
                    <h3 class="heading"></h3>
                </div>
                <div class="service" v-for="article in articles" :key="article.id">
                    <label class="data img"><img :src="$file(article.image)" alt=""></label>
                    <label class="data">{{ article.title }}</label>
                    <label class="data" v-html="article.description"></label>
                    <label class="data visibility" :class="{ 'public' : article.published_status == 1 }">
                        {{ article.published_status == 1 ? 'public' : 'private' }}
                    </label>
                    <label class="data">{{ article.date }}</label>
                    <div class="data actions">
                        <button class="btn" @click="openModal('edit',article)">Edit</button>
                        <button class="btn del" @click="openModal('delete',article)">Delete</button>
                    </div>
                </div>
            </div>
            <label v-else class="nodata">No articles available</label>
        </div>
    </div>
  </div>
</template>

<script>
import Modal from "./components/UpdateModal.vue"
export default {
    name: "AdminUpdates",
    components: { Modal },
    computed: {
        allArticles(){
            return this.services.filter(article => article.name.toLowerCase().includes(this.search.toLowerCase()))
        }
    },
    data() {
        return {
            loading: false,
            modal: false,
            modalType: null,
            search: "",
            form:{
                title: "",
                description: "",
                author: "",
                image: "",
                published_status: "",
            },
            articles: []      
        }
    },
    methods: {
        openModal(type,content){
            this.modalType = type
            this.modal = !this.modal
            type !== "add" ? {...this.form} = content : ''
        },
        closeModal(){
            this.modal = false
            this.modalType = null
            this.form = { title: "", content: "", category: "", image: "" }
        }
    },
    mounted() {
        this.$getAllArticles();
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
            grid-template-columns: 0.5fr 0.7fr 1fr 0.5fr 0.5fr 0.7fr;
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
            grid-template-columns: 0.5fr 0.7fr 1fr 0.5fr 0.5fr 0.7fr;
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