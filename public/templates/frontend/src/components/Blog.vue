<template>
  <div class="content">
      <Loader v-if="loading" />
      <div class="blog" v-if="articles.length > 0">
        <h2>Read our updates</h2>
        <p>We Provide Special Service For Patients</p>
        <div class="blog-container">
          <div class="blog-container-item" v-for="article in allArticles" :key="article.id">
            <img :src="$file(article.image)" :alt="article.title" draggable="false" />
            <div class="blog-container-item-content">
              <div class="top-wrapper">
                <label class="date">
                    <svg fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M6,22H18a3,3,0,0,0,3-3V7a2,2,0,0,0-2-2H17V3a1,1,0,0,0-2,0V5H9V3A1,1,0,0,0,7,3V5H5A2,2,0,0,0,3,7V19A3,3,0,0,0,6,22ZM5,12.5a.5.5,0,0,1,.5-.5h13a.5.5,0,0,1,.5.5V19a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1Z"></path></g></svg>
                    {{ article.date  }}
                </label>
                <label class="blog-category">HEALTH CARE</label>
              </div>
              <h3>{{ article.title }}</h3>
              <p v-html="article.description"></p>
              <router-link :to="`/blog/${article.slug}`">
                Read More
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M20 12L16 8M20 12L16 16" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
              </router-link>
            </div>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
export default {
    name: 'Blog',
    computed: {
        allArticles() {
            return this.articles.filter(article => article.published_status)
        }
    },
    data() {
        return {
            loading: false,
            articles: []
        }
    },
    mounted() {
      this.$getAllArticles()
    }
}
</script>

<style lang="scss" scoped>
@import '../scss/index.scss';
.blog{
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
    .blog-container{
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
        .blog-container-item{
            width: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 20px -2px rgba(0,0,0,0.1);
            overflow: hidden;
            border-radius: 4px;
            img{
                height: 250px;
                width: 100%;
                object-fit: cover;
                @media(max-width: 991px){
                    height: 200px;
                }
            }
            .blog-container-item-content{
                width: 100%;
                padding: 20px 30px;
                background: #fff;
                display: flex;
                flex-direction: column;
                justify-content: center;
                .top-wrapper{
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    .date{
                        display: flex;
                        align-items: center;
                        font-size: 0.75rem;
                        white-space: nowrap;
                        svg{
                            width: 20px;
                            height: 20px;
                            margin: 0 10px 0 0;
                            fill: $lightred;
                        }
                    }
                    .blog-category{
                        font-size: 0.7rem;
                        padding: 5px 10px;
                        background: $lightred;
                        border-radius: 4px;
                        width: fit-content;
                        color: $white;
                        text-transform: uppercase;
                    }
                }
                h3{
                    font-size: 1.1rem;
                    line-height: 1.7rem;
                    font-weight: 700;
                    margin: 20px 0;
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
                p{
                    font-size: 0.8rem;
                    color: #747474;
                    line-height: 1.6rem;
                    margin-bottom: 20px;
                    display: -webkit-box;
                    -webkit-line-clamp: 3;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    @media(max-width: 991px){
                        -webkit-line-clamp: 2;
                    }
                }
                a{
                    font-size: 0.8rem;
                    color: $lightred;
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    white-space: nowrap;
                    svg{
                        width: 20px;
                        height: 20px;
                        fill: $lightred;
                        margin: 0 0 0 10px;
                        display: block;
                    }
                }
            }
        }
    }
}
</style>