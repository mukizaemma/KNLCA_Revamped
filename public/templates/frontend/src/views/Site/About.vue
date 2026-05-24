<template>
    <div class="about-us">
        <div class="container">
            <TopHeader />
            <Navbar />
            <Locator :title="'About us'" />
            <div class="content">
                <div class="about">
                    <Aboutus />
                    <div class="about-values">
                        <h2 class="heading">ABOUT MEDIC</h2>
                        <p class="sub-heading">The Hospital That Has a Sincere Heart</p>
                        <div class="our-values">
                            <div class="value">
                                <div class="top-wrapper">
                                    <div class="icon">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 16C9.85038 16.6303 10.8846 17 12 17C13.1154 17 14.1496 16.6303 15 16" stroke-width="1.5" stroke-linecap="round"></path> <path d="M21.6359 12.9579L21.3572 14.8952C20.8697 18.2827 20.626 19.9764 19.451 20.9882C18.2759 22 16.5526 22 13.1061 22H10.8939C7.44737 22 5.72409 22 4.54903 20.9882C3.37396 19.9764 3.13025 18.2827 2.64284 14.8952L2.36407 12.9579C1.98463 10.3208 1.79491 9.00229 2.33537 7.87495C2.87583 6.7476 4.02619 6.06234 6.32691 4.69181L7.71175 3.86687C9.80104 2.62229 10.8457 2 12 2C13.1543 2 14.199 2.62229 16.2882 3.86687L17.6731 4.69181C19.9738 6.06234 21.1242 6.7476 21.6646 7.87495" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
                                    </div>
                                    <label class="value-name">Honesty</label>
                                </div>
                                <p class="value-description">Committed to transparent care, our hospital values honesty in every medical interaction for patient well-being.</p>
                            </div>
                            <div class="value">
                                <div class="top-wrapper">
                                    <div class="icon">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12.2424 20H17.5758M4.48485 16.5L15.8242 5.25607C16.5395 4.54674 17.6798 4.5061 18.4438 5.16268V5.16268C19.2877 5.8879 19.3462 7.17421 18.5716 7.97301L7.39394 19.5L4 20L4.48485 16.5Z" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                    </div>
                                    <label class="value-name">Learning</label>
                                </div>
                                <p class="value-description">Fostering a culture of continuous education, we strive for medical excellence through ongoing learning initiatives.</p>
                            </div>
                            <div class="value">
                                <div class="top-wrapper">
                                    <div class="icon">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 22V14M5 14L7.47067 13.5059C9.1212 13.1758 10.8321 13.3328 12.3949 13.958C14.0885 14.6354 15.9524 14.7619 17.722 14.3195L17.9364 14.2659C18.5615 14.1096 19 13.548 19 12.9037V5.53669C19 4.75613 18.2665 4.18339 17.5092 4.3727C15.878 4.78051 14.1597 4.66389 12.5986 4.03943L12.3949 3.95797C10.8321 3.33284 9.1212 3.17576 7.47067 3.50587L5 4M5 14V11M5 4V2M5 4V7" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
                                    </div>
                                    <label class="value-name">Trust</label>
                                </div>
                                <p class="value-description">Patients entrust their health to us; we reciprocate with unwavering commitment, building lasting trust in healthcare.</p>
                            </div>
                            <div class="value">
                                <div class="top-wrapper">
                                    <div class="icon">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9.5 12.4L10.9286 14L14.5 10" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 10.4167C3 7.21907 3 5.62028 3.37752 5.08241C3.75503 4.54454 5.25832 4.02996 8.26491 3.00079L8.83772 2.80472C10.405 2.26824 11.1886 2 12 2C12.8114 2 13.595 2.26824 15.1623 2.80472L15.7351 3.00079C18.7417 4.02996 20.245 4.54454 20.6225 5.08241C21 5.62028 21 7.21907 21 10.4167C21 10.8996 21 11.4234 21 11.9914C21 14.4963 20.1632 16.4284 19 17.9041M3.19284 14C4.05026 18.2984 7.57641 20.5129 9.89856 21.5273C10.62 21.8424 10.9807 22 12 22C13.0193 22 13.38 21.8424 14.1014 21.5273C14.6796 21.2747 15.3324 20.9478 16 20.5328" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
                                    </div>
                                    <label class="value-name">Passion</label>
                                </div>
                                <p class="value-description">Our dedicated medical professionals channel passion into every healing moment, ensuring compassionate and personalized patient care.</p>
                            </div>
                            <div class="value">
                                <div class="top-wrapper">
                                    <div class="icon">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 4.45962C9.91153 4.16968 10.9104 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C3.75612 8.07914 4.32973 7.43025 5 6.82137" stroke-width="1.5" stroke-linecap="round"></path> <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke-width="1.5"></path> </g></svg>
                                    </div>
                                    <label class="value-name">Vision</label>
                                </div>
                                <p class="value-description">Infusing dedication into healing, our team passionately delivers patient-centric care, fostering well-being and recovery.</p>
                            </div>
                            <div class="value">
                                <div class="top-wrapper">
                                    <div class="icon">
                                        <svg viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3.98047 3.51001C1.43047 4.39001 0.980469 9.09992 0.980469 12.4099C0.980469 15.7199 1.41047 20.4099 3.98047 21.3199C6.69047 22.2499 14.9805 16.1599 14.9805 12.4099C14.9805 8.65991 6.69047 2.58001 3.98047 3.51001Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M11.9805 21.3199C14.6905 22.2499 22.9805 16.1599 22.9805 12.4099C22.9805 8.65991 14.6705 2.58001 11.9805 3.51001" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                    </div>
                                    <label class="value-name">Future</label>
                                </div>
                                <p class="value-description">Pioneering healthcare innovations, we aspire to lead the future of medicine, shaping a healthier and more resilient world.</p>
                            </div>
                        </div>
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
    name: 'About',
    data() {
        return {
        }
    }
}
</script>

<style lang="scss" scoped>
@import '../../scss/index.scss';
.about-us{
    width: 100%;
    .about{
        margin: 40px 0;
        .about-values{
            margin: 50px 0 30px 0;
            .heading{
                font-size: 1.1rem;
                font-weight: 600;
                margin-bottom: 5px;
                color: $lightred;
                text-transform: uppercase;
            }
            .sub-heading{
                font-size: 0.9rem;
                color: #666;
                margin-bottom: 40px;
            }
            .our-values{
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                column-gap: 20px;
                row-gap: 20px;
                @media(max-width: 860px){
                    grid-template-columns: 1fr 1fr;
                }
                @media(max-width: 570px){
                    grid-template-columns: 1fr;
                }
                .value{
                    padding: 20px 30px;
                    border-radius: 10px;
                    border: 2px solid #2c2c770f;
                    transition: .6s;
                    &:hover{
                        border: 2px solid $lightred;
                        .top-wrapper{
                            .icon{
                                svg{
                                    stroke: $lightred;
                                }
                            }
                            .value-name{
                                color: $lightred;
                            }
                        }
                    }
                    .top-wrapper{
                        display: flex;
                        align-items: center;
                        .icon{
                            position: relative;
                            width: 50px;
                            height: 50px;
                            margin: 0 20px 0 0;
                            svg{
                                position: absolute;
                                width: 100%;
                                height: 100%;
                                stroke: $realblack;
                                transition: .6s;
                            }
                        }
                        .value-name{
                            font-size: 0.9rem;
                            color: $realblack;
                            transition: .6s;
                        }
                    }
                    .value-description{
                        font-size: 0.8rem;
                        color: #666;
                        margin-top: 20px;
                        line-height: 1.7rem;
                    }
                }
            }
        }
    }
}
</style>