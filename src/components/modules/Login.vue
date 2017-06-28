<template>
  <div v-if="!this.$store.state.user.session">
    <alert :title="login.status" type="danger" v-if="login.error">
      {{ login.message }}
    </alert>
      <p class="control has-icon">
        <input class="input" type="email" name="email" v-model="user.email" placeholder="Email">
        <i class="fa fa-envelope"></i>
      </p>
      <p class="control has-icon">
        <input class="input" type="password" name="password" v-model="user.password" placeholder="Password" @keyup.enter="login">
        <i class="fa fa-lock"></i>
      </p>

      <p :class="button + 'control'" v-if="button" >
        <button class="button is-white" @click="login()">
          Login
        </button>
      </p>

  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'LoginModule',
  props: ['button'],
  data () {
    return {
      module: {
        error: false,
        message: '',
        status: ''
      },
      user: {
        email: '',
        password: ''
      }
    }
  },
  methods: {
    login () {
      // vm.$refs.modal.isLoading = true
      console.log('login has beed clicked')
      axios({
        method: 'post',
        url: process.env.API + 'user/login',
        withCredentials: true,
        data: {
          email: this.user.email,
          password: this.user.password
        }
      })
      .then(response => {
        console.log(response.data)
        if (response.data.status === 'SUCCESS') { // YOU ARE LOGGED IN
          this.$store.commit('SESSION', true)
          this.$store.commit('SET_USER', response.data)
          this.$notify.success({ content: response.data.message, placement: 'top-center' })
          // this.module.isShown = false
        } else { // DISPLAY ERROR MESSAGE
          console.log(response.data.message)
          this.module.status = response.data.status
          this.module.message = response.data.message
          this.module.error = true
          // vm.$refs.modal.isLoading = false
        }
      })
      .catch(function (error) {
        console.log(error)
        // this.module.isShown = false
      })
    }
  }
}
</script>


<style>
  
</style>
