import Vue from 'vue'
import Router from 'vue-router'
import CodeGround from '@/components/CodeGround'
import LearnGround from '@/components/LearnGround'
import Home from '@/components/Home'

import VueBlu from 'vue-blu'
import 'vue-blu/dist/css/vue-blu.min.css'

Vue.use(VueBlu)

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/playground',
      name: 'CodeGround',
      component: CodeGround
    },
    {
      path: '/learn',
      name: 'LearnGround',
      component: LearnGround
    }
  ]
})
