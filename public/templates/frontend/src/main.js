import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

// page components
import TopHeader from './components/TopHeader.vue'
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'
import Blog from './components/Blog.vue'
import Team from './components/Team.vue'
import Locator from './components/Locator.vue'
// components
import Uploader from '@/components/Uploader.vue'
import Loader from '@/components/Loader.vue'
import Modal from '@/components/Modal.vue'
import SiteLoader from '@/components/SiteLoader.vue'
import Sidebar from '@/components/Sidebar.vue'
import Topbar from '@/components/Topbar.vue'
import Aboutus from '@/components/Aboutus.vue'
import Department from '@/components/Department.vue'
import Partners from '@/components/Ourpartners.vue'
import WelcomeMessage from './components/WelcomeMessage.vue'
import Whatsapp from './components/Whatsapp.vue'
// libraries
import axios from 'axios'
import VueAxios from 'vue-axios'
import Notifications from '@kyvg/vue3-notification'
import { VueEditor } from "vue3-editor";
// other
import mixin from './mixins/mixin'

const vue = createApp(App)
vue.use(store)
vue.use(router)
vue.component('Navbar', Navbar)
vue.component('TopHeader', TopHeader)
vue.component('Footer', Footer)
vue.component('Blog', Blog)
vue.component('Team', Team)
vue.component('Locator', Locator)
vue.component('Aboutus', Aboutus)
vue.component('Department', Department)
vue.component('Sidebar', Sidebar)
vue.component('Topbar', Topbar)
vue.component('Uploader', Uploader)
vue.component('Loader', Loader)
vue.component('SiteLoader', SiteLoader)
vue.component('Partners', Partners)
vue.component('Modal', Modal)
vue.component('VueEditor', VueEditor)
vue.component('WelcomeMessage', WelcomeMessage)
vue.component('Whatsapp', Whatsapp)
vue.mixin(mixin)
vue.use(Notifications)
vue.use(VueAxios, axios)
vue.mount('#app')
