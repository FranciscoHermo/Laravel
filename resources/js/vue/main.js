import { createApp } from 'vue'
import axios from 'axios'

// 1. Oruga
import Oruga from '@oruga-ui/oruga-next'
// import '@oruga-ui/oruga-next/dist/oruga-full.css'

// 2. Material Design Icons
import "@mdi/font/css/materialdesignicons.min.css" 

import App from './app.vue'
import router from './router'

const app = createApp(App).use(Oruga).use(router)

// 3. Configuración Global
app.config.globalProperties.$axios = axios
window.axios = axios

app.mount('#app')