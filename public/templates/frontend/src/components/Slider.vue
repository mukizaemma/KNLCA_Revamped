<template>
    <div class="slider" v-if="slides.length > 0">
        <swiper
            :slidesPerView="1"
            :spaceBetween="0"
            :effect="'fade'"
            :loop="true"
            :pagination="{
                clickable: true,
            }"
            :autoplay="{
                delay: 5000,
                disableOnInteraction: false,
            }"
            :navigation="true"
            :modules="modules"
            class="mySwiper"
        >
            <swiper-slide v-for="slide in allSlides" :key="slide.id">
                <img :src="$file(slide.image)" alt="">
                    <div class="slide__content">
                        <h1 class="slide__title">{{ slide.title }}</h1>
                        <p class="slide__text">{{ slide.caption }}</p>
                    </div>
            </swiper-slide>
        </swiper>
    </div>
</template>
<script>
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue';

// Import Swiper styles
import 'swiper/css';

import 'swiper/css/effect-fade';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

// import required modules
import { Autoplay, EffectFade, Pagination, Navigation } from 'swiper/modules';

export default {
    components: { Swiper, SwiperSlide},
    data() {
        return {
            modules: [Autoplay, EffectFade, Pagination, Navigation],
            slidess: [
                {
                    id: 1,
                    title: 'Welcome to Our Hospital',
                    text: 'Discover the compassionate care and advanced medical services we offer at our state-of-the-art hospital.',
                    image: require('../assets/images/slide-1.jpg'),
                },
                {
                    id: 2,
                    title: 'Expert Medical Staff',
                    text: 'Our dedicated team of experienced doctors and nurses is here to provide you with the best healthcare.',
                    image: require('../assets/images/slide-2.jpg'),
                },
                {
                    id: 3,
                    title: 'Cutting-Edge Technology',
                    text: 'We invest in the latest medical technology to ensure accurate diagnoses and effective treatments.',
                    image: require('../assets/images/slide-3.jpg'),
                },
                {
                    id: 4,
                    title: 'Patient-Centered Care',
                    text: 'Your well-being is our top priority. We focus on personalized care to meet your unique needs.',
                    image: require('../assets/images/slide-4.jpg'),
                },
                {
                    id: 5,
                    title: 'Emergency Services',
                    text: 'Our 24/7 emergency department is always ready to provide rapid and effective care when you need it most.',
                    image: require('../assets/images/slide-5.jpg'),
                },
                {
                    id: 6,
                    title: 'Community Involvement',
                    text: 'We\'re proud to support and engage with our local community through health and wellness initiatives.',
                    image: require('../assets/images/slide-6.jpg'),
                },
                {
                    id: 7,
                    title: 'Quality Healthcare',
                    text: 'Our commitment to excellence ensures that you receive the highest quality healthcare services available.',
                    image: require('../assets/images/slide-7.jpg'),
                },
            ],
            slides: []
        };
    },
    computed: {
        allSlides(){
            return this.slides.filter(slide => slide.active_status)
        }
    },
    mounted() {
        this.$getAllSlides();
    },
};
</script>  
<style lang="scss" scoped>
@import '../scss/index.scss';
.slider{
    width: 100%;
    .swiper{
        width: 100%;
        height: 600px;
        @media(max-width: 500px){
            height: 400px;
        }
        .swiper-slide{
            img{
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            &::after{
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.4);
            }
            .slide__content{
                position: absolute;
                z-index: 1;
                transition: .6s;
                opacity: 0;
                top: 65%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 90%;
                max-width: 600px;
                padding: 20px;
                text-align: center;
                color: $white;
                .slide__title{
                    font-size: 2rem;
                    font-weight: 700;
                    margin-bottom: 20px;
                    color: $white;
                    @media(max-width: 630px){
                        font-size: 1.4rem;
                    }
                }
                .slide__text{
                    font-size: 1rem;
                    font-weight: 400;
                    margin-bottom: 20px;
                    @media(max-width: 630px){
                        font-size: 0.9rem;
                    }
                }
                .slide__button{
                    padding: 10px 20px;
                    border: 1px solid $white;
                    background: transparent;
                    color: $white;
                    font-size: 1rem;
                    font-weight: 400;
                    transition: .5s;
                    &:hover{
                        background: $white;
                        color: $black;
                    }
                }
            }
            &.swiper-slide-active{
                .slide__content{
                    opacity: 1;
                    top: 50%;
                }
            }
        }
    }
}
</style>