<template>
    <div class="wa-button" v-if="$store.state.webInfo.whatsapp">
        <a :href="`https://wa.me/${removeSpacing($store.state.webInfo.whatsapp)}`" target="_blank">
            <img src="../assets/images/whatsapp-1.png" alt="">
        </a>
    </div>
</template>
<script>
    export default {
        name: 'Whatsapp',
        data() {
            return {

            }
        },
        methods: {
            removeSpacing(str) {
                return str.replace(/\s/g, '')
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import '../scss/index.scss';
    .wa-button{
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 999;
        border-radius: 100%;
        overflow: hidden;
        a{
            display: block;
            width: 65px;
            height: 65px;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            position: relative;
            img{
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }
    }
</style>