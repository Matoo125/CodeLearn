<template>
  <div class='codeBox'>
    <label>JavaScript</label>
    <!-- <div id='js'></div> -->
    <editor name="js" id="js" :content="js" lang="javascript" height="calc(100% - 18px)"></editor>
  </div>
</template>

<script>
import editor from 'vue2-ace'
import 'brace/mode/javascript'

export default {
  name: 'htmlEditor',
  data () {
    return {
      js: ''
    }
  },
  components: {
    editor
  },
  methods: {
    editorUpdate (value) {
      this.js = value
      this.$bus.$emit('js-editor-update', value)
    }
  },
  mounted () {
    this.$on('editor-update', this.editorUpdate)
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
