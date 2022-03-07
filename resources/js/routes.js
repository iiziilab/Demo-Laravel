import Login from './components/Login.vue'
import Dashboard from './components/Dashboard.vue'
import {createRouter, createWebHistory} from 'vue-router'

const routes = [
    {
        name:'Dashboard',
        component:Dashboard,
        path:'/dashboard'
    },
    {
        name:"Login",
        component:Login,
        path:'/'
    }
]

const router = createRouter({
    history:createWebHistory(),
    hash: false,
    routes
})

export default router