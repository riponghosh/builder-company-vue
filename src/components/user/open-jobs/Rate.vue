<template>
  <div class="rate">
    <div v-if="$store.getters.isEmployer">
      <p class="title">Rate The Designer</p>
      <el-form :model="employerForm" label-position="top">
        <el-row :gutter="20">
          <el-col :span="6">
            <el-form-item label="Over All">
              <el-rate :void-color="'#fff'" v-model="employerForm.rating"></el-rate>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row style="text-align: right;" v-if="!employerRated && $store.getters.isEmployer">
          <el-button type="primary" @click="submit">Submit Rating</el-button>
        </el-row>

      </el-form>
    </div>
    <div v-if="$store.getters.isArtist">
      <p class="title">Rate The Employer</p>
      <el-form :model="artistForm" label-position="top">
        <el-row :gutter="20">
          <el-col :span="6">
            <el-form-item label="Over All">
              <el-rate :void-color="'#fff'" v-model="artistForm.rating"></el-rate>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row style="text-align: right;" v-if="!aritstRated && $store.getters.isArtist">
          <el-button type="primary" @click="submit">Submit Rating</el-button>
        </el-row>
      </el-form>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        employerRated: false,
        aritstRated: false,
        employerForm: {
          rating: 0,
          ratingQuality: 0,
          ratingCommunication: 0,
          ratingPrice: 0,
          ratingTime: 0,
          message: ''
        },
        artistForm: {
          rating: 0,
          ratingQuality: 0,
          ratingCommunication: 0,
          ratingPrice: 0,
          ratingTime: 0,
          message: ''
        }
      }
    },
    computed: {
      id() {
        return this.$route.params.id
      }
    },
    methods: {
      async submit() {
        const data = await this.$http.post(`/open-jobs/${this.id}/rate`, {
          result: this.$store.getters.isEmployer ? this.employerForm.rating : this.artistForm.rating
        })
        window.location.reload()
      }

    },
    mounted() {
      const openJob = this.$store.state.openJob
      if (openJob.ratings) {
        openJob.ratings.map((i) => {
          if (i.from === 'EMPLOYER') {
            this.employerRated = true
            this.employerForm.rating = i.result
          }
          if (i.from === 'ARTIST') {
            this.aritstRated = true
            this.artistForm.rating = i.result
          }
        })
      }
    }
  }
</script>

<style lang="scss" scoped>
  @import '../../../assets/styles/base.scss';

  .rate {
    padding: 40px;
    background-color: #ddd;
    p.title {
      font-size: 1.25rem;
      font-weight: 500;
    }
  }

  .el-form {
    border: 3px solid $black;
    padding: 20px 60px;
    background-color: $white;

    /deep/ {
      .el-form-item__label {
        padding: 0;
        color: #666;
        line-height: 30px;
      }
      .el-rate {
        background-color: $ultramarine;
        padding: 4px;
        height: auto;
        display: flex;
        justify-content: space-around;
        .el-rate__icon {
          margin: 0;
          font-size: 1.5rem;
          color: white;
          &::before {
            content: '\E637';
          }
        }
      }
      .el-button {
        border-radius: 0;
        border: 0;
      }
    }
  }
</style>

