<template>
    <div class="navbar">
        <div class="navbar-logo">
            <img :src="$file($store.state.webInfo.logo)" alt="logo">
        </div>
        <div class="navbar-links">
            <div class="links" :class="{ active: menu }">
                <router-link to="/">Home</router-link>
                <router-link to="/departments" class="drop" @click="dropdown = !dropdown">
                    Departments
                    <div class="dropdown" :class="{ active: dropdown }">
                        <div class="dropdown-item" v-for="department in departments.slice(0,5)" :key="department.id">
                            <router-link :to="`/departments/${department.id}/${hyphernate(department.name)}`">{{ department.name }}</router-link>
                        </div>
                        <div class="dropdown-item" v-if="departments.length > 6">
                            <router-link to="/departments">See more</router-link>
                        </div>
                    </div>
                </router-link>
                <router-link to="/leadership-team">Leadership Team</router-link>
                <router-link to="/updates">Updates</router-link>
                <router-link to="/gallery">Gallery</router-link>
                <router-link to="/about">About us</router-link>
                <router-link to="/contact">Contact us</router-link>
            </div>
            <div class="other">
                <div class="hamburger" @click="menu = !menu" :class="{ active: menu }">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <button class="highlighted" @click="$router.push('/appointment')">
                    <svg fill="#000000" viewBox="-2.5 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M11.56 10.11v2.046a3.827 3.827 0 1 1-7.655 0v-.45A3.61 3.61 0 0 1 .851 8.141V5.25a1.682 1.682 0 0 1 .763-1.408 1.207 1.207 0 1 1 .48 1.04.571.571 0 0 0-.135.368v2.89a2.5 2.5 0 0 0 5 0V5.25a.57.57 0 0 0-.108-.334 1.208 1.208 0 1 1 .533-1.018 1.681 1.681 0 0 1 .683 1.352v2.89a3.61 3.61 0 0 1-3.054 3.565v.45a2.719 2.719 0 0 0 5.438 0V10.11a2.144 2.144 0 1 1 1.108 0zm.48-2.07a1.035 1.035 0 1 0-1.035 1.035 1.037 1.037 0 0 0 1.036-1.035z"></path></g></svg>
                    Appointment
                </button>
                <button class="user">
                    <div class="profile-img" v-if="$loggedUser() && $loggedUser().role.role == 'patient'" @click="$router.push('/profile')">
                        <img :src="$file($loggedUser().image)" alt="Profile Picture">
                    </div>
                    <div v-else class="profile" @click="$store.state.authmodal = true">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 11C3 7.22876 3 5.34315 4.17157 4.17157C5.34315 3 7.22876 3 11 3H13C16.7712 3 18.6569 3 19.8284 4.17157C21 5.34315 21 7.22876 21 11V13C21 16.7712 21 18.6569 19.8284 19.8284C18.6569 21 16.7712 21 13 21H11C7.22876 21 5.34315 21 4.17157 19.8284C3 18.6569 3 16.7712 3 13V11Z" fill="#f46f58" fill-opacity="0.24"></path> <circle cx="12" cy="10" r="4" fill="#f46f58"></circle> <path fill-rule="evenodd" clip-rule="evenodd" d="M18.9463 20.2532C18.9616 20.3587 18.9048 20.4613 18.8063 20.5021C17.6048 21 15.8353 21 13 21H11C8.16476 21 6.3953 21 5.19377 20.5022C5.0953 20.4614 5.03846 20.3587 5.05373 20.2532C5.48265 17.2919 8.42909 15 12 15C15.571 15 18.5174 17.2919 18.9463 20.2532Z" fill="#f46f58"></path> </g></svg>
                    </div>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Navbar',
    data() {
        return {
            departments: [],
            dropdown: false,
            menu: false
        }
    },
    methods: {
        hyphernate(name){
            return name.replace(/\s+/g, '-').toLowerCase()
        },
    },
    mounted(){
        window.scrollTo(0,0)
        this.$getAllDepartments()
    }
}
</script>

<style lang="scss" scoped>
@import '../scss/index.scss';
.navbar{
    position: sticky;
    top: 0;
    z-index: 999;
    width: 100%;
    padding: 0 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: $white;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    height: 80px;
    @media (max-width: 955px){
        padding: 0 20px;
        height: 70px;
    }
    .navbar-logo{
        width: 150px;
        position: relative;
        flex-shrink: 0;
        @media (max-width: 1070px){
            width: 140px;
        }
        @media (max-width: 550px){
            width: 130px;
        }
        img{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            object-fit: contain;
        }
    }
    .navbar-links{
        display: flex;
        align-items: center;
        column-gap: 40px;
        @media (max-width: 1070px){
            column-gap: 30px;
        }
        .links{
            display: flex;
            align-items: center;
            column-gap: 40px;
            transition: .6s;
            @media (max-width: 1070px){
                column-gap: 30px;
            }
            @media (max-width: 955px){
                opacity: 0;
                row-gap: 20px;
                position: absolute;
                top: 130%;
                left: 0;
                width: 100%;
                height: 100vh;
                flex-direction: column;
                align-items: center;
                padding: 20px 0;
                background: #000000d7;
                backdrop-filter: blur(7px);
                pointer-events: none;
                border-top: 1px solid rgba(0,0,0,0.1);
                &.active{
                    opacity: 1;
                    pointer-events: all;
                    top: 100%;
                    display: flex;
                }
            }
        }
        .hamburger{
            display: none;
            @media (max-width: 955px){
                display: block;
                cursor: pointer;
                position: relative;
                width: 25px;
                height: 20px;
                span{
                    position: absolute;
                    width: 100%;
                    height: 2px;
                    background: $lightred;
                    transition: .6s;
                    &:nth-child(1){
                        top: 0;
                    }
                    &:nth-child(2){
                        top: 50%;
                        transform: translateY(-50%);
                    }
                    &:nth-child(3){
                        bottom: 0;
                    }
                }
                &.active{
                    span{
                        &:nth-child(1){
                            top: 50%;
                            transform: translateY(-50%) rotate(45deg);
                        }
                        &:nth-child(2){
                            opacity: 0;
                        }
                        &:nth-child(3){
                            bottom: 50%;
                            transform: translateY(50%) rotate(-45deg);
                        }
                    }
                }
            }
        }
        a{
            text-decoration: none;
            color: $black;
            font-weight: 400;
            font-size: 0.8rem;
            transition: .5s;
            position: relative;
            @media (max-width: 955px){
                width: 100%;
                text-align: center;
                color: $white;
            }
            &:after{
                content: '';
                position: absolute;
                bottom: -5px;
                right: 0;
                width: 0%;
                height: 1px;
                background: $lightred;
                transition: .5s;
            }
            &.drop{
                position: relative;
                display: flex;
                align-items: center;
                height: 80px;
                @media (max-width: 955px){
                    height: auto;
                    flex-direction: column;
                }
                &:after{
                    all: unset;
                }
                .dropdown{
                    position: absolute;
                    top: 100%;
                    transition: .6s;
                    left: 0;
                    width: fit-content;
                    background: $white;
                    opacity: 0;
                    pointer-events: none;
                    padding: 10px 0;
                    border-radius: 0 0 5px 5px;
                    box-shadow: 0 10px 10px rgba(0,0,0,0.1);
                    display: block;
                    .dropdown-item{
                        padding: 10px 20px;
                        border-bottom: 1px solid rgba(0,0,0,0.1);
                        @media(max-width: 955px){
                            padding: 10px 0;
                            border: none;
                        }
                        &:last-child{
                            border-bottom: none;
                        }
                        a{
                            all: unset;
                            color: $black;
                            font-weight: 400;
                            font-size: 0.8rem;
                            transition: .5s;
                            position: relative;
                            white-space: nowrap;
                            &:after{
                                all: unset;
                            }
                            &:hover{
                                color: $lightred;
                            }
                        }
                    }
                }
                &:hover{
                    @media(min-width: 955px){
                        .dropdown{
                            top: 100%;
                            opacity: 1;
                            pointer-events: all;
                        }
                    }
                }
            }
            &.router-link-exact-active{
                font-weight: 500;
                color: $lightred;
                @media(min-width: 955px){
                    &:after{
                        width: 100%;
                    }
                }
            }
            &:hover{
                color: $lightred;
                @media(min-width: 955px){
                    &:hover{
                        &:after{
                            width: 100%;
                            left: 0;
                        }
                    }
                }
            }
        }
    }
    .other{
        display: flex;
        align-items: center;
        column-gap: 10px;
        @media (max-width: 955px){
            column-gap: 15px;
            flex-direction: row-reverse;
        }
        .highlighted{
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
            @media (max-width: 550px){
                padding: 5px 15px;
                font-size: 0.7rem;
            }
            @media (max-width: 480px){
                display: none;
            }
            svg{
                width: 20px;
                height: 20px;
                fill: $white;
            }
            &:hover{
                background: $red;
            }
        }
        .user{
            all: unset;
            width: 40px;
            height: 40px;
            cursor: pointer;
            position: relative;
            svg{
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }
            .profile-img{
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                position: absolute;
                width: 80%;
                height: 80%;
                border-radius: 50%;
                img{
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    fill: $white;
                }
            }
        }
    }
}
</style>