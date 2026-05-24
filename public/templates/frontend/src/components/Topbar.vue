<template>
  <div class="topbar" v-if="$loggedUser()">
    <div class="profile">
        <div class="profileImage">
            <img :src="$file($loggedUser().image)" alt="profile image">
        </div>
        <div class="profileName">
            <h3>{{ $loggedUser().lastname }}</h3>
        </div>
        <div class="options">
            <button class="btn" @click="logout()">Logout</button>
        </div>
    </div>
  </div>
</template>

<script>
export default {
    name: "Topbar",
    data() {
        return {
            loading: false,
        };
    },
    methods: {
        logout(){
            this.$store.dispatch('USER_LOGOUT')
                .then(res => {
                    localStorage.removeItem('logged_user')
                    localStorage.removeItem('user_token')
                    this.$router.push('/login')
                    this.$notify({
                        type: 'success',
                        text: res.data.message,
                    });
                })
                .catch(err => {
                    console.log(err)
                })
        }
    },
    mounted() {
      window.scrollTo(0, 0)  
    },
}
</script>

<style lang="scss" scoped>
.topbar{
    width: 100%;
    padding: 15px 50px;
    display: flex;
    justify-content: flex-end;
    background-color: #fff;
    box-shadow: 0 10px 30px -20px rgba(0,0,0,0.1);
    position: sticky;
    z-index: 9;
    top: 0;
    left: 0;
    .profile{
        display: flex;
        align-items: center;
        position: relative;
        .notifications{
            position: relative;
            cursor: pointer;
            margin: 7px 30px 0 0;
            svg{
                width: 25px;
                height: 25px;
                fill: #333;
            }
            .counts{
                position: absolute;
                top: -5px;
                right: -5px;
                width: 20px;
                height: 20px;
                border-radius: 50%;
                background-color: #f4961c;
                color: #fff;
                font-size: 0.7rem;
                font-weight: 500;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        }
        .profileImage{
            width: 30px;
            height: 30px;
            border-radius: 50%;
            overflow: hidden;
            img{
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }
        .profileName{
            margin-left: 10px;
            h3{
                font-size: 0.8rem;
                font-weight: 500;
                color: #333;
            }
        }
        .options{
            margin-left: 20px;
            button{
                padding: 5px 10px;
                cursor: pointer;
                border: none;
                border-radius: 5px;
                background-color: #f1f1f1;
                font-size: 0.8rem;
                font-weight: 500;
                color: #333;
                cursor: pointer;
                &:hover{
                    background-color: #e1e1e1;
                }
            }
        }
    }
}
</style>