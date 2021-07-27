import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './App.vue'

import Index from '@/components/Index'

const routes = [
    { path: '/',  component: Index },
  ]

  const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
  })

  new Vue({
    render: h => h(App),
    router: router
  }).$mount('#app')