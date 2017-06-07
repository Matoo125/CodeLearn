<template>
     <div class='codeBox'>
       <label>HTML</label>
       <editor id="html" :content="html" :sync="true" lang="html" height="calc(100% - 18px)" :options="options"></editor>
     </div>
</template>

<script>
import editor from 'vue2-ace'
import 'brace/mode/html'
import 'brace/ext/language_tools'
import 'ace-builds/src-noconflict/snippets/html'
import 'ace-builds/src-noconflict/theme-chrome'

export default {
  name: 'htmlEditor',
  data () {
    return {
      options: {
        enableBasicAutocompletion: true,
        enableSnippets: true,
        enableLiveAutocompletion: false
      },
      html: '',
      htmlLive: ''
    }
  },
  components: {
    editor
  },
  methods: {
    sendEditorContentToVuex () {
      this.$store.commit('SET_HTML', this.htmlLive)
    },
    editorUpdate (value) {
      this.htmlLive = value
    },
    updateCodeFromVuex () {
      this.htmlLive = this.html = this.$store.state.code.html
    }
  },
  mounted () {
    this.$on('editor-update', this.editorUpdate)
    this.$bus.$on('update-vuex-code', this.sendEditorContentToVuex)
    this.$bus.$on('load-new-code-from-vuex', this.updateCodeFromVuex)
  },
  beforeDestroy () {
    this.$off('editor-update', this.editorUpdate)
    this.$bus.$off('update-vuex-code', this.sendEditorContentToVuex)
    this.$bus.$off('load-new-code-from-vuex', this.updateCodeFromVuex)
  }
}
</script>

<style lang="scss">

#leftSide > .codeBox {
    max-height: calc(100% - 36px);
    min-height: 0%;
    height: 33%;
}

#leftSide > .codeBox:first-of-type {
    flex: 0 0 auto;
}

#leftSide > .codeBox:nth-child(3) {
    flex: 0 1 auto;
}

#leftSide > .codeBox:last-of-type {
    flex: 1 1 auto;
    height: 0;
}


#leftSide > .codeBox > .ace_editor {
    height: calc(100% - 18px);
    margin: 0;
    padding: 0;
    
}

#leftSide > .codeBox > .ace_editor > textarea {
  padding: 0;
  margin: 0;
}

#leftSide > .codeBox > label {
    margin: 0;
    color: white;
}


</style>
