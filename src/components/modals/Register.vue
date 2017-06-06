<template>
	<modal ref="register" title="Register" :on-ok="register" ok-text="Login" :ok-loading="true" :is-show="modal.isShown" @close="modal.isShown=false" transition="fadeDown">
  	<alert :title="modal.status" type="danger" v-if="modal.error">
  	  {{ modal.message }}
  	</alert>
    <p class="control has-icon">
      <input class="input" type="text" v-model="user.username" placeholder="Username">
      <i class="fa fa-user"></i>
    </p>
    <p class="control has-icon">
      <input class="input" type="email" v-model="user.email" placeholder="Email">
      <i class="fa fa-envelope"></i>
    </p>
    <p class="control has-icon">
      <input class="input" type="password" v-model="user.password" placeholder="Password">
      <i class="fa fa-lock"></i>
    </p>
    <p class="control has-icon">
      <input class="input" type="password" v-model="user.passwordCheck" placeholder="Password Again">
      <i class="fa fa-lock"></i>
    </p>
	</modal>
</template>

<script>
import axios from 'axios'
export default {
  name: 'Login',
  data () {
    return {
      modal: {
        isShown: false,
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
  mounted () {
    this.$bus.$on('showRegister', this.toggle)
  },
  methods: {
    register () {
      var vm = this
      console.log('register has beed clicked')
      axios.post('http://localhost/codelearn/backend/index.php?url=user/register', {
        username: this.user.username,
        email: this.user.email,
        password: this.user.password,
        passwordCheck: this.user.passwordCheck
      })
      .then(function (response) {
        console.log(response.data)
        if (response.data.status === 'SUCCESS') {
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
        vm.modal.isShown = false
      })
    },
    toggle () {
      this.modal.isShown = !this.modal.isShown
    }

  }
}
</script>


<style>
	
</style>
