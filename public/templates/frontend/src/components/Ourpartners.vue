<template>
    <div class="content">
        <Loader v-if="loading" />
        <div class="ourpartners" v-if="partners.length > 0">
            <h2>Our partners</h2>
            <p>Meet Our Amazing parteners</p>
            <div class="ourpartners">
                <div class="partner" v-for="partner in partners" :key="partner.id">
                    <img :src="$file(partner.image)" alt="partner" draggable="false">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Ourpartners',
    data() {
        return {
            loading: false,
            partners: []
        }
    },
    mounted() {
        this.$getAllPartners()
    }
}
</script>

<style lang="scss" scoped>
@import '../scss/index.scss';
.ourpartners{
    margin: 40px 0;
    h2{
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: $lightred;
        text-transform: uppercase;
        text-align: center;
    }
    p{
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 40px;
        text-align: center;
    }
    .ourpartners{
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        grid-gap: 20px;
        width: 100%;
        place-items: center;
        @media(max-width: 1055px){
            grid-template-columns: repeat(6, 1fr);
        }
        @media(max-width: 950px){
            grid-template-columns: repeat(5, 1fr);
        }
        @media(max-width: 850px){
            grid-template-columns: repeat(4, 1fr);
        }
        @media(max-width: 650px){
            grid-template-columns: repeat(3, 1fr);
        }
        @media(max-width: 450px){
            grid-template-columns: repeat(2, 1fr);
        }
        @media(max-width: 350px){
            grid-template-columns: repeat(1, 1fr);
        }
        .partner{
            width: 100px;
            height: 80px;
            position: relative;
            img{
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                width: 100%;
                object-fit: contain;
            }
        }
    }
}
</style>