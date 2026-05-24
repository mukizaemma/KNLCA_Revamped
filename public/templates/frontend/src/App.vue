<template>
  <Modal v-if="$store.state.authmodal">
    <form class="form" @submit.prevent="submitform()">
      <div class="close" @click="close()">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22ZM8.96965 8.96967C9.26254 8.67678 9.73742 8.67678 10.0303 8.96967L12 10.9394L13.9696 8.96969C14.2625 8.6768 14.7374 8.6768 15.0303 8.96969C15.3232 9.26258 15.3232 9.73746 15.0303 10.0303L13.0606 12L15.0303 13.9697C15.3232 14.2625 15.3232 14.7374 15.0303 15.0303C14.7374 15.3232 14.2625 15.3232 13.9696 15.0303L12 13.0607L10.0303 15.0303C9.73744 15.3232 9.26256 15.3232 8.96967 15.0303C8.67678 14.7374 8.67678 14.2626 8.96967 13.9697L10.9393 12L8.96965 10.0303C8.67676 9.73744 8.67676 9.26256 8.96965 8.96967Z" fill="#f46f58"></path> </g></svg>
      </div>
      <div class="top">
          <div class="logo">
              <img :src="$file($store.state.webInfo.logo)" alt="dmc-logo" draggable="false">
          </div>
      </div>
      <div class="inputs" v-if="formType == 'signin'">
          <label>Email</label>
          <input type="email" v-model="form.email" placeholder="Enter your email" autocomplete="none" required>
          <label>Password</label>
          <input type="password" v-model="form.password" placeholder="Enter your password" required>
          <button>Sign in</button>
          <label class="label">No account yet? <span @click="formType = 'signup'">Sign up</span></label>
      </div>
      <div class="inputs" v-if="formType == 'signup'">
          <label>First name</label>
          <input type="text" v-model="form.firstname" placeholder="Enter your first name" autocomplete="none" required>
          <label>Last name</label>
          <input type="text" v-model="form.lastname" placeholder="Enter your last name" autocomplete="none" required>
          <label>Email</label>
          <input type="email" v-model="form.email" placeholder="Enter your email" autocomplete="none" required>
          <label>Phone</label>
          <input type="text" v-model="form.phone" placeholder="Enter your phone" autocomplete="none" required>
          <label>Password</label>
          <input type="password" v-model="form.password" placeholder="Enter your password" required>
          <button>Sign up</button>
          <label class="label">Already have an account? <span  @click="formType = 'signin'">Sign in</span></label>
      </div>
    </form>
  </Modal>
  <Modal v-if="$store.state.suggestionbox">
    <form class="form" @submit.prevent="sendSuggestion()">
      <div class="close" @click="close()">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22ZM8.96965 8.96967C9.26254 8.67678 9.73742 8.67678 10.0303 8.96967L12 10.9394L13.9696 8.96969C14.2625 8.6768 14.7374 8.6768 15.0303 8.96969C15.3232 9.26258 15.3232 9.73746 15.0303 10.0303L13.0606 12L15.0303 13.9697C15.3232 14.2625 15.3232 14.7374 15.0303 15.0303C14.7374 15.3232 14.2625 15.3232 13.9696 15.0303L12 13.0607L10.0303 15.0303C9.73744 15.3232 9.26256 15.3232 8.96967 15.0303C8.67678 14.7374 8.67678 14.2626 8.96967 13.9697L10.9393 12L8.96965 10.0303C8.67676 9.73744 8.67676 9.26256 8.96965 8.96967Z" fill="#f46f58"></path> </g></svg>
      </div>
      <div class="top">
          <div class="logo">
              <img :src="$file($store.state.webInfo.logo)" alt="dmc-logo" draggable="false">
          </div>
      </div>
      <h3 class="heading">PATIENT FEEDBACK FORM</h3>
      <p class="paragraph">As a way of trying to continually improve our services, we encourage patient feedback. This enables us to see if any-changes/improvements need to our current services to try to meet our patient needs. If you have any complaints, suggestion or comments on the service you have received, please mention it in the place provided below.</p>
      <div class="inputs" v-if="formType == 'signin'">
          <label>Message</label>
          <textarea v-model="suggestionbox.message" placeholder="Write something...." rows="5" cols="100" required resize="false"></textarea>
          <button>Send suggestion</button>
      </div>
    </form>
  </Modal>
  <notifications position="bottom right" />
  <router-view/>
</template>
<script>
export default{
  name: 'App',
  data(){
    return{
      formType: 'signin',
      form: {
        email: '',
        password: '',
        firstname: '',
        lastname: '',
        phone: ''
      },
      suggestionbox: {
        message: ''
      }
    }
  },
  methods:{
    close(){
      this.$store.state.authmodal = false
      this.$store.state.suggestionbox = false
      this.form = { email: '', password: '', firstname: '', lastname: '', phone: ''}
    },
    submitform(){
      if(this.formType == 'signin'){
        this.$store.dispatch('USER_LOGIN', this.form)
            .then(res =>{
              if(res.data.status == 'success'){
                this.$notify({
                  text: res.data.message,
                  type: 'success'
                })
                localStorage.setItem('user_token', res.data.token)
                localStorage.setItem('logged_user', JSON.stringify(res.data.data))
                this.$store.state.authmodal = false
                this.form = { email: '', password: '', firstname: '', lastname: '', phone: ''}
                this.$router.push('/profile')
              } else {
                this.$notify({
                  text: res.data.message,
                  type: 'error'
                })
              }
            })
      }else{
        this.$store.dispatch('CREATE_PATIENT', this.form)
            .then(res => {
              if(res.data.status == 'success'){
                this.$notify({
                  text: res.data.message,
                  type: 'success'
                })
                this.formType = 'signin'
                this.form = { email: '', password: '', firstname: '', lastname: '', phone: ''}
              } else {
                this.$notify({
                  text: res.data.message,
                  type: 'error'
                })
              }
            })
      }
    },
    sendSuggestion(){
      this.$store.dispatch('CREATE_SUGGESTION', this.suggestionbox)
          .then(res => {
            if(res.data.status == 'success'){
              this.$notify({
                text: res.data.message,
                type: 'success'
              })
              this.$store.state.suggestionbox = false
              this.suggestionbox = { message: ''}
            } else {
              this.$notify({
                text: res.data.message,
                type: 'error'
              })
            }
          })
    },
    getAllWebInfo(){
      this.$store.dispatch('GET_ALL_WEB_INFO')
          .then(res => {
            res.data.core_values ? res.data.core_values = res.data.core_values.split(',').map((item) => item.trim()) : ''
            this.$store.state.webInfo = res.data
          })
    }
  },
  mounted(){
    this.$store.dispatch('initializeApiBaseUrl')
    this.getAllWebInfo()
  }
}
</script>
<style lang="scss" scoped>
@import "./scss/index.scss";
.form{
    width: 500px;
    background: $white;
    border-radius: 8px;
    padding: 15px 0;
    position: relative;
    @media(max-width: 530px){
        width: 95%;
    }
    .close{
        position: absolute;
        top: 20px;
        right: 30px;
        cursor: pointer;
        z-index: 1;
        svg{
            width: 30px;
            height: 30px;
            fill: $lightred;
        }
    }
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
    }
    h3{
      text-align: center;
      font-size: 1rem;
      font-weight: 600;
      color: $realblack;
      margin: 10px 0 0;
    }
    p{
      text-align: center;
      font-size: 0.8rem;
      color: #626262;
      padding: 0px 30px;
      margin: 10px 0;
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
        input,textarea{
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
            margin: 20px 0 10px;
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
        .label{
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            color: $realblack;
            span{
                color: $lightred;
                margin-left: 5px;
                cursor: pointer;
                text-decoration: underline;
            }
        }
    }
}
</style>
