<template>
	<modal ref="save" title="Save" :on-ok="save" ok-text="Save" :ok-loading="true" :is-show="modal.isShown" @close="modal.isShown=false" transition="fadeDown">
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
  name: 'Save',
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
    save () {
      this.$bus.$emit('update-vuex-code')
      console.log(this.generateHtml(this.$store.state.code.html))
      var vm = this
      vm.$refs.save.isLoading = true
      console.log('save has beed clicked')
      axios({
        method: 'get',
        url: process.env.API + 'code/save',
        withCredentials: true,
        params: {
          action: 'create',
          css: vm.$store.state.code.css,
          html: this.generateHtml(vm.$store.state.code.html),
          htmlbody: vm.$store.state.code.html,
          js: vm.$store.state.code.js,
          title: vm.title
        }
      })
      .then(function (response) {
        console.log(response.data)
        if (response.data.status === 'SUCCESS') { // YOU ARE LOGGED IN
          vm.$notify.success({ content: response.data.message, placement: 'top-center' })
          vm.modal.isShown = false
        } else { // DISPLAY ERROR MESSAGE
          console.log(response.data.message)
          vm.modal.status = response.data.status
          vm.modal.message = response.data.message
          vm.modal.error = true
          vm.$refs.save.isLoading = false
        }
      })
      .catch(function (error) {
        console.log(error)
        vm.modal.isShown = false
      })
    },
    toggle () {
      this.modal.isShown = !this.modal.isShown
    },
    generateHtml (html) {
      return `
<!DOCTYPE html>
<html>
<head>
  <title> ${this.title} </title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  ${html}
  <script src="script.js"><` + `/` + `script>
</body>
</html>
`
    }

  }
}
</script>


<style>
	
</style>
