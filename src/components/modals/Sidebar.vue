<template>
<b-aside :is-show="isShown" :show-footer="false" title="Lessons" @close="isShown=false" placement="right">
<!-- 
      <li><a>1.2 Attributes</a></li>
      <li><a>1.4 Links</a></li>
      <li><a>1.5 Tables</a></li>
      <li><a>1.6 Lists</a></li>
      <li><a>1.7 Div & Span</a></li>
      <li><a>1.8 Styles</a></li>
      <li><a>1.9 Images</a></li>
      <li><a>1.10 Sematic</a></li>
 -->
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
