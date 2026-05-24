<template>
    <div class="home">
        <div class="container">
            <TopHeader />
            <Navbar />
            <Slider />
            <WelcomeMessage />
            <Department />
            <Team />
            <div class="emergency">
                <div class="left">
                    <label class="sub-heading">Emergency Helpline</label>
                    <h2>Need Emergency Contact</h2>
                    <p>For urgent healthcare needs, our Emergency Contact Information is readily available. Whether facing a medical crisis or seeking immediate advice, the contacts below connect you to our dedicated professionals swiftly. Your well-being is our priority, and these emergency channels ensure prompt assistance in critical situations. Reach out for immediate support and peace of mind.</p>
                    <div class="offers">
                        <label class="offer">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81V16.18C2 19.83 4.17 22 7.81 22H16.18C19.82 22 21.99 19.83 21.99 16.19V7.81C22 4.17 19.83 2 16.19 2ZM16.78 9.7L11.11 15.37C10.97 15.51 10.78 15.59 10.58 15.59C10.38 15.59 10.19 15.51 10.05 15.37L7.22 12.54C6.93 12.25 6.93 11.77 7.22 11.48C7.51 11.19 7.99 11.19 8.28 11.48L10.58 13.78L15.72 8.64C16.01 8.35 16.49 8.35 16.78 8.64C17.07 8.93 17.07 9.4 16.78 9.7Z"></path> </g></svg>
                            24/7 Contact Our Hospital.
                        </label>
                        <label class="offer">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81V16.18C2 19.83 4.17 22 7.81 22H16.18C19.82 22 21.99 19.83 21.99 16.19V7.81C22 4.17 19.83 2 16.19 2ZM16.78 9.7L11.11 15.37C10.97 15.51 10.78 15.59 10.58 15.59C10.38 15.59 10.19 15.51 10.05 15.37L7.22 12.54C6.93 12.25 6.93 11.77 7.22 11.48C7.51 11.19 7.99 11.19 8.28 11.48L10.58 13.78L15.72 8.64C16.01 8.35 16.49 8.35 16.78 8.64C17.07 8.93 17.07 9.4 16.78 9.7Z"></path> </g></svg>
                            24 Hours Open Our Hospital.
                        </label>
                        <label class="offer">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81V16.18C2 19.83 4.17 22 7.81 22H16.18C19.82 22 21.99 19.83 21.99 16.19V7.81C22 4.17 19.83 2 16.19 2ZM16.78 9.7L11.11 15.37C10.97 15.51 10.78 15.59 10.58 15.59C10.38 15.59 10.19 15.51 10.05 15.37L7.22 12.54C6.93 12.25 6.93 11.77 7.22 11.48C7.51 11.19 7.99 11.19 8.28 11.48L10.58 13.78L15.72 8.64C16.01 8.35 16.49 8.35 16.78 8.64C17.07 8.93 17.07 9.4 16.78 9.7Z"></path> </g></svg>
                            Emergency Contact Our Phone Number.
                        </label>
                    </div>
                    <div class="helplines">
                        <div class="helpline">
                            <h3>Phone Number</h3>
                            <p class="value">{{ $store.state.webInfo.contacts }}</p>
                        </div>
                        <div class="helpline">
                            <h3>Email</h3>
                            <p class="value">{{ $store.state.webInfo.email }}</p>
                        </div>
                        <div class="helpline">
                            <button class="highlighted" @click="$router.push('/appointment')">
                                <svg fill="#000000" viewBox="-2.5 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M11.56 10.11v2.046a3.827 3.827 0 1 1-7.655 0v-.45A3.61 3.61 0 0 1 .851 8.141V5.25a1.682 1.682 0 0 1 .763-1.408 1.207 1.207 0 1 1 .48 1.04.571.571 0 0 0-.135.368v2.89a2.5 2.5 0 0 0 5 0V5.25a.57.57 0 0 0-.108-.334 1.208 1.208 0 1 1 .533-1.018 1.681 1.681 0 0 1 .683 1.352v2.89a3.61 3.61 0 0 1-3.054 3.565v.45a2.719 2.719 0 0 0 5.438 0V10.11a2.144 2.144 0 1 1 1.108 0zm.48-2.07a1.035 1.035 0 1 0-1.035 1.035 1.037 1.037 0 0 0 1.036-1.035z"></path></g></svg>
                                Appointment
                            </button>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <img src="@/assets/images/cover-2.jpg" alt="emergency" draggable="false">
                </div>
            </div>
            <Blog />
            <Partners />
            <Footer />
            <Whatsapp />
        </div>
    </div>
</template>

<script>
import Slider from '@/components/Slider.vue'
export default {
    name: 'Home',
    components: { Slider },
    data() {
        return {}
    }
}
</script>

<style lang="scss">
@import '../../scss/index.scss';
.emergency{
    padding: 20px 50px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    column-gap: 40px;
    .left{
        width: 60%;
        @media(max-width: 750px){
            width: 100%;
        }
        .sub-heading{
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
            display: block;
            color: $lightred;
            text-transform: uppercase;
        }
        h2{
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        p{
            font-size: 0.8rem;
            line-height: 1.5rem;
            color: #666;
            margin-bottom: 20px;
        }
        .offers{
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            font-size: 0.8rem;
            .offer{
                display: flex;
                align-items: center;
                margin-bottom: 10px;
                svg{
                    width: 20px;
                    height: 20px;
                    margin-right: 10px;
                    fill: $lightred;
                }
            }
        }
        .helplines{
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            column-gap: 20px;
            align-items: center;
            width: 100%;
            @media(max-width: 1070px){
                grid-template-columns: 1fr 1fr;
            }
            @media(max-width: 750px){
                grid-template-columns: 1fr 1fr 1fr;
            }
            @media(max-width: 665px){
                grid-template-columns: 1fr 1fr;
            }
            @media(max-width: 430px){
                grid-template-columns: 1fr;
            }
            .helpline{
                border-radius: 8px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                h3{
                    font-size: 0.9rem;
                    font-weight: 600;
                    text-transform: uppercase;
                }
                .value{
                    font-size: 0.8rem;
                    color: #666;
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
                    width: fit-content;
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
        }
    }
    .right{
        width: 40%;
        @media(max-width: 750px){
            display: none;
        }
        img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }
    }
}
</style>