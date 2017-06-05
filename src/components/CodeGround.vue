<template>
  <div class='container is-fluid'>
    <div id='leftSide'>
      <div class='codeBox'>
        <label>CSS</label>
        <editor id="css" :content="code.css" lang="css" height="calc(100% - 18px)"></editor>
      </div>
      <div class='splitter-horizontal splitter-first'></div>
      <div class='codeBox'>
        <label>HTML</label>
        <editor id="html" :content="code.html" lang="html" height="calc(100% - 18px)"></editor>
      </div>
      <div class='splitter-horizontal splitter-second'></div>
      <div class='codeBox'>
        <label>JavaScript</label>
        <!-- <div id='js'></div> -->
        <editor id="js" :content="code.js" lang="javascript" height="calc(100% - 18px)"></editor>
      </div>

    </div>

      <div class='splitter'></div>

    <div id='outputBox'>
      <iframe id='result'>
      </iframe>
    </div>
  </div>
</template>

<script>
import editor from 'vue2-ace'
import 'brace/mode/javascript'
import 'brace/mode/css'
import 'brace/mode/html'
import 'brace/theme/chrome'
export default {
  name: 'codeground',
  data () {
    return {
      code: {
        css: '',
        html: '',
        js: ''
      }
    }
  },
  methods: {},
  components: {
    editor
  },
  mounted () {
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

    $('#css').parent().resizable({
      handleSelector: '.splitter-first',
      resizeWidth: false
    })
    $('#html').parent().resizable({
      handleSelector: '.splitter-second',
      resizeWidth: false
    })
/*

    document.getElementById('run').addEventListener('click', function () {
      var css = cssEditor.getValue()
      var html = htmlEditor.getValue()
      var js = jsEditor.getValue()

      var iframe = document.getElementById('result').contentWindow.document
      iframe.open()
      var content = '<html><head><style>'
      content += css
      content += '</style></head><body>'
      content += html
      content += '<script>' + js + '<' + '/' + 'script>'
      content += '</body></html>'
      iframe.write(content)
      iframe.close()

      console.log('html: ' + html)
      console.log('css ' + css)
      console.log('js ' + js)
    }) */
  }
}
</script>

<!-- Add 'scoped' attribute to limit CSS to this component only -->
<style scoped>
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
}

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



/*  ----  RIGHT SIDE ---- */

#outputBox {
    height: 100%;
    flex: 1 1 auto;
}

#outputBox > iframe#result {
    border: none;
    width: 100%;
    height: 100%;
}


/*  ----  SPLITTERS ---- */

.splitter {
    flex: 0 0 auto;
    width: 18px;
    background: url(https://raw.githubusercontent.com/RickStrahl/jquery-resizable/master/assets/vsizegrip.png) center center no-repeat #535353;
    min-height: 200px;
    cursor: col-resize;
}

.splitter-horizontal {
    flex: 0 0 auto;
    height: 18px;
    background: url(https://raw.githubusercontent.com/RickStrahl/jquery-resizable/master/assets/hsizegrip.png) center center no-repeat #535353;
    cursor: row-resize;
}

</style>
