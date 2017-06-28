<template>
    <div v-if="!this.$store.state.user.session">
      <alert :title="modal.status" type="danger" v-if="modal.error">
        {{ modal.message }}
      </alert>
      <p class="control has-icon">
        <input class="input" type="text" name="username" v-model="user.username" placeholder="Username">
        <i class="fa fa-user"></i>
      </p>
      <p class="control has-icon">
        <input class="input" type="email" name="email" v-model="user.email" placeholder="Email">
        <i class="fa fa-envelope"></i>
      </p>
      <p class="control has-icon">
        <input class="input" type="password" name="password" v-model="user.password" placeholder="Password">
        <i class="fa fa-lock"></i>
      </p>
      <p class="control has-icon">
        <input class="input" type="password" name="passwordCheck" v-model="user.passwordCheck" @keyup.enter="register" placeholder="Password Again">
        <i class="fa fa-lock"></i>
      </p>

      <p :class="button + 'control'" v-if="button" >
        <button class="button is-white" @click="register">
          Register
        </button>
      </p>

    </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'Register',
  props: ['button'],
  data () {
    return {
      modal: {
        error: false,
        message: '',
        status: ''
      },
      user: {
        username: '',
        email: '',
        password: '',
        passwordCheck: ''
      }
    }
  },
  methods: {
    register () {
      var vm = this
      console.log('register has beed clicked')
      axios({
        method: 'post',
        url: process.env.API + 'user/register',
        withCredentials: true,
        data: {
          username: this.user.username,
          email: this.user.email,
          password: this.user.password,
          passwordCheck: this.user.passwordCheck
        }
      })
      .then(function (response) {
        console.log(response.data)
        if (response.data.status === 'SUCCESS') {
          vm.$store.commit('SESSION', true)
          vm.$store.commit('SET_USER', response.data)
          vm.$notify.success({ content: response.data.message, placement: 'top-center' })
          vm.modal.isShown = false
        } else {
          console.log(response.data.message)
          vm.modal.status = response.data.status
          vm.modal.message = response.data.message
          vm.modal.error = true
          vm.$refs.register.isLoading = false
        }
      })
      .catch(function (error) {
        console.log(error)
      })
    }
  }
}
</script>


<style>
  
</style>
