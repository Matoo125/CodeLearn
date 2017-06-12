<template>
  <div class='container is-fluid'>
    <div id='leftSide'>

     <grid-layout
                 :layout='layout'
                 :col-num='12'
                 :row-height='30'
                 :is-draggable='false'
                 :is-resizable='true'
                 :vertical-compact='true'
                 :margin='[10, 10]'
                 :use-css-transforms='true'
         >
         <grid-item :x="grid.html.x" :y="grid.html.y" :w="grid.html.w" :h="grid.html.h" class="gridItem" :i="grid.html.i">
           <html-editor></html-editor>
         </grid-item>


         </grid-layout>

    </div>

      <div class='splitter'></div>

    <div id='outputBox'>
      <iframe id='result'>
      </iframe>
    </div>
  </div>
</template>

<script>
/*
import htmlEditor from './editors/html.vue'
import cssEditor from './editors/css.vue'
import jsEditor from './editors/js.vue'
 */
import htmlEditor from './editors/html.vue'

import VueGridLayout from 'vue-grid-layout'
var GridLayout = VueGridLayout.GridLayout
var GridItem = VueGridLayout.GridItem
export default {
  name: 'LearnGround',
  data () {
    return {
      grid: {
        html: {'x': 0, 'y': 0, 'w': 12, 'h': 10, 'i': 1}
      },
      layout: [
      {'x': 0, 'y': 0, 'w': 12, 'h': 10},
      {'x': 2, 'y': 0, 'w': 12, 'h': 10},
      {'x': 4, 'y': 0, 'w': 12, 'h': 10}
      ]
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
    GridLayout, GridItem, htmlEditor// htmlEditor, cssEditor, jsEditor
  },
  mounted () {
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
</style>
<!-- Add 'scoped' attribute to limit CSS to this component only -->
<style scoped>
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

/* ---- GRID --- */
.gridItem {
  background-color:white;
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
