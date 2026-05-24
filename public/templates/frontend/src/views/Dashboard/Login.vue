<template>
    <div class="login">
        <form class="form" @submit.prevent="signin()">
        <div class="top">
            <div class="logo">
                <img src="@/assets/logo.png" alt="dmc-logo" draggable="false">
            </div>
        </div>
        <div class="inputs">
            <label>Email</label>
            <input type="email" v-model="form.email" placeholder="Enter your email" required>
            <label>Password</label>
            <input type="password" v-model="form.password" placeholder="Enter your password">
            <button>Log in</button>
        </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "Admin",
    data(){
        return{
            form: {
                email: '',
                password: ''
            }
        }
    },
    methods:{
        signin(){
            this.$store.dispatch('USER_LOGIN', this.form)
                .then((res) =>{
                    if(res.data.status == 'failed'){
                        this.$notify({
                            type: 'error',
                            text: res.data.message
                        })
                    } else{
                        if(res.data.data.role.role == 'patient'){
                            this.$notify({
                                type: 'error',
                                text: 'You are not authorized to access this page'
                            })
                            return;
                        }
                        this.$notify({
                            type: 'success',
                            text: res.data.message
                        })
                        localStorage.setItem('user_token', res.data.token)
                        localStorage.setItem('logged_user', JSON.stringify(res.data.data))
                        this.$router.push('/dashboard/overview')
                        this.form = { email: '', password: '' }
                        location.reload();
                    }
                })
        },
        checkAuth() {
            if (this.$loggedUser() && this.$loggedUser().role.role != 'patient') {
                this.$router.push("/dashboard/overview");
            }
        }
    },
    mounted(){
        this.checkAuth();
    }
}
</script>

<style lang="scss" scoped>
@import '../../scss/index.scss';
.login{
    width: 100%;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    .form{
        width: 500px;
        background: $white;
        border-radius: 10px;
        padding: 15px 0;
        .top{
            padding: 5px 20px;
            position: relative;
            display: flex;
            flex-direction: column;
            row-gap: 7px;
            text-align: center;
            align-items: center;
            justify-content: center;
            .logo{
                width: 170px;
                height: 40px;
                position: relative;
                img{
                    position: absolute;
                    left: 0;
                    object-fit: contain;
                    width: 100%;
                    height: 100%;
                }
            }
            h3{
                text-align: center;
                font-size: 1rem;
                font-weight: 600;
                color: $realblack;
            }
        }
        .inputs{
            padding: 20px 30px;
            width: 100%;
            transition: .8s;
            .flex{
                display: grid;
                grid-template-columns: 1fr 1fr;
                column-gap: 10px;
            }
            label{
                display: block;
                font-size: 0.85rem;
                color: $realblack;
            }
            input{
                outline: none;
                resize: none;
                display: block;
                margin: 10px 0;
                padding: 9px 10px;
                width: 100%;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 0.8rem;
            }
            button{
                outline: none;
                margin: 20px 0 15px 0;
                display: flex;
                align-items: center;
                padding: 10px 20px;
                cursor: pointer;
                border-radius: 4px;
                font-size: 0.8rem;
                column-gap: 15px;
                background: $lightred;
                position: relative;
                overflow: hidden;
                border: none; 
                width: 100%;
                justify-content: center;
                color: #fff;
                white-space: nowrap;
                svg{
                    fill: #fff;
                    width: 20px;
                    height: 20px;
                    transform: scaleY(-1) rotate(-90deg);
                    &.enquiry{
                        transform: none;
                    }
                }
            }
        }
    }
}
</style>