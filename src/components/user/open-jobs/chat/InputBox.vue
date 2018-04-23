<template>
  <div class="text">
    <textarea v-model="content" @keydown="onKeydown"></textarea>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        content: '',
      };
    },
    methods: {
      onKeydown(e) {
        if (e.keyCode === 13) {
          e.preventDefault()
        }
        if (e.keyCode === 13 && this.content.length > 0) {
          this.$store.dispatch('sendMessage', this.content)
          this.content = ''
        }
      },
    }
  }
</script>

<style lang="scss" scoped>
  .text {
    z-index: 1000;
    position: absolute;
    bottom: 0;
    width: 100%;

    background: red;
    height: 80px;
    border-top: solid 1px #ddd;
    box-sizing: border-box;

    textarea {
      margin: 10px;
      height: calc(100% - 20px);
      width: calc(100% - 20px);
      border: none;
      outline: none;
      background: transparent;
      cursor: text;
    }
  }
</style>
