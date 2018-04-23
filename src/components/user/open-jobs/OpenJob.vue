<template>
  <div v-if="data.job">
    <progress-bar style="margin: 40px;"></progress-bar>
    <!-- 等待甲方生成合同的状态 -->
    <div v-if="data.contract === null">
      <generate-contract v-if="$store.getters.isEmployer"></generate-contract>
    </div>

    <!-- 已经生成合同 -->
    <div v-else="">
      <!-- 等待签合同 -->
      <div v-if="data.contract.status === 'WAIT_ARTIST_SIGN' && $store.getters.isArtist" style="margin: 40px;">
        <confirm-contract></confirm-contract>
      </div>
      <div v-if="data.contract.status === 'WAIT_EMPLOYER_SIGN' && $store.getters.isEmployer" style="margin: 40px;">
        <confirm-contract></confirm-contract>
      </div>

      <!-- 等待评价的状态 -->
      <div v-if="data.contract.status === 'WAIT_RATE' || data.contract.status === 'FINISHED'">
        <!-- <rate v-if="!haveRated"></rate> -->
        <rate></rate>
      </div>
    </div>
    <!--<chat class="chat"></chat>-->
  </div>
</template>

<script>
  import ProgressBar from './common/ProgressBar.vue'
  import GenerateContract from './GenerateContract.vue'
  import ConfirmContract from './ConfirmContract.vue'
  import Rate from './Rate.vue'
  import Chat from './chat/Chat.vue'

  export default {
    components: {
      ProgressBar,
      GenerateContract,
      ConfirmContract,
      Rate,
      Chat,
    },
    data() {
      return {}
    },
    computed: {
      data() {
        return this.$store.state.openJob
      },
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.$store.dispatch('reloadCurrentOpenJob', to.params.id)
      })
    },
  }
</script>

<style lang="scss" scoped>
  .chat {
    margin: 30px;
    border: 2px solid blue;
  }
</style>
