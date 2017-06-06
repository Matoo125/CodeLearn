<template>
  <nav class="nav has-shadow">
    <div class="nav-left">
      <a class="nav-item">
        <span class="logo">M4CodeRun</span>
      </a>
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
    <div class="nav-right nav-menu">
      <a class="nav-item" @click="showRegister" v-if="!isLoggedIn">
        Register
      </a>
      <a class="nav-item" @click="showLogin" v-if="!isLoggedIn">
        Login
      </a>

      <a class="nav-item" @click="logout" v-if="isLoggedIn">
        Logout
      </a>

      <div class="nav-item" v-if="isLoggedIn">
        <div class="field is-grouped">
          <p class="control">
            <a class="button is-primary" @click="run">
              <span class="icon">
                <i class="fa fa-floppy-o"></i>
              </span>
              <span>Save</span>
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

    </div>

    <register></register>
    <login></login>

  </nav>
</template>

<script>
import login from './modals/Login.vue'
import register from './modals/Register.vue'
import axios from 'axios'

export default {
  name: 'Navbar',
  components: { login, register },
  data () {
    return {
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
        url: 'http://localhost/codelearn/backend/index.php?url=user/logout',
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
    showLogin () {
      this.$bus.$emit('showLogin')
    },
    showRegister () {
      this.$bus.$emit('showRegister')
    },
    run () {
      this.$bus.$emit('executeCode')
    }
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
