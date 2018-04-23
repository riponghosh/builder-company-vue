<template>
  
</template>

<script>
  import CategoryBar from '../../common/CategoryBar.vue'

  export default {
    components: {
      CategoryBar
    },
    data() {
      return {
        whyIndex: 0,
        referIndex: 0,
        teamIndex: 0
      }
    },
    computed: {
      // whyIndex() {
      //   return this.whyIndex
      // },
      // referIndex() {
      //   return this.referIndex
      // },
      // teamIndex() {
      //   return this.teamIndex
      // }
    },
    methods: {
      whyNextPannal() {
        this.whyIndex < 3 ? this.whyIndex++ : this.whyIndex = 0
      },
      whyLastPannal() {
        this.whyIndex > 0 ? this.whyIndex-- : this.whyIndex = 3
      },
      referNextPannal() {
        this.referIndex < 3 ? this.referIndex++ : this.referIndex = 0
      },
      referLastPannal() {
        this.referIndex > 0 ? this.referIndex-- : this.referIndex = 3
      },
      teamNextPannal() {
        this.teamIndex < 3 ? this.teamIndex++ : this.teamIndex = 0
      },
      teamLastPannal() {
        this.teamIndex > 0 ? this.teamIndex-- : this.teamIndex = 3
      }
    }
  }
</script>
