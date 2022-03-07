require('./bootstrap');
import {createApp} from 'vue'
import VueCookie from 'vue-cookie'
import Root from './App.vue'
import router from './routes'
import store from './store/subject'

const app = createApp(Root)
app.use(router)
app.use(store)
app.use(VueCookie)
app.provide('cookies', app.config.globalProperties.$cookies)
app.mount("#app");