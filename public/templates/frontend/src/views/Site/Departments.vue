<template>
    <div class="home">
        <div class="container">
            <TopHeader />
            <Navbar />
            <Locator :title="'our Departments'" />
            <Department />
            <Partners />
            <Footer />
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            
        }
    }
}
</script>

<style lang="scss">
@import '../../scss/index.scss'

</style>