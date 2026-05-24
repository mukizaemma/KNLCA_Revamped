<template>
  <div class="Uploader">
    <div class="img-uploader">
      <!-- image preview -->
      <div class="preview">
        <div class="img-item" v-for="image in images" :key="image">
          <!-- <previewImage :image="image" class="prev" /> -->
          <img :src="$store.state.apiUploadUrl + image" alt="Preview Image" />
          <span class="delete" @click="removeImage(image)">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 6.98996C8.81444 4.87965 15.1856 4.87965 21 6.98996" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M8.00977 5.71997C8.00977 4.6591 8.43119 3.64175 9.18134 2.8916C9.93148 2.14146 10.9489 1.71997 12.0098 1.71997C13.0706 1.71997 14.0881 2.14146 14.8382 2.8916C15.5883 3.64175 16.0098 4.6591 16.0098 5.71997" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12 13V18" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M19 9.98999L18.33 17.99C18.2225 19.071 17.7225 20.0751 16.9246 20.8123C16.1266 21.5494 15.0861 21.9684 14 21.99H10C8.91389 21.9684 7.87336 21.5494 7.07541 20.8123C6.27745 20.0751 5.77745 19.071 5.67001 17.99L5 9.98999" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
          </span>
          <span class="uploaded" v-if="image.uploadStatus == 'uploaded'"
            >Uploaded</span
          >
          <span class="failed" v-if="image.uploadStatus == 'failed'"
            >Failed</span
          >
        </div>
        <div class="dropzone">
          <span v-if="multiple || images.length < 1">+</span>
          <span class="change" v-else>Change</span>
          <input
            type="file"
            @change="upload"
            :multiple="false"
            accept="image/*"
            ref="file"
          />
        </div>
      </div>
      <!-- single image uploader dropzone -->
    </div>
    <!-- upload btn -->
    <!-- <div class="upload-btn">
      <button @click="uploadImages()">Upload</button>
    </div> -->
  </div>
</template>
<script>
import previewImage from "./PreviewImage.vue";
export default {
  name: "OUpload",
  components: {
    previewImage,
  },
  props: {
    multiple: {
      type: Boolean,
      default: false,
    },
    uploadUrl: {
      type: String,
      default: "upload",
    },
    imagesBaseUrl: {
      type: String,
      default: "http://localhost:8080/",
    },
    value: {
      type: [String, Array],
      default: "",
    },
  },
  data() {
    return {
      images: [],
      imagesToUpload: [],
      previewUrl: "",
    };
  },
  methods: {
    upload() {
      if (this.$refs.file.files.length == 0) return;
      this.imagesToUpload.push(this.$refs.file.files[0]);
      this.uploadImages(this.$refs.file.files[0]);
    },
    removeImage(image) {
      this.images = this.images.filter((img) => img != image);
      if (this.multiple) {
        this.$emit("imagesUploaded", this.images);
      } else {
        this.$emit("imagesUploaded", this.images[0]);
      }
    },
    async uploadImages($image) {
      const res = await this.$store
        .dispatch("UPLOAD_FILE", {
          file: $image,
          url: this.uploadUrl,
        })
        .then((res) => {
          // console.log(res);
          if (res.data.status == "success") {
            if (this.multiple) {
              this.images.push(res.data.file_name);
            } else {
              this.images = [res.data.file_name];
            }
            // emit image uploaded event
            if (this.multiple) {
              this.$emit("imagesUploaded", this.images);
            } else {
              this.$emit("imagesUploaded", this.images[0]);
            }
          } else {
            this.imagesToUpload.forEach((img) => {
              if (img.name == $image.name) {
                img.uploadStatus = "failed";
              this.$emit("imagesUploadedFailed", $image);
              }
            });
          }
        });
    },
  },
  mounted() {
    if (this.value) {
      if (this.multiple) {
        this.images = this.value;
      } else {
        this.images = [this.value];
      }
    }
  },
};
</script>
<style lang="scss" scoped>
.Uploader {
  margin: 10px 0 10px;
  .img-uploader {
    display: flex;
    flex-wrap: wrap;
  }
  .preview {
    display: flex;
    flex-wrap: wrap;
    row-gap: 10px;
    column-gap: 10px;
    .img-item {
      width: 100px;
      height: 100px;
      position: relative;
      .delete {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #c40505;
        color: #fff;
        padding: 5px;
        border-radius: 50%;
        font-size: 10px;
        width: 25px;
        height: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        &:hover {
          background: #780202;
        }
      }
      .uploaded {
        position: absolute;
        bottom: 0;
        left: 0;
        background: #4f934c;
        color: #fff;
        padding: 3px 5px;
        border-radius: 0 0 5px 5px;
        font-size: 10px;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .failed {
        position: absolute;
        bottom: 0;
        left: 0;
        background: #c40505;
        color: #fff;
        padding: 3px 5px;
        border-radius: 0 0 5px 5px;
        font-size: 10px;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .prev {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
      img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
    }
  }
  .dropzone {
    width: 100px;
    height: 100px;
    border: 1px dashed #ccc;
    position: relative;
    cursor: pointer;
    &:hover {
      border: 1px dashed #000;
    }
    input {
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
    }
    span {
      font-size: 2rem;
      color: #ccc;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      cursor: pointer;
      &.change {
        font-size: 1rem;
      }
    }
  }
  .upload-btn {
    button {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      background: #000;
      color: #fff;
      margin-top: 10px;
      cursor: pointer;
      &:hover {
        background: #333;
      }
    }
  }
}
</style>