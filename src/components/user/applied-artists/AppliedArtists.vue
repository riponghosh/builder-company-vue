<template>
  <div style="padding: 40px 20px;">
    <div v-if="applyingArtists.length===0">No artist applied</div>
    <applied-row v-for="row in applyingArtists" :key="row.index" :data="row" style="margin-bottom: 40px;"></applied-row>
  </div>
</template>

<script>
  import AppliedRow from '../AppliedRow.vue'

  export default {
    components: {
      AppliedRow,
    },
    computed: {
      applyingArtists() {
        const job = this.$store.state.user.appliedArtists.find(i => i.job.id === this.$route.params.id)
        return job.applyingArtists.map(i => {
          return Object.assign(job.job, { artist: i })
        })
      }
    },
    data() {
      return {}
    },
    methods: {}
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";
</style>
