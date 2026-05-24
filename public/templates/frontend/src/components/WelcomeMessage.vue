<template>
    <div class="content">
        <div class="about-medic">
            <div class="cover-img">
                <img :src="$file($store.state.webInfo.welcome_cover)" draggable="false" alt="">
            </div>
            <div class="about-medic-description">
                <h3 class="heading">Welcome message</h3>
                <div class="medic-description">{{ $store.state.webInfo.welcome_message }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
        }
    }
}
</script>

<style lang="scss" scoped>
@import '../scss/index.scss';
.about-medic{
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    column-gap: 100px;
    margin: 40px 0;
    @media(max-width: 950px){
        row-gap: 20px;
        grid-template-columns: 1fr;
    }
    .cover-img{
        width: 100%;
        height: 400px;
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        @media(max-width: 700px){
            height: 300px;
        }
        @media(max-width: 485px){
            height: 250px;
        }
        img{
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    }
    .label-subhead{
        font-size: 0.9rem;
        margin: 0 0 10px 0;
        color: $lightred;
    }
    .heading{
        width: 50%;
        font-size: 1.4rem;
        line-height: 2.7rem;
        font-weight: 500;
        margin: 10px 0;
        @media(max-width: 950px){
            width: 100%;
        }
    }
    .medic-description{
        font-size: 0.8rem;
        color: #747474;
        line-height: 1.6rem;
        margin-bottom: 20px;
    }
    .tabs{
        display: flex;
        column-gap: 20px;
        label{
            cursor: pointer;
            transition: .6s;
            font-size: 0.8rem;
            border: 1px solid salmon;
            padding: 5px 20px;
            border-radius: 8px;
            margin: 0 0 20px;
            color: $lightred;
            &.active{
                color: $white;
                background: $lightred;
            }
        }
    }
    .tab-descript{
        transition: .6s;
        font-size: 0.8rem;
        color: #747474;
        line-height: 1.6rem;
        margin-bottom: 20px;
    }
}
</style>