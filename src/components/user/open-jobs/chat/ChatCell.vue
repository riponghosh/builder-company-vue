<template>
    <div :class="{ 'right': data.self }" class="cell clearfix">
      <div class="time">{{ data.date | time }}</div>
      <img class="avatar" width="30" height="30" :src="data.self ? user.img : currentChat.user.img">
      <div class="message" v-html="data.content"></div>
    </div>
</template>

<script>
  import msapnoment from 'moment'

  export default {
    props: ['data'],
    computed: {
      user() {
        return this.$store.state.chat.user
      },
      currentChat() {
        return this.$store.getters.currentChat
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
    .cell {
        margin: 10px;

        .time {
            text-align: center;
            font-size: 12px;
            color: #b2b2b2;
            margin-bottom: 5px;
        }

        .avatar {
            border-radius: 2px;
            margin: 0 6px;
        }

        .message {
            vertical-align: top;
            display: inline-block;
            max-width: calc(100% - 120px);
            line-height: 18px;
            padding: 6px;
            background: white;
            font-size: 13px;
            border-radius: 2px;
        }
    }

    .right {
        .avatar {
            float: right;
        }

        .message {
            float: right;
        }
    }

    .clearfix {
        overflow: auto;
    }
</style>
