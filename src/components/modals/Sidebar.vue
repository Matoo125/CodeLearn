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
  <div v-for="topic in topics">
    <p class="menu-label">
      {{ topic.id }}. {{ topic.title }}
    </p>
    <ul class="menu-list">
      <li v-for="lesson in topic.lessons">
        <a @click="lessonSelected(lesson)">
          {{ topic.id }}.{{ lesson.turn }} {{ lesson.title }}
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
    if (this.topics === null) this.loadLessons()
  },
  methods: {
    toggle () {
      this.isShown = !this.isShown
    },
    loadLessons () {
      axios.get(process.env.API + 'learn/load')
        .then(response => {
          console.log(response)
          this.topics = response.data.topics
        })
        .catch(error => {
          console.log(error)
        })
    },
    lessonSelected (lesson) {
      this.$bus.$emit('lessonSelected', lesson)
      this.isShown = false
    }
  }
}
</script>


<style>
	
</style>
