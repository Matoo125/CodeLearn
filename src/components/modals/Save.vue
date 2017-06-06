<template>
	<modal ref="save" title="Save" :on-ok="save" ok-text="Login" :ok-loading="true" :is-show="modal.isShown" @close="modal.isShown=false" transition="fadeDown">
	<alert :title="modal.status" type="danger" v-if="modal.error">
	  {{ modal.message }}
	</alert>
	  <p class="control has-icon">
	    <input class="input" type="text" v-model="title" placeholder="Project Title">
	    <i class="fa fa-floppy-o"></i>
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
      title: ''
    }
  },
  mounted () {
    this.$bus.$on('showSave', this.toggle)
  },
  methods: {
    login () {
      var vm = this
      vm.$refs.login.isLoading = true
      console.log('save has beed clicked')
      axios({
        method: 'post',
        url: 'http://localhost/codelearn/backend/index.php?url=code/save',
        withCredentials: true,
        data: {
          email: this.user.email,
          password: this.user.password
        }
      })
      .then(function (response) {
        console.log(response.data)
        if (response.data.status === 'SUCCESS') { // YOU ARE LOGGED IN
          vm.$store.commit('SESSION', true)
          vm.$notify.success({ content: response.data.message, placement: 'top-center' })
          vm.modal.isShown = false
        } else { // DISPLAY ERROR MESSAGE
          console.log(response.data.message)
          vm.modal.status = response.data.status
          vm.modal.message = response.data.message
          vm.modal.error = true
          vm.$refs.login.isLoading = false
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
