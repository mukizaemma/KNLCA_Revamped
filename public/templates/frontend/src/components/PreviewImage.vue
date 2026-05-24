<template>
  <div class="OPreview">
    <div class="previewImage">
      <div v-if="previewUrl">
        <img :src="previewUrl" alt="Preview Image" />
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "OPreview",
  props: {
    image: {
      default: "",
    },
  },
  data() {
    return {
      previewUrl: "",
    };
  },
  methods: {
    previewImage(file) {
      const reader = new FileReader();
      reader.onload = (event) => {
        this.previewUrl = event.target.result;
      };
      reader.readAsDataURL(file);
    },
  },
  mounted() {
    this.previewImage(this.image);
  },
};
</script>
<style lang="scss" scoped>
.OPreview {
  background: #eee;
  border-radius: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
  .previewImage {
    width: 100px;
    height: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }
}
</style>