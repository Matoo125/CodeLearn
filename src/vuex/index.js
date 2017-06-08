import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    user: {
      session: false,
      id: null,
      username: null,
      email: null
    },
    code: {
      html: '1',
      css: '2',
      js: '3'
    }
  },
  actions: {
    checkLogin (context) {
      axios({
        method: 'get',
        url: process.env.API + 'user/is_logged_in',
        withCredentials: true
      })
      .then(function (response) {
        console.log(response.data)
        if (response.data.status === 'TRUE') {
          context.commit('SESSION', true)
        } else {
          context.commit('SESSION', false)
        }
      })
      .catch(function (error) {
        console.log(error)
      })
    }
  },
  mutations: {
    SESSION (state, bool) {
      state.user.session = bool
    },
    SET_USER (state, user = null) {
      if (user !== null) {
        state.user.id = user.user_id
        state.user.username = user.user_name
        state.user.email = user.user_email
      } else {
        state.user.id = null
        state.user.email = null
        state.user.username = null
      }
    },
    SET_HTML (state, html) {
      state.code.html = html
    },
    SET_CSS (state, css) {
      state.code.css = css
    },
    SET_JS (state, js) {
      state.code.js = js
    }
  },
  getters: {}
})

export default store
