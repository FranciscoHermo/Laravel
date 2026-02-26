import { createRouter, createWebHistory } from 'vue-router'

import List from './components/List.vue'
import save from './components/save.vue'

const routes = [
    {
        name:'list',
        path:'/vue',
        component:List
    },
    {
        name:'save',
        path:'/vue/save:slug?',
        component:save
    }
    
]

const router = createRouter({
    history : createWebHistory(),
    routes : routes,
})

export default router