<template>
    <div class="content">
        <div class="about-medic">
            <div class="cover-img">
                <img src="@/assets/images/slide-4.jpg" alt="">
            </div>
            <div class="about-medic-description">
                <div class="label-subhead">ABOUT MEDIC</div>
                <h3 class="heading">We Collaborate for Better Healthcare</h3>
                <div class="medic-description">{{ $store.state.webInfo.about_description }}</div>
                <div class="tabs">
                    <label class="tab" @click="activetab = 'vision'" :class="{ active: activetab == 'vision' }">Our vision</label>
                    <label class="tab" @click="activetab = 'mission'" :class="{ active: activetab == 'mission' }">Our mission</label>
                    <label class="tab" @click="activetab = 'values'" :class="{ active: activetab == 'values' }">Core Values</label>
                </div>
                <div class="tab-descript" v-if="activetab == 'vision'">{{ $store.state.webInfo.vision }}</div>
                <div class="tab-descript" v-if="activetab == 'mission'">{{ $store.state.webInfo.mission }}</div>
                <div class="tab-descript" v-if="activetab == 'values'">
                    <ul>
                        <li v-for="(value,index) in $store.state.webInfo.core_values" :key="index">{{ value }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            activetab: 'vision'
        }
    }
}
</script>

<style lang="scss" scoped>
@import '../scss/index.scss';
.about-medic{
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    column-gap: 50px;
    margin: 40px 0;
    @media(max-width: 950px){
        row-gap: 20px;
        grid-template-columns: 1fr;
    }
    .cover-img{
        width: 100%;
        height: 450px;
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