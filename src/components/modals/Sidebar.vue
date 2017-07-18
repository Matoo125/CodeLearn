<template>
<b-aside :is-show="isShown" :show-footer="false" title="Lessons" @close="isShown=false" placement="right">


  <div v-for="topic in this.$store.state.code.learn">
    <p class="menu-label">
      {{ topic.id }}. {{ topic.title }}
    </p>
    <ul class="menu-list">
      <li v-for="lesson in topic.lessons">
        <a @click="lessonSelected(lesson.id, topic.id)">
          {{ topic.id }}.{{ lesson.turn }} {{ lesson.title }} <span v-if="lesson.completed"> - COMPLETED</span>
        </a>
      </li>
    </ul>
  </div >
</b-aside>
</template>

<script>
import axios from 'axios'
export default {
  name: 'Sidebar',
  data () {
    return {
      isShown: false,
      topics: null
    }
  },
  mounted () {
    this.$bus.$on('showSidebar', this.toggle)
    if (this.$store.state.code.learn === null) this.loadLessons()
  },
  methods: {
    toggle () {
      this.isShown = !this.isShown
    },
    loadLessons () {
      axios.get(process.env.API + 'learn/load', { withCredentials: true })
        .then(response => {
          this.$store.commit('SET_LEARN', response.data.topics)
        }).catch(error => { console.log(error) })
    },
    lessonSelected (lessonId, topicId) {
      console.log(topicId)
      this.$store.commit('SET_SELECTED_LESSON', { lId: lessonId, tId: topicId })
      this.$bus.$emit('lessonSelected')
      this.isShown = false
    }
  }
}
</script>


<style>
	
</style>
