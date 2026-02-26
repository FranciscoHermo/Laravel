import { createApp } from 'vue'
import '../bootstrap' 


//tialwindcss
import '../../css/vue.css'

// Oruga UI
import Oruga from '@oruga-ui/oruga-next'
// import '@oruga-ui/theme-oruga/dist/oruga.css'

// Material Design Icons
import '@mdi/font/css/materialdesignicons.min.css'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.config.globalProperties.$axios = window.axios

app.use(Oruga)
app.use(router)

app.mount('#app')