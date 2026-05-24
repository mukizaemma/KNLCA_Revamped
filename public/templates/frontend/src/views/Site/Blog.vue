<template>
    <div class="blog">
        <div class="container">
            <TopHeader />
            <Navbar />
            <Locator :title="'Updates'" />
            <Blog />
            <Partners />
            <Footer />
        </div>
    </div>
</template>

<script>
export default {
    name: 'Blogs',
    data() {
        return {}
    }
}
</script>

<style lang="scss">
@import '../../scss/index.scss';

</style>