import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.config.productionTip = false
Vue.use(VueRouter)

const routes = [
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

new Vue({
  router: router
}).$mount('#app')
