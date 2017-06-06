<template>
     <div class='codeBox'>
       <label>HTML</label>
       <editor id="html" :content="html" lang="html" height="calc(100% - 18px)" :options="options"></editor>
     </div>
</template>

<script>
import editor from 'vue2-ace'
import 'brace/mode/html'

export default {
  name: 'htmlEditor',
  data () {
    return {
      html: '',
      options: {
        enableBasicAutocompletion: true
      }
    }
  },
  components: {
    editor
  },
  methods: {
    editorUpdate (value) {
      this.html = value
      this.$bus.$emit('html-editor-update', value)
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
