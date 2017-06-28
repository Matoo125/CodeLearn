<template>
  <div>
    <section class="hero is-fullheight is-primary is-flex">
      <div class="hero-body">
        <div class="container is-flex-tablet">
          <div class="greeting">
            <h1 class="title">
              Welcome to Codelearn
            </h1>
            <h2 class="subtitle">
              Learn to for free.
            </h2>            
          </div>

          <div class="authentication" v-if="!this.$store.state.user.session">
            <tabs>
              <tab-item label="Login">
                <Login button="is-white"></Login>
              </tab-item>
              <tab-item label="Register">
                <Register button="is-whitee"></Register>
              </tab-item>
            </tabs>
          </div>

          <div v-else class="links">
            <router-link :to="{ path: 'Learn'}">
              <button class="button">Go Learn</button>
            </router-link>
            <router-link :to="{ name: 'Home' }">
              <button class="button">How does it work</button>
            </router-link>
            <router-link :to="{ name: 'PlayGround' }">
              <button class="button">Playground</button>
            </router-link>

          </div>

        </div>

      </div>

      <div class="hero-foot">

      </div>

    </section>


  </div>
</template>

<script>
import Register from './modules/Register.vue'
import Login from './modules/Login.vue'
export default {
  name: 'Home',
  components: { Register, Login }
}
</script>

<style>
</style>

<style scoped>
.authentication, .links {
  max-width: 500px;
  flex: 1;
  min-height: 256px;
}

.greeting {
  flex: 1 1 0;
  display: block;
}

.container {
  max-width: 960px;
}

@media only screen and (max-width: 768px) {
  .authentication, .links {
        margin-top: 40px;
  }

  .greeting {
    text-align: center;
  }

}
</style>
