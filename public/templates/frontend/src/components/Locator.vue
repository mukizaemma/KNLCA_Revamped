<template>
  <div class="locator">
    <img :src="img" alt="">
    <h1>{{ title }}</h1>
  </div>
</template>

<script>
export default {
    name: 'Locator',
    props: {
        img: {
            type: String,
            default: require('../assets/images/default-locator.jpg')
        },
        title: {
            type: String,
            default: 'Locator'
        }
    },
    data() {
        return {}
    }
}
</script>

<style lang="scss" scoped>
@import '../scss/index.scss';
.locator{
    width: 100%;
    height: 170px;
    position: relative;
    &::after{
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }
    img{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    h1{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        font-weight: 400;
        text-transform: uppercase;
        color: $white;
        font-size: 1.3rem;
        z-index: 1;
        @media(max-width: 768px){
            text-align: center;
            width: 100%;
        }
    }
}
</style>