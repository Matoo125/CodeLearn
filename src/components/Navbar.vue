<template>
  <nav class="nav has-shadow">
    <div class="nav-left">
      <router-link class="nav-item" :to="{ name: 'Home' }">
        <span class="logo">M4CodeRun</span>
      </router-link>
    </div>

    <div class="nav-center">
      <a class="nav-item">
        <span class="icon">
          <i class="fa fa-github"></i>
        </span>
      </a>
    </div>

    <!-- This "nav-toggle" hamburger menu is only visible on mobile -->
    <!-- You need JavaScript to toggle the "is-active" class on "nav-menu" -->
    <span class="nav-toggle">
      <span></span>
      <span></span>
      <span></span>
    </span>

    <!-- This "nav-menu" is hidden on mobile -->
    <!-- Add the modifier "is-active" to display it on mobile -->
    <div class="nav-right nav-menu" v-if="public">
      <a class="nav-item" @click="showRegister" v-if="!isLoggedIn">
        Register
      </a>
      <a class="nav-item" @click="showLogin" v-if="!isLoggedIn">
        Login
      </a>

      <div class="nav-item" v-if="isLoggedIn && play">
        <div class="field is-grouped">
          <p class="control">
            <a class="button is-primary" @click="showSave">
              <span class="icon">
                <i class="fa fa-floppy-o"></i>
              </span>
              <span>Save</span>
            </a>
          </p>
        </div>
      </div>

      <div class="nav-item" v-if="isLoggedIn && play">
        <div class="field is-grouped">
          <p class="control">
            <a class="button is-success" @click="showProjects">
              <span class="icon">
                <i class="fa fa-floppy-o"></i>
              </span>
              <span>Projects</span>
            </a>
          </p>
        </div>
      </div>

      <div class="nav-item" v-if="isLoggedIn && learn">
        <div class="field is-grouped">
          <p class="control">
            <a class="button is-warning" @click="showSidebar">
              <span class="icon">
                <i class="fa fa-floppy-o"></i>
              </span>
              <span>Lessons</span>
            </a>
          </p>
        </div>
      </div>

      <div class="nav-item" v-if="isLoggedIn && learn && !this.$store.getters.isSelectedLessonCompleted">
        <div class="field is-grouped">
          <p class="control">
            <a class="button is-success" @click="completed">
              <span class="icon">
                <i class="fa fa-check"></i>
              </span>
              <span>Completed</span>
            </a>
          </p>
        </div>
      </div>

      <div class="nav-item" v-if="isLoggedIn&& learn && this.$store.getters.isSelectedLessonCompleted">
        <div class="field is-grouped">
          <p class="control">
            <a class="button is-danger" @click="incompleted">
              <span class="icon">
                <i class="fa fa-times"></i>
              </span>
              <span>Incompleted</span>
            </a>
          </p>
        </div>
      </div>

      <div class="nav-item">
        <div class="field is-grouped">
          <p class="control">
            <a class="button run" @click="run">
              <span class="icon">
                <i class="fa fa-play"></i>
              </span>
              <span>Run</span>
            </a>
          </p>
        </div>
      </div>

      <a class="nav-item" @click="logout" v-if="isLoggedIn">
        Logout
      </a>

    </div>


    <sidebar></sidebar>
    <register></register>
    <login></login>
    <save></save>
    <projects></projects>
  </nav>
</template>

<script>
import login from './modals/Login.vue'
import register from './modals/Register.vue'
import save from './modals/Save.vue'
import projects from './modals/Projects.vue'
import sidebar from './modals/Sidebar.vue'
import axios from 'axios'

export default {
  name: 'Navbar',
  components: { login, register, save, projects, sidebar },
  data () {
    return {
      sidebar: false,
      public: true,
      learn: null,
      play: null
    }
  },
  computed: {
    isLoggedIn () {
      return this.$store.state.user.session
    }
  },
  methods: {
    logout () {
      var vm = this
      axios({
        method: 'get',
        url: process.env.API + 'user/logout',
        withCredentials: true
      })
      .then(function (response) {
        console.log(response.data)
        vm.$notify.success({ content: response.data.message, placement: 'top-center' })
        vm.$store.commit('SESSION', false)
      })
      .catch(function (error) {
        console.log(error)
      })
    },
    completed () {
      this.$modal.confirm({
        content: 'Have you really finished this lesson?',
        title: 'Lesson finished',
        okText: 'Yes',
        cancelText: 'No',
        onOk: () => { this.$bus.$emit('lessonCompleted') }
      })
    },
    incompleted () {
      this.$modal.confirm({
        content: 'Do you really want to remove this lesson from completed list?',
        title: 'Not yet completed',
        okText: 'Yes',
        cancelText: 'No',
        onOk: () => { this.$bus.$emit('lessonIncomplete') }
      })
    },
    showLogin () {
      this.$bus.$emit('showLogin')
    },
    showRegister () {
      this.$bus.$emit('showRegister')
    },
    showSave () {
      if (!this.$store.state.code.lastTimeSaved) {
        this.$bus.$emit('showSave')
      }
    },
    showProjects () {
      this.$bus.$emit('showProjects')
    },
    showSidebar () {
      this.$bus.$emit('showSidebar')
    },
    run () {
      this.$bus.$emit('executeCode')
    }
  },
  created () {
    this.$bus.$on('activeGround', ground => {
      if (ground === 'LearnGround') {
        this.play = false
        this.learn = true
      } else {
        this.learn = false
        this.play = true
      }
    })
  },
  beforeDestroy () {
    this.$bus.$off('activeGround')
  }
}
</script>

<style lang="scss">
.nav {
  background-color: #333;
  color: #fff;
  a {
    color: #ddd;
    &:hover {
      color: #999;
    }
  }
  .run {
    color: #333;
    &:hover {
      color: #111;
    }
  }
  .logo {
    font-size: 1.5em;
    font-weight: 400;
  }
}


</style>
