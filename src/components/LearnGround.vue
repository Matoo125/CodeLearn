<template>
  <div class='container is-fluid'>
    <div id='leftSide'>


        <tabs type="toggle" :is-full-width="true">
          <tab-item label="HTML" icon="html5">
            <html-editor @keyup.120="executeCode"></html-editor>
          </tab-item>
          <tab-item label="CSS" icon="css3">
            <css-editor></css-editor>
          </tab-item>
          <tab-item label="JS" icon="code">
            <js-editor></js-editor>
          </tab-item>
        </tabs>


    </div>

      <div class='splitter'></div>

       <tabs type="toggle" :is-full-width="true" class="tabs-scroll">
         <tab-item label="Prepare" icon="book">
          <div v-if="lesson.id" class="title is-2 has-text-centered lessonHeader">
            {{ lesson.topic_id }}.{{ lesson.turn }} - {{ lesson.title }} | Theory
            <hr>
          </div>
           <div class="inTab" v-html="marked(lesson.theory)"></div>
         </tab-item>
         <tab-item label="Exercise" icon="thumb-tack">
           <div v-if="lesson.id" class="title is-2 has-text-centered lessonHeader">
            {{ lesson.topic_id }}.{{ lesson.turn }} - {{ lesson.title }} | Practise
             <hr>
          </div>
           <div class="inTab" v-html="marked(lesson.exercise)"></div>
           <collapse>
             <collapse-item v-for="solution in lesson.solutions" title="Solution" key="solution.id">
               <div v-html="marked(solution.solution)"></div>
             </collapse-item>
           </collapse>
         </tab-item>
         <tab-item label="See" class="resultTab" icon="window-maximize">
           <iframe id="result"></iframe>
         </tab-item>
       </tabs>

  </div>

</template>

<script>
import axios from 'axios'
import marked from 'marked'
import htmlEditor from './editors/html.vue'
import cssEditor from './editors/css.vue'
import jsEditor from './editors/js.vue'
import hljs from 'highlight.js'
marked.setOptions({
  highlight: function (code) {
    return hljs.highlightAuto(code).value
  }
})
export default {
  name: 'LearnGround',
  data () {
    return {
      activeTabRight: 0,
      lesson: {},
      $: null
    }
  },
  methods: {
    executeCode () {
      // update vuex code values
      this.$bus.$emit('update-vuex-code')
      this.saveCode()
      var iframe = document.getElementById('result').contentWindow.document
      iframe.open()
      var content = '<html><head><style>'
      content += this.$store.state.code.css
      content += '</style></head><body>'
      content += this.$store.state.code.html
      content += '<script>' + this.$store.state.code.js + '<' + '/' + 'script>'
      content += '</body></html>'
      iframe.write(content)
      iframe.close()
      console.log('html: ' + this.$store.state.code.html)
      console.log('css: ' + this.$store.state.code.css)
      console.log('js: ' + this.$store.state.code.js)
      this.$("span:contains('See')").click()
    },
    saveCode () {
      axios({
        method: 'post',
        url: process.env.API + 'code/save',
        withCredentials: true,
        data: {
          action: '',
          type: 'exercises',
          title: this.lesson.slug,
          css: this.$store.state.code.css,
          html: this.generateHtml(this.$store.state.code.html),
          htmlbody: this.$store.state.code.html,
          js: this.$store.state.code.js
        }
      })
      .then(response => {
        console.log(response.data)
        if (response.data.status === 'SUCCESS') { // Code has been saved
          this.$notify.success({ content: response.data.message, placement: 'top-center' })
        } else { // DISPLAY ERROR MESSAGE
          console.log(response.data.message)
          this.$notify.error({ content: response.data.message, placement: 'top-center' })
        }
      }).catch(error => { console.log(error) })
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
    },
    loadCode () {
      axios({
        method: 'get',
        url: process.env.API + 'code/load',
        withCredentials: true,
        params: {
          title: this.lesson.slug,
          folder: 'exercises'
        }
      })
      .then(response => {
        console.log(response.data)
        if (response.data.status === 'SUCCESS') {
          this.$store.commit('SET_HTML', response.data.code.html)
          this.$store.commit('SET_CSS', response.data.code.css)
          this.$store.commit('SET_JS', response.data.code.js)
          this.$bus.$emit('load-new-code-from-vuex')
          this.$notify.success({ content: response.data.message, placement: 'top-center' })
        }
      })
      .catch(error => {
        console.log(error)
      })
    },
    lessonCompleted () {
      axios({
        method: 'post',
        url: process.env.API + 'learn/lessonCompleted',
        withCredentials: true,
        data: { lessonId: this.lesson.id }
      }).then(response => {
        console.log(response.data)
        this.$store.commit('TOGGLE_COMPLETED_STATE_OF_SELECTED_LESSON')
        // this.$store.state.code.learn
      }).catch(error => { console.log(error) })
    },
    lessonIncomplete () {
      axios({
        method: 'post',
        url: process.env.API + 'learn/lessonNotCompleted',
        withCredentials: true,
        data: { lessonId: this.lesson.id }
      }).then(response => {
        console.log(response.data)
        this.$store.commit('TOGGLE_COMPLETED_STATE_OF_SELECTED_LESSON')
      }).catch(error => { console.log(error) })
    },
    marked (input) {
      return input ? marked(input) : ''
    }
  },
  components: {
    htmlEditor, cssEditor, jsEditor
  },
  mounted () {
    var $ = window.$ = this.$ = global.jQuery = require('jquery')
    window.$ = $.extend(require('jquery-resizable-dom/dist/jquery-resizable.js'))

    $('#leftSide').resizable({
      handleSelector: '.splitter',
      resizeHeight: false,
      onDragStart: function (event, $el) {
        $('iframe').css('pointer-events', 'none')
      },
      onDragStop: function (event, $el) {
        $('iframe').css('pointer-events', 'auto')
      }
    })
    this.$bus.$emit('showSidebar')
  },
  created () {
    this.$bus.$emit('activeGround', 'LearnGround')
    this.$bus.$on('executeCode', this.executeCode)
    this.$bus.$on('lessonCompleted', this.lessonCompleted)
    this.$bus.$on('lessonIncomplete', this.lessonIncomplete)
    this.$bus.$on('lessonSelected', () => {
      this.lesson = this.$store.state.code.learn[this.$store.state.code.selected.topicId].lessons[this.$store.state.code.selected.lessonId]
      this.loadCode()
    })
  },
  beforeDestroy () {
    this.$bus.$off('executeCode', this.executeCode)
    this.$bus.$off('lessonCompleted', this.lessonCompleted)
    this.$bus.$off('lessonIncomplete', this.lessonIncomplete)
    this.$bus.$off('lessonSelected')
  }
}
</script>

<style lang="scss">
  html {
    overflow: hidden;
  }
  /* ---- tabs --- */
  .tabs.is-toggle li a,
  .tabs.is-toggle:first-child li a,
  .tabs.is-toggle:last-child li a {
    border-radius: 0;
  }
  .tabs .tab-content{ margin: 0; }
  .tab-list > li {
    background-color:white;
  }
  .editorLabel {
  display: none;
}
.ace_editor {
  height: 100%!important;
}

.tabs-scroll.tabs .tab-pane {
  overflow-x: scroll;

}



.tab-pane blockquote {
  background-color: #f5f7fa;
  border-left: 5px solid #d3d6db;
  padding: 1.5em;
  display: flex;
}


.inTab a {
  display: inline;
  padding: 0;
  border: 0 !important;
  color: blue;
  &:hover {
    background-color: rgba(0,0,0,0) !important;
  }
}

.inTab {
  line-height: 1.7em;
  white-space: normal;
  ul, ol {
    display: block !important;
    padding-left: 20px;
  } ul {
    list-style-type: disc;
  }
  li {
    display: list-item;
  }
  p, blockquote, ul, pre, article {
    margin-bottom: 15px;
  }
  blockquote {
    padding: 1em 1.0em 0 1.5em;
  }

  table td, table th {
      border: 1px solid black;
      padding: 2px 10px;
  }
}

</style>
<!-- Add 'scoped' attribute to limit CSS to this component only -->
<style lang="scss" scoped>
html {
  overflow: hidden;
}
/*  ----  CONTAINER ---- */

.container {
    display: flex;
    height: calc(100vh - 50px);
    margin: 0;
}

/*  ----  LEFT SIDE ---- */

#leftSide {
    width: 50%;
    height: 100%;
    max-width: calc(100% - 18px);
    background-color: #3c3c3c;
    flex: 0 0 auto;
    display: flex;
    flex-direction: column;
    .codeBox {
      height: 100%;
    }

    .tabs .tabs-pane {
      overflow-x: hide;
    }

}


/*  ----  RIGHT SIDE ---- */

#outputBox {
    height: 100%;
    flex: 1 1 auto;
}

iframe {
  border: none;
  width: 100%;
  height: 100%;
}

.inTab {
  padding: 0 25px 25px 25px;

}

.lessonHeader {
  margin: .7em 0 .4em 0;
}


/*  ----  SPLITTERS ---- */

.splitter {
    flex: 0 0 auto;
    width: 18px;
    background: url(https://raw.githubusercontent.com/RickStrahl/jquery-resizable/master/assets/vsizegrip.png) center center no-repeat #535353;
    min-height: 200px;
    cursor: col-resize;
}

.splitter-horizontal:not(:last-child):not(:first-child) {
    flex: 0 0 auto;
    height: 18px;
    background: url(https://raw.githubusercontent.com/RickStrahl/jquery-resizable/master/assets/hsizegrip.png) center center no-repeat #535353;
    cursor: row-resize;
}

</style>
