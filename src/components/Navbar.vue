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
      <a class="nav-item" @click="modal.register = true">
        Register
      </a>
      <a class="nav-item" @click="modal.login=true">
        Login
      </a>
      <div class="nav-item">
        <div class="field is-grouped">
          <p class="control">
            <a class="button run" >
              <span class="icon">
                <i class="fa fa-play"></i>
              </span>
              <span>Run</span>
            </a>
          </p>
        </div>
      </div>
    </div>
    <modal title="Register" :on-ok="register" ok-text="Register" :ok-loading="true" :is-show="modal.register" @close="modal.register=false" transition="fadeDown">
    <p class="control has-icon">
      <input class="input" type="email" placeholder="Email">
      <i class="fa fa-envelope"></i>
    </p>
    <p class="control has-icon">
      <input class="input" type="text" placeholder="Username">
      <i class="fa fa-user"></i>
    </p>
    <p class="control has-icon">
      <input class="input" type="password" placeholder="Password">
      <i class="fa fa-lock"></i>
    </p>
    </modal>

    <modal title="Login" :on-ok="login" ok-text="Login" :ok-loading="true" :is-show="modal.login" @close="modal.login=false" transition="fadeDown">
      <p class="control has-icon">
        <input class="input" type="email" placeholder="Email">
        <i class="fa fa-envelope"></i>
      </p>
      <p class="control has-icon">
        <input class="input" type="password" placeholder="Password">
        <i class="fa fa-lock"></i>
      </p>
    </modal>
  </nav>
</template>

<script>
export default {
  name: 'Navbar',
  data () {
    return {
      modal: {
        register: false,
        login: false
      }
    }
  },
  methods: {
    register () {
    },
    login () {}
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
