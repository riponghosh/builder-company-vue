<template>
  <div class="chat">
    <message-history></message-history>
    <input-box></input-box>
  </div>
</template>

<script>
  import MessageHistory from './MessageHistory.vue'
  import InputBox from './InputBox.vue'

  export default {
    components: {
      MessageHistory,
      InputBox,
    },
  }
</script>

<style lang="scss" scoped>
  .chat {
    height: 500px;
    position: relative;
  }
</style>
