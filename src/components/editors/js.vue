<template>
  <div class='codeBox' @keyup.120="run">
    <label class="editorLabel">JavaScript</label>
    <!-- <div id='js'></div> -->
    <editor name="js" id="js" :content="js" :sync="true" lang="javascript" height="calc(100% - 18px)"></editor>
  </div>
</template>

<script>
import editor from 'vue2-ace'
import 'brace/mode/javascript'

export default {
  name: 'jsEditor',
  data () {
    return {
      js: '',
      jsLive: ''
    }
  },
  components: {
    editor
  },
  methods: {
    run () {
      this.$bus.$emit('executeCode')
    },
    sendEditorContentToVuex () {
      this.$store.commit('SET_JS', this.jsLive)
    },
    editorUpdate (value) {
      this.jsLive = value
    },
    updateCodeFromVuex () {
      this.jsLive = this.js = this.$store.state.code.js
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
