import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    user: {
      session: false,
      user_id: null,
      username: null
    }
  },
  actions: {
    checkLogin (context) {
      axios({
        method: 'get',
        url: 'http://localhost/codelearn/backend/index.php?url=user/is_logged_in',
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
    }
  },
  getters: {}
})

export default store
