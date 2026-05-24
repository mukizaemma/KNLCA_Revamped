<template>
    <div class="article">
        <div class="container">
            <TopHeader />
            <Navbar />
            <Locator :title="'Article'" />
            <div class="content">
                <div class="article-wrapper">
                    <div class="main-article" v-if="article">
                        <div class="article-container">
                            <div class="cover"><img :src="$file(article.image)" alt="article-cover" draggable="false" /></div>
                            <div class="article-content">
                                <div class="top-wrapper">
                                    <label class="date">
                                        <svg fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M6,22H18a3,3,0,0,0,3-3V7a2,2,0,0,0-2-2H17V3a1,1,0,0,0-2,0V5H9V3A1,1,0,0,0,7,3V5H5A2,2,0,0,0,3,7V19A3,3,0,0,0,6,22ZM5,12.5a.5.5,0,0,1,.5-.5h13a.5.5,0,0,1,.5.5V19a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1Z"></path></g></svg>
                                        {{ article.date }}
                                    </label>
                                    <label class="article-category">HEALTH CARE</label>
                                </div>
                                <h3>{{ article.title }}</h3>
                                <p v-html="article.description"></p>
                            </div>
                            <div class="comments-container" v-if="comments">
                                <div class="all-comments"></div>
                                <div class="no-comments">Be the first to comment!</div>
                                <form class="form">
                                    <textarea rows="10" placeholder="Write something...." required></textarea>
                                    <button>Add comment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="other">
                        <label class="sub-heading">Other Recent Articles</label>
                        <div class="other-articles" v-if="other.length > 0">
                            <div class="blog-container-item" v-for="update in other.slice(0,2)" :key="update.id">
                                <img :src="$file(update.image)" draggable="false" />
                                <div class="blog-container-item-content">
                                    <div class="top-wrapper">
                                        <label class="date">
                                            <svg fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M6,22H18a3,3,0,0,0,3-3V7a2,2,0,0,0-2-2H17V3a1,1,0,0,0-2,0V5H9V3A1,1,0,0,0,7,3V5H5A2,2,0,0,0,3,7V19A3,3,0,0,0,6,22ZM5,12.5a.5.5,0,0,1,.5-.5h13a.5.5,0,0,1,.5.5V19a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1Z"></path></g></svg>
                                            {{ update.date }}
                                        </label>
                                        <label class="blog-category">HEALTH CARE</label>
                                    </div>
                                <h3>{{ update.title }}</h3>
                                <p v-html="article.description"></p>
                                <router-link :to="`/blog/${update.slug}`">
                                    Read More
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M20 12L16 8M20 12L16 16" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </router-link>
                                </div>
                            </div>
                        </div>
                        <label class="no-data" v-else>No other recent articles</label>
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
    name: 'Article',
    data() {
        return {
            article: null,
            comments: false,
            other: []
        }
    },
    methods: {
        getArticle() {
            this.$store.dispatch('GET_AN_UPDATE', this.$route.params.slug)
                .then(res => {
                    this.article = res.data
                })
                .catch(err => {
                    console.log(err)
                })
            this.otherArticles()
        },
        otherArticles() {
            this.$store.dispatch('GET_ALL_UPDATES')
                .then(res => {
                    this.other = res.data.filter(article => article.slug != this.$route.params.slug && article.published_status)
                })
        }
    },
    watch: {
        '$route.params.slug': function () {
            this.getArticle()
            window.scrollTo(0, 0)
        }
    },
    mounted() {
        this.getArticle()
    }
}
</script>

<style lang="scss">
@import '../../scss/index.scss';
.article{
    width: 100%;
    .article-wrapper{
        display: grid;
        grid-template-columns: 1fr 0.4fr;
        column-gap: 50px;
        margin: 50px 0 20px;
        .main-article{
            width: 100%;
            .article-container{
                .cover{
                    width: 100%;
                    height: 450px;
                    position: relative;
                    overflow: hidden;
                    border-radius: 8px;
                    img{
                        position: absolute;
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }
                }
                .article-content{
                    width: 100%;
                    padding: 20px 0;
                    background: #fff;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    margin: 0 0 50px;
                    border-bottom: 1px solid #ccc;
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
                        .article-category{
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
                    }
                    p{
                        font-size: 0.8rem;
                        color: #747474;
                        line-height: 1.6rem;
                        margin-bottom: 20px;
                    }
                }
                .comments-container{
                    .all-comments{

                    }
                    .no-comments{
                        margin: 10px 0 20px;
                        font-size: 0.8rem;
                        color: #666;
                    }
                    .form{
                        max-width: 500px;
                        textarea{
                            font-size: 0.8rem;
                            width: 100%;
                            padding: 15px;
                            border: 1px solid #ccc;
                            border-radius: 4px;
                            margin: 7px 0;
                            resize: none;
                            color: #666;
                            &:focus{
                                outline: none;
                                border: 1px solid $lightred;
                            }
                        }
                        button{
                            width: 100%;
                            font-size: 0.8rem;
                            padding: 7px 0;
                            border: none;
                            background: $lightred;
                            color: #fff;
                            border-radius: 4px;
                            cursor: pointer;
                        }
                    }
                }
            }
        }
        .other{
            .sub-heading{
                font-size: 0.9rem;
                margin: 0 0 15px 0;
                color: $lightred;
                text-transform: uppercase;
            }
            .other-articles{
                margin: 20px 0 0 0;
                display: flex;
                flex-direction: column;
                row-gap: 50px;
                .blog-container-item{
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                    box-shadow: 0 0 20px -2px rgba(0,0,0,0.1);
                    overflow: hidden;
                    border-radius: 4px;
                    img{
                        height: 200px;
                        width: 100%;
                        object-fit: cover;
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
                            font-size: 0.9rem;
                            line-height: 1.7rem;
                            font-weight: 700;
                            margin: 10px 0;
                            display: -webkit-box;
                            -webkit-line-clamp: 1;
                            -webkit-box-orient: vertical;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }
                        p{
                            font-size: 0.7rem;
                            color: #747474;
                            line-height: 1.6rem;
                            margin-bottom: 10px;
                            display: -webkit-box;
                            -webkit-line-clamp: 2;
                            -webkit-box-orient: vertical;
                            overflow: hidden;
                            text-overflow: ellipsis;
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
            .no-data{
                display: block;
                font-size: 0.8rem;
                color: #666;
                margin: 20px 0 0;
            }
        }
    }
}
</style>