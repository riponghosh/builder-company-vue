<template>
    <div class="message-history" v-chat-scroll>
        <chat-cell v-for="item in session.messages" :data="item" key="item.id"></chat-cell>
    </div>
</template>

<script>
  import moment from 'moment'
  import ChatCell from './ChatCell.vue'

  export default {
    components: {
      ChatCell,
    },
    computed: {
      session() {
        return this.$store.state.chat.chats.find(session => session.id === this.$store.state.chat.currentSessionId)
      }
    },
    filters: {
      time(date) {
        return moment(date).format('HH:mm')
      }
    },
  }
</script>

<style lang="scss" scoped>
    .message-history {
        background: #f3f3f3;
        overflow-y: scroll;
        margin-bottom: 80px;
        height: calc(100% - 80px);
    }
</style>
