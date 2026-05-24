<template>
    <div class="home">
        <div class="container">
            <TopHeader />
            <Navbar />
            <Locator :title="'Doctors'" />
            <div class="content">
                <Loader v-if="loading" />
                <div class="team" v-if="doctors.length > 0">
                    <h2>Our doctors</h2>
                    <p>Meet Our Amazing Doctors</p>
                    <div class="team-container">
                        <router-link :to="`/doctors/${doctor.id}/${doctor.firstname.toLowerCase()}-${doctor.lastname.toLowerCase()}`" class="team-container-item" v-for="doctor in doctors" :key="doctor.id">
                            <div class="img"><img :src="$file(doctor.image)" draggable="false" alt=""></div>
                            <div class="team-container-item-content">
                                <h4 class="name">{{ doctor.firstname }} {{ doctor.lastname }}</h4>
                                <label class="department">{{ doctor.department.name }}</label>
                                <label class="title" v-if="doctor.position">
                                    <svg fill="#000000" viewBox="-2.5 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M11.56 10.11v2.046a3.827 3.827 0 1 1-7.655 0v-.45A3.61 3.61 0 0 1 .851 8.141V5.25a1.682 1.682 0 0 1 .763-1.408 1.207 1.207 0 1 1 .48 1.04.571.571 0 0 0-.135.368v2.89a2.5 2.5 0 0 0 5 0V5.25a.57.57 0 0 0-.108-.334 1.208 1.208 0 1 1 .533-1.018 1.681 1.681 0 0 1 .683 1.352v2.89a3.61 3.61 0 0 1-3.054 3.565v.45a2.719 2.719 0 0 0 5.438 0V10.11a2.144 2.144 0 1 1 1.108 0zm.48-2.07a1.035 1.035 0 1 0-1.035 1.035 1.037 1.037 0 0 0 1.036-1.035z"></path></g></svg>
                                    {{ doctor.position }}
                                </label>
                            </div>
                            <div class="socials">
                                <a href="https://www.facebook.com" target="_blank" v-if="doctor.facebook">
                                    <svg fill="#000000" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>facebook</title> <path d="M30.996 16.091c-0.001-8.281-6.714-14.994-14.996-14.994s-14.996 6.714-14.996 14.996c0 7.455 5.44 13.639 12.566 14.8l0.086 0.012v-10.478h-3.808v-4.336h3.808v-3.302c-0.019-0.167-0.029-0.361-0.029-0.557 0-2.923 2.37-5.293 5.293-5.293 0.141 0 0.281 0.006 0.42 0.016l-0.018-0.001c1.199 0.017 2.359 0.123 3.491 0.312l-0.134-0.019v3.69h-1.892c-0.086-0.012-0.185-0.019-0.285-0.019-1.197 0-2.168 0.97-2.168 2.168 0 0.068 0.003 0.135 0.009 0.202l-0.001-0.009v2.812h4.159l-0.665 4.336h-3.494v10.478c7.213-1.174 12.653-7.359 12.654-14.814v-0z"></path> </g></svg>
                                </a>
                                <a href="https://www.x.com" target="_blank" v-if="doctor.twitter">
                                    <svg fill="#000000" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M1920 311.856c-70.701 33.769-146.598 56.47-226.221 66.86 81.317-52.517 143.774-135.529 173.252-234.691-76.236 48.678-160.716 84.028-250.391 103.002-71.718-82.56-174.268-134.06-287.435-134.06-217.75 0-394.165 189.966-394.165 424.206 0 33.318 3.614 65.619 10.165 96.678C617.9 616.119 327.304 447.385 133.045 190.67c-33.77 62.57-53.309 135.53-53.309 213.233 0 147.162 91.031 276.818 196.744 353.054-64.602-2.26-157.101-21.46-157.101-53.309v5.648c0 205.327 114.41 376.658 294.55 415.849-32.978 9.487-78.38 14.795-114.409 14.795-25.412 0-55.454-2.71-79.624-7.793 50.26 168.509 193.13 291.163 365.478 294.777-134.852 113.506-306.07 181.383-490.616 181.383-31.85 0-64.038-2.033-94.758-5.873 174.494 120.17 381.176 190.532 603.67 190.532 724.97 0 1121.055-646.136 1121.055-1206.55 0-18.41-.452-36.932-1.356-55.116 77.026-59.746 143.887-134.4 196.631-219.444" fill-rule="evenodd"></path> </g></svg>
                                </a>
                                <a href="https://www.instagram.com" target="_blank" v-if="doctor.instagram">
                                    <svg fill="#000000" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>instagram</title> <path d="M25.805 7.996c0 0 0 0.001 0 0.001 0 0.994-0.806 1.799-1.799 1.799s-1.799-0.806-1.799-1.799c0-0.994 0.806-1.799 1.799-1.799v0c0.993 0.001 1.798 0.805 1.799 1.798v0zM16 20.999c-2.761 0-4.999-2.238-4.999-4.999s2.238-4.999 4.999-4.999c2.761 0 4.999 2.238 4.999 4.999v0c0 0 0 0.001 0 0.001 0 2.76-2.237 4.997-4.997 4.997-0 0-0.001 0-0.001 0h0zM16 8.3c0 0 0 0-0 0-4.253 0-7.7 3.448-7.7 7.7s3.448 7.7 7.7 7.7c4.253 0 7.7-3.448 7.7-7.7v0c0-0 0-0 0-0.001 0-4.252-3.447-7.7-7.7-7.7-0 0-0 0-0.001 0h0zM16 3.704c4.003 0 4.48 0.020 6.061 0.089 1.003 0.012 1.957 0.202 2.84 0.538l-0.057-0.019c1.314 0.512 2.334 1.532 2.835 2.812l0.012 0.034c0.316 0.826 0.504 1.781 0.516 2.778l0 0.005c0.071 1.582 0.087 2.057 0.087 6.061s-0.019 4.48-0.092 6.061c-0.019 1.004-0.21 1.958-0.545 2.841l0.019-0.058c-0.258 0.676-0.64 1.252-1.123 1.726l-0.001 0.001c-0.473 0.484-1.049 0.866-1.692 1.109l-0.032 0.011c-0.829 0.316-1.787 0.504-2.788 0.516l-0.005 0c-1.592 0.071-2.061 0.087-6.072 0.087-4.013 0-4.481-0.019-6.072-0.092-1.008-0.019-1.966-0.21-2.853-0.545l0.059 0.019c-0.676-0.254-1.252-0.637-1.722-1.122l-0.001-0.001c-0.489-0.47-0.873-1.047-1.114-1.693l-0.010-0.031c-0.315-0.828-0.506-1.785-0.525-2.785l-0-0.008c-0.056-1.575-0.076-2.061-0.076-6.053 0-3.994 0.020-4.481 0.076-6.075 0.019-1.007 0.209-1.964 0.544-2.85l-0.019 0.059c0.247-0.679 0.632-1.257 1.123-1.724l0.002-0.002c0.468-0.492 1.045-0.875 1.692-1.112l0.031-0.010c0.823-0.318 1.774-0.509 2.768-0.526l0.007-0c1.593-0.056 2.062-0.075 6.072-0.075zM16 1.004c-4.074 0-4.582 0.019-6.182 0.090-1.315 0.028-2.562 0.282-3.716 0.723l0.076-0.025c-1.040 0.397-1.926 0.986-2.656 1.728l-0.001 0.001c-0.745 0.73-1.333 1.617-1.713 2.607l-0.017 0.050c-0.416 1.078-0.67 2.326-0.697 3.628l-0 0.012c-0.075 1.6-0.090 2.108-0.090 6.182s0.019 4.582 0.090 6.182c0.028 1.315 0.282 2.562 0.723 3.716l-0.025-0.076c0.796 2.021 2.365 3.59 4.334 4.368l0.052 0.018c1.078 0.415 2.326 0.669 3.628 0.697l0.012 0c1.6 0.075 2.108 0.090 6.182 0.090s4.582-0.019 6.182-0.090c1.315-0.029 2.562-0.282 3.716-0.723l-0.076 0.026c2.021-0.796 3.59-2.365 4.368-4.334l0.018-0.052c0.416-1.078 0.669-2.326 0.697-3.628l0-0.012c0.075-1.6 0.090-2.108 0.090-6.182s-0.019-4.582-0.090-6.182c-0.029-1.315-0.282-2.562-0.723-3.716l0.026 0.076c-0.398-1.040-0.986-1.926-1.729-2.656l-0.001-0.001c-0.73-0.745-1.617-1.333-2.607-1.713l-0.050-0.017c-1.078-0.416-2.326-0.67-3.628-0.697l-0.012-0c-1.6-0.075-2.108-0.090-6.182-0.090z"></path> </g></svg>
                                </a>
                            </div>
                        </router-link>
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
    name: 'Doctors',
    data() {
        return {
            loading: false,
            doctors: []
        }
    },
    methods: {
        getAllDoctors(){
            this.loading = true
            this.$store.dispatch('GET_ALL_DOCTORS')
                .then(res => {
                    this.loading = false
                    res.data.forEach(doctor => {
                        doctor.working_days = JSON.parse(doctor.working_days)
                    });
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
    }
}
</script>

<style lang="scss">
@import '../../scss/index.scss';
.team{
    padding: 10px 0;
    margin: 10px 0;
    h2{
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: $lightred;
        text-transform: uppercase;
    }
    p{
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 10px;
    }
    .departments{
        display: flex;
        flex-wrap: wrap;
        column-gap: 20px;
        margin: 15px 0 20px 0;
        button{
            all: unset;
            font-size: 0.8rem;
            border: 1px solid $lightred;
            border-radius: 4px;
            color: $lightred;
            padding: 4px 10px;
            cursor: pointer;
            transition: .5s;
            &.active{
                background: $lightred;
                color: $white;
            }
        }
    }
    .team-container{
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        grid-gap: 20px;
        margin: 40px 0 0;
        @media(max-width: 991px){
            grid-template-columns: 1fr 1fr 1fr;
        }
        @media(max-width: 768px){
            grid-template-columns: 1fr 1fr;
        }
        @media(max-width: 540px){
            grid-template-columns: 1fr;
        }
        .team-container-item{
            overflow: hidden;
            border-radius: 5px;
            box-shadow: 0 0 20px -2px rgba(0,0,0,0.1);
            width: 100%;
            height: 350px;
            position: relative;
            .img{
                width: 100%;
                height: 100%;
                transition: .6s;
                object-fit: cover;
                position: absolute;
                img{
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    object-position: top;
                    transition: .6s;
                }
            }
            &:hover{
                img{
                    transform: scale(1.1);
                }
                .socials{
                    opacity: 1;
                    pointer-events: all;
                    right: 10px;
                }
            }

            .socials{
                display: flex;
                align-items: center;
                flex-direction: column;
                row-gap: 7px;
                position: absolute;
                top: 10px;
                right: -10px;
                transition: .6s;
                opacity: 0;
                pointer-events: none;
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
            .team-container-item-content{
                padding: 10px 20px 15px;
                color: $realblack;
                transition: .6s;
                margin: 20px 0 0;
                position: absolute;
                width: 100%;
                bottom: 0;
                background: #ffffff;
                .name{
                    font-size: 0.8rem;
                    font-weight: 500;
                }
                .department{
                    font-size: 0.8rem;
                    border-radius: 4px;
                    margin: 10px 0;
                    width: fit-content;
                    color: $red;
                    text-transform: uppercase;
                    display: block;
                }
                .title{
                    font-size: 0.8rem;
                    display: flex;
                    align-items: center;
                    svg{
                        width: 22px;
                        height: 22px;
                        margin: 0 7px 0 0;
                        fill: $lightred;
                    }
                }
            }
        }
    }
    button{
        display: block;
        margin: 20px auto 0;
        padding: 5px 20px;
        border: none;
        border-radius: 5px;
        background: $lightred;
        color: $white;
        font-weight: 400;
        letter-spacing: 0.1rem;
        transition: .6s;
        text-transform: uppercase;
        font-size: 0.8rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        column-gap: 10px;
        svg{
            width: 20px;
            height: 20px;
            fill: $white;
        }
        &:hover{
            background: $red;
        }
    }
}
</style>