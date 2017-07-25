<template>
	<modal ref="projects" title="Projects" :on-ok="load" ok-text="Load" :ok-loading="true" :is-show="modal.isShown" @close="modal.isShown=false" transition="fadeDown">
  <alert :title="modal.status" type="danger" v-if="modal.error">
    {{ modal.message }}
  </alert>
    <radio-group v-model="selectedProject">
      <div v-for="(project, index) in projects">
        <radio-button :val="project + '+' + index" >{{ project }}</radio-button>      
      </div>
    </radio-group>
	</modal>
</template>

<script>
import axios from 'axios'
export default {
  name: 'Projects',
  data () {
    return {
      modal: {
        isShown: false,
        error: false,
        message: '',
        status: ''
      },
      selectedProject: '',
      projects: {
      }
    }
  },
  mounted () {
    this.$bus.$on('showProjects', this.loadProjectsList)
  },
  beforeDestroy () {
    this.$bus.$off('showProjects', this.loadProjectsList)
  },
  methods: {
    load () {
      let vm = this
      axios({
        method: 'get',
        url: process.env.API + 'code/load',
        withCredentials: true,
        params: {
          title: vm.selectedProject.split('+')[0],
          folder: 'projects'
        }
      })
      .then(function (response) {
        console.log(response.data)
        vm.$store.commit('SET_HTML', response.data.code.html)
        vm.$store.commit('SET_CSS', response.data.code.css)
        vm.$store.commit('SET_JS', response.data.code.js)
        vm.$store.commit('SET_LAST_TIME_SAVED', Date.now())
        vm.$store.commit('SET_TITLE', vm.selectedProject.split('+')[0])
        vm.$bus.$emit('load-new-code-from-vuex')
        vm.$notify.success({ content: response.data.message, placement: 'top-center' })
        vm.modal.isShown = false
      })
      .catch(function (error) {
        console.log(error)
      })
    },
    loadProjectsList () {
      this.toggle()
      console.log('loading projects list')
      var vm = this
      // vm.$refs.projects.isLoading = true
      axios({
        method: 'get',
        url: process.env.API + 'code/getProjects',
        withCredentials: true,
        params: {}
      })
      .then(function (response) {
        console.log(response.data)
        if (response.data.status === 'SUCCESS') {
          vm.projects = response.data.projects
        } else { // DISPLAY ERROR MESSAGE
          console.log(response.data.message)
          vm.modal.status = response.data.status
          vm.modal.message = response.data.message
          vm.modal.error = true
          // vm.$refs.projects.isLoading = false
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
