<template>
  <div class="content">
      <Loader v-if="loading" />
      <div class="departments" v-if="departments.length > 0">
        <h2>Read our Departments</h2>
        <p>We Provide Special Service For Patients</p>
        <div class="department-container">
          <router-link :to="`/departments/${department.id}/${department.name}`" class="department-container-item" v-for="department in departments" :key="department.id">
            <div class="cover"><img :src="$file(department.image)" alt="blog1" draggable="false"  /></div>
            <div class="item-content">
              <h3>{{ department.name }}</h3>
            </div>
          </router-link>
        </div>
      </div>
  </div>
</template>

<script>
export default {
    name: 'Department',
    data() {
        return {
            loading: false,
            departments: []
        }
    },
    mounted() {
      this.$getAllDepartments()
    }
}
</script>

<style lang="scss" scoped>
@import '../scss/index.scss';
.departments{
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
        margin-bottom: 40px;
    }
    .department-container{
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        column-gap: 20px;
        row-gap: 20px;
        @media(max-width: 991px){
            grid-template-columns: 1fr 1fr 1fr;
        }
        @media(max-width: 768px){
            grid-template-columns: 1fr 1fr;
        }
        @media(max-width: 540px){
            grid-template-columns: 1fr;
        }
        .department-container-item{
            width: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 20px -2px rgba(0,0,0,0.1);
            overflow: hidden;
            border-radius: 4px;
            position: relative;
            &:hover{
              .cover{
                img{
                  transform: scale(1.3);
                }
              }
            }
            .cover{
                width: 100%;
                height: 200px;
                overflow: hidden;
                position: relative;
                img{
                    transition: .6s;
                    position: absolute;
                    height: 100%;
                    width: 100%;
                    object-fit: cover;
                }
            }
            .item-content{
              position: absolute;
              display: flex;
              align-items: center;
              justify-content: center;
              text-align: center;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background: #00000049;
              h3{
                color: $white;
              }
            }
        }
    }
}
</style>