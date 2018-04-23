<template>
  <div class="inner">
    <artist-row v-for="row in tableData" :key="row.index" :data="row" style="margin: 10px;"></artist-row>
  </div>
</template>

<script>
  import CategoryBar from '../../common/CategoryBar.vue'
  import ArtistRow from '../../main/artist/ArtistRow.vue'

  export default {
    components: {
      ArtistRow,
    },
    data() {
      return {}
    },
    computed: {
      tableData() {
        return this.$store.state.user.savedArtists
      },
    },
    methods: {}
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";
</style>
