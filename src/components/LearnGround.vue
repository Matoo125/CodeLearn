<template>
  <div class='container is-fluid'>
    <div id='leftSide'>


        <tabs type="toggle" :is-full-width="true">
          <tab-item label="HTML" icon="html5">
            <html-editor></html-editor>
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

    <div id='outputBox'>
      <iframe id='result'>
      </iframe>
    </div>

  <modal name="hello-world">
    hello, world!
  </modal>



  </div>

</template>

<script>

import htmlEditor from './editors/html.vue'
import cssEditor from './editors/css.vue'
import jsEditor from './editors/js.vue'
import vmodal from 'vue-js-modal'

export default {
  name: 'LearnGround',
  data () {
    return {
    }
  },
  computed: {
    activeModules () {
      this.show.filter(function (x) { return x.select }).length
    }
  },
  methods: {
    executeCode () {
      // update vuex code values
      this.$bus.$emit('update-vuex-code')
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
    }
  },
  components: {
    htmlEditor, cssEditor, jsEditor
  },
  mounted () {
    vmodal.$modal.show('hello-world')
    var $ = window.$ = global.jQuery = require('jquery')
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
  },
  created () {
    this.$bus.$on('executeCode', this.executeCode)
  },
  beforeDestroy () {
    this.$bus.$off('executeCode', this.executeCode)
  }
}
</script>

<style>
  html {
    overflow: hidden;
  }
  /* ---- tabs --- */
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

}


/*  ----  RIGHT SIDE ---- */

#outputBox {
    height: 100%;
    flex: 1 1 auto;
    iframe {
      border: none;
      width: 100%;
      height: 100%;
    }
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
