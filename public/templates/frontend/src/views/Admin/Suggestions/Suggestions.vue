<template>
  <div class="dashboardContent">
    <Sidebar />
    <div class="contents">
        <Topbar />
        <Loader v-if="loading" />
        <Modal v-if="modal" :current="form" :type="modalType" @close="closeModal()" @refresh="getAllContacts()" />
        <div class="detailed-content">
            <div class="locator-search">
                <h1 class="locator">Suggestions box</h1>
                <!-- <div class="end">
                    <div class="search">
                        <input type="text" placeholder="Search for a subscriber">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g clip-path="url(#clip0_15_152)"> <rect width="24" height="24" fill="white"></rect> <circle cx="10.5" cy="10.5" r="6.5" stroke="#ccc" stroke-linejoin="round"></circle> <path d="M19.6464 20.3536C19.8417 20.5488 20.1583 20.5488 20.3536 20.3536C20.5488 20.1583 20.5488 19.8417 20.3536 19.6464L19.6464 20.3536ZM20.3536 19.6464L15.3536 14.6464L14.6464 15.3536L19.6464 20.3536L20.3536 19.6464Z" fill="#000000"></path> </g> <defs> <clipPath id="clip0_15_152"> <rect width="24" height="24" fill="white"></rect> </clipPath> </defs> </g></svg>
                    </div>
                </div> -->
            </div>
            <div class="table" v-if="suggestions.length > 0">
                <div class="headings">
                    <h3 class="heading">Message</h3>
                    <h3 class="heading">Date</h3>
                    <h3 class="heading"></h3>
                </div>
                <div class="service" v-for="suggestion in suggestions" :key="suggestion.id">
                    <label class="data">{{ suggestion.message }}</label>
                    <label class="data">{{ suggestion.date }}</label>
                    <div class="data actions">
                        <button class="btn" @click="openModel('view', suggestion)">View</button>
                    </div>
                </div>
            </div>
            <label v-else class="nodata">No suggestions available</label>
        </div>
    </div>
  </div>
</template>

<script>
import Modal from "./components/SuggestionModal.vue";
export default {
    name: "AdminSuggestions",
    components: { Modal },
    data() {
        return {
            loading: false,
            suggestions: [],
            modal: false,
            modalType: null,
            form: {
                name: "",
                email: ""
            }
        }
    },
    methods: {
        getAllSuggestions(){
            this.loading = true;
            this.$store.dispatch('GET_ALL_SUGGESTIONS')
                .then(res => {
                    this.loading = false;
                    this.suggestions = res.data;
                })
                .catch(err => {
                    this.loading = false;
                    console.log(err);
                })
        },
        openModel(type, current){
            this.modal = true;
            this.modalType = type;
            this.form = current;
        },
        closeModal(){
            this.modal = false;
            this.modalType = null;
            this.form = {
                name: "",
                email: ""
            }
        }
    },
    mounted() {
        this.getAllSuggestions();
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
            grid-template-columns: 1fr 0.5fr 0.5fr;
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
            grid-template-columns: 1fr 0.5fr 0.5fr;
            column-gap: 10px;
            margin: 0 0 15px;
            padding: 10px 0;
            align-items: center;
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