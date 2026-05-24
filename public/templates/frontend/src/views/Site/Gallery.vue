<template>
    <div class="our-gallery">
        <div class="container">
            <TopHeader />
            <Navbar />
            <Locator :title="'Gallery'" />
            <div class="content">
                <div class="gallery" v-if="gallery.length > 0">
                    <h2>Our gallery</h2>
                    <p>Inspirational Art for Health and Happiness</p>
                    <div class="image-container">
                        <div class="image-container-item" v-for="image in gallery" :key="image.id">
                            <img :src="$file(image.image)" :alt="image.title" draggable="false" />
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
    name: 'Gallery',
    data() {
        return {
            loading: false,
            gallery: []
        }
    },
    mounted() {
        this.$getGallery('site');
    }
}
</script>

<style lang="scss" scoped>
@import '../../scss/index.scss';
.gallery{
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
        margin-bottom: 30px;
    }
    .image-container{
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        column-gap: 20px;
        row-gap: 20px;
        @media(max-width: 970px){
            grid-template-columns: 1fr 1fr;
        }
        @media(max-width: 620px){
            grid-template-columns: 1fr;
        }
        .image-container-item{
            width: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 20px -2px rgba(0,0,0,0.1);
            overflow: hidden;
            border-radius: 4px;
            height: 250px;
            position: relative;
            @media(max-width: 991px){
                height: 200px;
            }
            img{
                width: 100%;
                height: 100%;
                position: absolute;
                transition: .6s;
                object-fit: cover;
                &:hover{
                    transform: scale(1.1);
                }
            }
        }
    }
}
</style>