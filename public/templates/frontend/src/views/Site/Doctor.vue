<template>
    <div class="doctor">
        <div class="container">
            <Loader v-if="loading" />
            <TopHeader />
            <Navbar />
            <Locator :title="'Doctor'" />
            <div class="content">
                <div class="doctor-wrapper" v-if="doctor">
                    <div class="doctor-description">
                        <div class="profile">
                            <div class="cover">
                                <img :src="$file(doctor.image)" draggable="false" alt="article-cover" />
                            </div>
                            <div class="profile-description">
                                <h3 class="name">Dr. {{ doctor.firstname }} {{ doctor.lastname }}</h3>
                                <h4 class="position" v-if="doctor.department"><span>Department:</span> {{ doctor.department.name }}</h4>
                                <h4 class="position" v-if="doctor.position"><span>Position:</span> {{ doctor.position }}</h4>
                                <h4 class="regno" v-if="doctor.reg_no"><span>Reg No:</span> {{ doctor.reg_no }} </h4>
                                <h4 class="phone"><span>Phone:</span> {{ doctor.phone }}</h4>
                                <h4 class="email"><span>Email:</span> {{ doctor.email }}</h4>
                                <div class="socials">
                                    <a href="https://www.facebook.com" v-if="doctor.facebook" target="_blank">
                                        <svg fill="#000000" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>facebook</title> <path d="M30.996 16.091c-0.001-8.281-6.714-14.994-14.996-14.994s-14.996 6.714-14.996 14.996c0 7.455 5.44 13.639 12.566 14.8l0.086 0.012v-10.478h-3.808v-4.336h3.808v-3.302c-0.019-0.167-0.029-0.361-0.029-0.557 0-2.923 2.37-5.293 5.293-5.293 0.141 0 0.281 0.006 0.42 0.016l-0.018-0.001c1.199 0.017 2.359 0.123 3.491 0.312l-0.134-0.019v3.69h-1.892c-0.086-0.012-0.185-0.019-0.285-0.019-1.197 0-2.168 0.97-2.168 2.168 0 0.068 0.003 0.135 0.009 0.202l-0.001-0.009v2.812h4.159l-0.665 4.336h-3.494v10.478c7.213-1.174 12.653-7.359 12.654-14.814v-0z"></path> </g></svg>
                                    </a>
                                    <a href="https://www.x.com" v-if="doctor.twiiter" target="_blank">
                                        <svg fill="#000000" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M1920 311.856c-70.701 33.769-146.598 56.47-226.221 66.86 81.317-52.517 143.774-135.529 173.252-234.691-76.236 48.678-160.716 84.028-250.391 103.002-71.718-82.56-174.268-134.06-287.435-134.06-217.75 0-394.165 189.966-394.165 424.206 0 33.318 3.614 65.619 10.165 96.678C617.9 616.119 327.304 447.385 133.045 190.67c-33.77 62.57-53.309 135.53-53.309 213.233 0 147.162 91.031 276.818 196.744 353.054-64.602-2.26-157.101-21.46-157.101-53.309v5.648c0 205.327 114.41 376.658 294.55 415.849-32.978 9.487-78.38 14.795-114.409 14.795-25.412 0-55.454-2.71-79.624-7.793 50.26 168.509 193.13 291.163 365.478 294.777-134.852 113.506-306.07 181.383-490.616 181.383-31.85 0-64.038-2.033-94.758-5.873 174.494 120.17 381.176 190.532 603.67 190.532 724.97 0 1121.055-646.136 1121.055-1206.55 0-18.41-.452-36.932-1.356-55.116 77.026-59.746 143.887-134.4 196.631-219.444" fill-rule="evenodd"></path> </g></svg>
                                    </a>
                                    <a href="https://www.instagram.com" v-if="doctor.instagram" target="_blank">
                                        <svg fill="#000000" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>instagram</title> <path d="M25.805 7.996c0 0 0 0.001 0 0.001 0 0.994-0.806 1.799-1.799 1.799s-1.799-0.806-1.799-1.799c0-0.994 0.806-1.799 1.799-1.799v0c0.993 0.001 1.798 0.805 1.799 1.798v0zM16 20.999c-2.761 0-4.999-2.238-4.999-4.999s2.238-4.999 4.999-4.999c2.761 0 4.999 2.238 4.999 4.999v0c0 0 0 0.001 0 0.001 0 2.76-2.237 4.997-4.997 4.997-0 0-0.001 0-0.001 0h0zM16 8.3c0 0 0 0-0 0-4.253 0-7.7 3.448-7.7 7.7s3.448 7.7 7.7 7.7c4.253 0 7.7-3.448 7.7-7.7v0c0-0 0-0 0-0.001 0-4.252-3.447-7.7-7.7-7.7-0 0-0 0-0.001 0h0zM16 3.704c4.003 0 4.48 0.020 6.061 0.089 1.003 0.012 1.957 0.202 2.84 0.538l-0.057-0.019c1.314 0.512 2.334 1.532 2.835 2.812l0.012 0.034c0.316 0.826 0.504 1.781 0.516 2.778l0 0.005c0.071 1.582 0.087 2.057 0.087 6.061s-0.019 4.48-0.092 6.061c-0.019 1.004-0.21 1.958-0.545 2.841l0.019-0.058c-0.258 0.676-0.64 1.252-1.123 1.726l-0.001 0.001c-0.473 0.484-1.049 0.866-1.692 1.109l-0.032 0.011c-0.829 0.316-1.787 0.504-2.788 0.516l-0.005 0c-1.592 0.071-2.061 0.087-6.072 0.087-4.013 0-4.481-0.019-6.072-0.092-1.008-0.019-1.966-0.21-2.853-0.545l0.059 0.019c-0.676-0.254-1.252-0.637-1.722-1.122l-0.001-0.001c-0.489-0.47-0.873-1.047-1.114-1.693l-0.010-0.031c-0.315-0.828-0.506-1.785-0.525-2.785l-0-0.008c-0.056-1.575-0.076-2.061-0.076-6.053 0-3.994 0.020-4.481 0.076-6.075 0.019-1.007 0.209-1.964 0.544-2.85l-0.019 0.059c0.247-0.679 0.632-1.257 1.123-1.724l0.002-0.002c0.468-0.492 1.045-0.875 1.692-1.112l0.031-0.010c0.823-0.318 1.774-0.509 2.768-0.526l0.007-0c1.593-0.056 2.062-0.075 6.072-0.075zM16 1.004c-4.074 0-4.582 0.019-6.182 0.090-1.315 0.028-2.562 0.282-3.716 0.723l0.076-0.025c-1.040 0.397-1.926 0.986-2.656 1.728l-0.001 0.001c-0.745 0.73-1.333 1.617-1.713 2.607l-0.017 0.050c-0.416 1.078-0.67 2.326-0.697 3.628l-0 0.012c-0.075 1.6-0.090 2.108-0.090 6.182s0.019 4.582 0.090 6.182c0.028 1.315 0.282 2.562 0.723 3.716l-0.025-0.076c0.796 2.021 2.365 3.59 4.334 4.368l0.052 0.018c1.078 0.415 2.326 0.669 3.628 0.697l0.012 0c1.6 0.075 2.108 0.090 6.182 0.090s4.582-0.019 6.182-0.090c1.315-0.029 2.562-0.282 3.716-0.723l-0.076 0.026c2.021-0.796 3.59-2.365 4.368-4.334l0.018-0.052c0.416-1.078 0.669-2.326 0.697-3.628l0-0.012c0.075-1.6 0.090-2.108 0.090-6.182s-0.019-4.582-0.090-6.182c-0.029-1.315-0.282-2.562-0.723-3.716l0.026 0.076c-0.398-1.040-0.986-1.926-1.729-2.656l-0.001-0.001c-0.73-0.745-1.617-1.333-2.607-1.713l-0.050-0.017c-1.078-0.416-2.326-0.67-3.628-0.697l-0.012-0c-1.6-0.075-2.108-0.090-6.182-0.090z"></path> </g></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="doctor-overview">
                            <div class="biography" v-if="doctor.bio">
                                <h3>Biography</h3>
                                <p v-html="doctor.bio"></p>
                            </div>
                            <div class="educational-background">
                                <div v-html="doctor.description"></div>
                            </div>
                            <div class="reviews-container">
                                <!-- <h3>Reviews</h3> -->
                                <!-- <div class="all-reviews">
                                    <div class="review">
                                        <div class="pic">
                                            <img src="@/assets/images/slide-4.jpg" alt="">
                                        </div>
                                        <div>
                                            <h4 class="name">John Doe</h4>
                                            <h5 class="time">4 Minutes Ago</h5>
                                            <p class="review-description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat, ducimus aut. Explicabo quia recusandae architecto quasi nesciunt harum dolorum odio eum veniam, ratione totam voluptas? Maiores non mollitia pariatur ipsam.</p>
                                        </div>
                                    </div>
                                    <div class="review">
                                        <div class="pic">
                                            <img src="@/assets/images/slide-4.jpg" alt="">
                                        </div>
                                        <div>
                                            <h4 class="name">John Doe</h4>
                                            <h5 class="time">4 Minutes Ago</h5>
                                            <p class="review-description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat, ducimus aut. Explicabo quia recusandae architecto quasi nesciunt harum dolorum odio eum veniam, ratione totam voluptas? Maiores non mollitia pariatur ipsam.</p>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- <div class="no-reviews">Be the first to comment!</div> -->
                                <!-- <div class="view-more"><button>View more</button></div>
                                <form class="form">
                                    <textarea rows="4" placeholder="Write something...." required></textarea>
                                    <button>Send Review</button>
                                </form> -->
                            </div>
                        </div>
                    </div>
                    <div class="meet-doctor">
                        <div class="weekly-schedule" v-if="doctor.working_days">
                            <h3>Available time</h3>
                            <div class="week">
                                <div class="day" v-for="(day,index) in doctor.working_days" :key="index">
                                    <label>{{ day.day }}</label>
                                    <label v-if="day.from && day.to">{{ day.from }} - {{ day.to }}</label>
                                    <label v-else>Not Available</label>
                                </div>
                            </div>
                        </div>
                        <form class="book-appointment" @submit.prevent="submitForm">
                            <h3>Book for an appointment</h3>
                            <div class="flex" v-if="this.$loggedUser() && this.$loggedUser().role.role != 'patient'">
                                <div>
                                    <label>First Name <span>*</span></label>
                                    <input type="text" v-model="appointment.firstname" placeholder="First Name" required />
                                </div>
                                <div>
                                    <label>Last Name <span>*</span></label>
                                    <input type="text" v-model="appointment.lastname" placeholder="Last Name" required />
                                </div>
                            </div>
                            <div class="flex" v-if="this.$loggedUser() && this.$loggedUser().role.role != 'patient'">
                                <div>
                                    <label>Phone <span>*</span></label>
                                    <input type="text" v-model="appointment.phone" placeholder="Subject" required />
                                </div>
                                <div>
                                    <label>Email <span>*</span></label>
                                    <input type="email" v-model="appointment.email" placeholder="Email" required />
                                </div>
                            </div>
                            <div class="flex">
                                <div>
                                    <label>Date <span>*</span></label>
                                    <input type="date" v-model="appointment.date" required />
                                </div>
                                <div>
                                    <label>Time <span>*</span></label>
                                    <input type="time" v-model="appointment.time" required />
                                </div>
                            </div>
                            <label>Message <span>*</span></label>
                            <textarea rows="5" v-model="appointment.description" placeholder="Write message...."></textarea>
                            <button>Book An Appointment</button>
                        </form>
                    </div>
                </div>
            </div>
            <Partners />
            <Footer />
        </div>
    </div>
</template>

<script>
export default {
    name: 'Doctor',
    data() {
        return {
            doctor: [],
            loading: false,
            appointment: {
                firstname: '',
                lastname: '',
                email: '',
                department_id: '',
                doctor_id: '',
                phone: '',
                date: '',
                time: '',
                description: ''
            },
        }
    },
    methods: {
        getDoctor(){
            this.loading = true;
            this.$store.dispatch('GET_A_DOCTOR', this.$route.params.id)
                .then(res =>{
                    this.loading = false;
                    res.data.working_days = JSON.parse(res.data.working_days);
                    this.doctor = res.data;
                })
                .catch(err =>{
                    this.loading = false;
                    console.log(err);
                })
        },
        submitForm(){
            if(!this.$loggedUser()){
                this.$notify({
                    text: 'You must be logged in to book an appointment',
                    type: "error"
                })
                return
            }
            if(this.$loggedUser() && this.$loggedUser().role.role == 'patient'){
                this.appointment.firstname = this.$loggedUser().firstname
                this.appointment.lastname = this.$loggedUser().lastname
                this.appointment.email = this.$loggedUser().email
                this.appointment.phone = this.$loggedUser().phone
            }
            this.appointment.department_id = this.doctor.department_id
            this.appointment.doctor_id = this.doctor.id
            this.$store.dispatch('CREATE_APPOINTMENT', this.appointment)
                .then(res => {
                    if(res.data.status == 'success'){
                        this.$notify({
                            text: res.data.message,
                            type: "success"
                        })
                        this.appointment = { firstname: '', lastname: '', email: '', department_id: '', doctor_id: '', phone: '', date: '', time: '', message: ''}
                    }else{
                        this.$notify({
                            text: res.data.message,
                            type: "error"
                        })
                    }
                })
                .catch(err => {
                    console.log(err)
                })
        }
    },
    mounted(){
        this.getDoctor();
    }
}
</script>

<style lang="scss">
@import '../../scss/index.scss';
.doctor{
    .doctor-wrapper{
        margin: 40px 0;
        display: grid;
        column-gap: 80px;
        grid-template-columns: 1fr 0.6fr;
        @media(max-width: 970px){
            grid-template-columns: 1fr;
            column-gap: 0;
        }
        .doctor-description{
            .profile{
                display: flex;
                align-items: center;
                column-gap: 40px;
                margin: 0 0 40px;
                    @media(max-width: 470px){
                    flex-direction: column;
                    row-gap: 20px;
                }
                .cover{
                    width: 300px;
                    height: 300px;
                    flex-shrink: 0;
                    position: relative;
                    overflow: hidden;
                    border-radius: 8px;
                    @media(max-width: 666px){
                        width: 200px;
                        height: 200px;
                    }
                    img{
                        position: absolute;
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }
                }
                .profile-description{
                    h3{
                        font-size: 1.3rem;
                        font-weight: 600;
                        margin: 0 0 10px;
                        color: $black;
                        @media(max-width: 666px){
                            font-size: 1rem;
                        }
                    }
                    h4{
                        font-size: 0.8rem;
                        font-weight: 400;
                        margin: 0 0 10px;
                        color: $black;
                        @media(max-width: 666px){
                            font-size: 0.8rem;
                        }
                        span{
                            font-size: 0.9rem;
                            font-weight: 600;
                            margin: 0 5px 0 0;
                        }
                    }
                    .socials{
                        display: flex;
                        align-items: center;
                        column-gap: 20px;
                        row-gap: 7px;
                        margin: 15px 0 0;
                        a{
                            width: 30px;
                            height: 30px;
                            border-radius: 50%;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            transition: all 0.3s ease;
                            position: relative;
                            border: 1px solid $lightred;
                            background: $white;
                            &:hover{
                                background-color: $lightred;
                                svg{
                                    fill: $white;
                                }
                            }
                            svg{
                                position: absolute;
                                width: 50%;
                                height: 50%;
                                top: 50%;
                                left: 50%;
                                transform: translate(-50%, -50%);
                                fill: $lightred;
                            }
                        }
                    }
                }
            }
            .doctor-overview{
                h3{
                    font-size: 1rem;
                    font-weight: 500;
                    margin: 0 0 15px;
                    color: $black;
                    padding: 0 0 10px;
                    max-width: 60%;
                    border-bottom: 1px solid #74747428;
                    margin: 0 0 40px;
                    @media(max-width: 470px){
                        max-width: 100%;
                    }
                }
                .biography{
                    p{
                        font-size: 0.8rem;
                        margin: 0 0 10px;
                        line-height: 1.6rem;
                        color: #747474;
                    }
                }
                .educational-background{
                    h3,h4,h5,h6,h2,h1{
                        font-size: 1rem;
                        font-weight: 500;
                        margin: 0 0 15px;
                        color: $black;
                        padding: 0 0 10px;
                        max-width: 60%;
                        border-bottom: 1px solid #74747428;
                        @media(max-width: 470px){
                            max-width: 100%;
                        }
                    }
                    p{
                        font-size: 0.8rem;
                        margin: 0 0 10px;
                        line-height: 1.6rem;
                        color: #747474;
                    }
                    label{
                        font-size: 0.8rem;
                        margin: 0 0 10px;
                        color: $black;
                        display: block;
                        color: #747474;
                    }
                }
                .reviews-container{
                    margin: 30px 0 0;
                    .all-reviews{
                        .review{
                            display: flex;
                            column-gap: 30px;
                            .pic{
                                width: 50px;
                                height: 50px;
                                flex-shrink: 0;
                                position: relative;
                                overflow: hidden;
                                border-radius: 50%;
                                img{
                                    position: absolute;
                                    width: 100%;
                                    height: 100%;
                                    object-fit: cover;
                                }
                            }
                            .name{
                                font-size: 0.8rem;
                                font-weight: 500;
                                margin: 0 0 3px;
                                color: $black;
                            }
                            .time{
                                font-size: 0.7rem;
                                font-weight: 400;
                                margin: 0;
                                color: #747474;
                            }
                            .review-description{
                                font-size: 0.75rem;
                                line-height: 1.3rem;
                                margin: 10px 0;
                                padding: 0 0 15px;
                                color: #747474;
                                border-bottom: 1px solid #74747428;
                            }
                        }
                    }
                    .no-reviews{
                        margin: 10px 0 10px;
                        font-size: 0.8rem;
                        color: #666;
                    }
                    .view-more{
                        display: flex;
                        justify-content: center;
                        button{
                            font-size: 0.8rem;
                            padding: 7px 15px;
                            background: $white;
                            color: $lightred;
                            border: 1px solid $lightred;
                            border-radius: 4px;
                            margin: 20px 0;
                            cursor: pointer;
                        }
                    }
                    .form{
                        max-width: 500px;
                        textarea{
                            font-size: 0.8rem;
                            width: 100%;
                            padding: 15px;
                            border: 1px solid #ccc;
                            border-radius: 4px;
                            margin: 7px 0;
                            resize: none;
                            color: #666;
                            &:focus{
                                outline: none;
                                border: 1px solid $lightred;
                            }
                        }
                        button{
                            width: 100%;
                            font-size: 0.8rem;
                            padding: 7px 0;
                            border: none;
                            background: $lightred;
                            color: #fff;
                            border-radius: 4px;
                            cursor: pointer;
                        }
                    }
                }
            }
        }
        .meet-doctor{
            h3{
                font-size: 1rem;
                font-weight: 500;
                margin: 0 0 15px;
                color: $black;
                padding: 0 0 10px;
            }
            .weekly-schedule{
                margin: 0 0 30px 0;
                .week{
                    display: flex;
                    flex-direction: column;
                    row-gap: 10px;
                    .day{
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        border-radius: 4px;
                        padding: 13px 10px;
                        &:nth-child(odd){
                            background: #f5f5f5;
                        }
                        label{
                            font-size: 0.75rem;
                            font-weight: 400;
                            color: $black;
                        }
                    }
                }
            }
            .book-appointment{
                width: 100%;
                .flex{
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    column-gap: 10px;
                    @media(max-width: 470px){
                        grid-template-columns: 1fr;
                    }
                }
                label{
                    display: block;
                    font-size: 0.9rem;
                    color: $realblack;
                    span{
                        color: $lightred;
                    }
                }
                input,textarea,select{
                    font-size: 0.8rem;
                    width: 100%;
                    padding: 8px 10px;
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
                }
            }
        }
    }
}
</style>