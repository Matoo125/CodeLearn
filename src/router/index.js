import Vue from 'vue'
import Router from 'vue-router'
import CodeGround from '@/components/CodeGround'
import LearnGround from '@/components/LearnGround'
import Home from '@/components/Home'

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
      name: 'PlayGround',
      component: CodeGround
    },
    {
      path: '/learn',
      name: 'LearnGround',
      component: LearnGround
    }
  ]
})
