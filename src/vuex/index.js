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
      js: '3',
      learn: null,
      selected: {
        lessonId: null,
        topicId: null
      },
      lastTimeSaved: null,
      title: null
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
    SET_LEARN (state, data) {
      state.code.learn = data
    },
    SET_SELECTED_LESSON (state, data) {
      state.code.selected.lessonId = data.lId
      state.code.selected.topicId = data.tId
    },
    TOGGLE_COMPLETED_STATE_OF_SELECTED_LESSON (state) {
      state.code.learn[state.code.selected.topicId].lessons[state.code.selected.lessonId].completed = !state.code.learn[state.code.selected.topicId].lessons[state.code.selected.lessonId].completed
    },
    SET_HTML (state, html) {
      state.code.html = html
    },
    SET_CSS (state, css) {
      state.code.css = css
    },
    SET_JS (state, js) {
      state.code.js = js
    },
    SET_LAST_TIME_SAVED (state, date) {
      state.code.lastTimeSaved = date
      console.log('Last Time Saved: ' + date)
    },
    SET_TITLE (state, title) {
      state.code.title = title
    }
  },
  getters: {
    isSelectedLessonCompleted (state) {
      if (state.code.selected.lessonId) {
        return state.code.learn[state.code.selected.topicId].lessons[state.code.selected.lessonId].completed
      }
      return false
    }
  }
})

export default store
