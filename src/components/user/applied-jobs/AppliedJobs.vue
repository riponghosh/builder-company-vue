<template>
  <div style="padding: 40px 20px;">
    <applied-row :data="appliedJob" style="margin-bottom: 40px;"></applied-row>
  </div>
</template>

<script>
  import AppliedRow from '../AppliedRow.vue'

  export default {
    components: {
      AppliedRow,
    },
    computed: {
      appliedJob() {
        return this.$store.state.user.appliedJobs.find(i => i.id === this.$route.params.id)
      }
    },
    data() {
      return {}
    },
    methods: {},
  }
</script>

<style lang="scss" scoped>
  @import '../../../assets/styles/base.scss';
</style>
