<template>
  <div class="loader">
    <div class="heart-rate">
      <svg version="1.0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="150px" height="73px" viewBox="0 0 150 73" enable-background="new 0 0 150 73" xml:space="preserve">
        <polyline fill="none" stroke="#f46f58" stroke-width="3" stroke-miterlimit="10" points="0,45.486 38.514,45.486 44.595,33.324 50.676,45.486 57.771,45.486 62.838,55.622 71.959,9 80.067,63.729 84.122,45.486 97.297,45.486 103.379,40.419 110.473,45.486 150,45.486"
        />
      </svg>
      <div class="fade-in"></div>
      <div class="fade-out"></div>
    </div>
  </div>
</template>

<script>
export default {
    name: "Loader",
    props: {
        classes: {
            type: String,
            default: ''
        },
        type: {
            type: String,
            default: 'default'
        }
    },
}
</script>

<style lang="css" scoped>
.loader{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 99999999;
}
.heart-rate {
  width: 150px;
  height: 73px;
  position: relative;
  margin: 20px auto;
}
.fade-in {
  position: absolute;
  width: 100%;
  height: 100%;
  background-color: #fff;
  top: 0;
  right: 0;
  animation: heartRateIn 2.5s linear infinite;
}
.fade-out {
  position: absolute;
  width: 120%;
  height: 100%;
  top: 0;
  left: -120%;
  animation: heartRateOut 2.5s linear infinite;
  background: rgb(255, 255, 255);
  background: -moz-linear-gradient(left, rgba(255, 255, 255) 0%, rgb(255, 255, 255) 50%, rgba(255, 255, 255) 100%);
  background: -webkit-linear-gradient(left, rgba(255, 255, 255) 0%, rgba(255, 255, 255) 50%, rgba(255, 255, 255) 100%);
  background: -o-linear-gradient(left, rgba(255, 255, 255) 0%, rgba(255, 255, 255) 50%, rgba(255, 255, 255) 100%);
  background: -ms-linear-gradient(left, rgba(255, 255, 255) 0%, rgba(255, 255, 255) 50%, rgba(255, 255, 255) 100%);
  background: linear-gradient(to right, rgba(255, 255, 255) 0%, rgba(255, 255, 255) 80%, rgba(255, 255, 255) 100%);
}
@keyframes heartRateIn {
  0% {
    width: 100%;
  }
  50% {
    width: 0;
  }
  100% {
    width: 0;
  }
}
 
@keyframes heartRateOut {
  0% {
    left: -120%;
  }
  30% {
    left: -120%;
  }
  100% {
    left: 0;
  }
}
</style>