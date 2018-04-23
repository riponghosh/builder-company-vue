<template>
  <div>
    <el-row class="up">
      <el-col :span="7" class="portfolio" :style="{
        'background-image': data.artist.portfolios.length > 0 ? 'url('+ data.artist.portfolios[0].url +')' : '',
      }">
        <el-row class="info">
          <div class="con">
            Portfolio Image
          </div>
          <div class="bg"></div>
        </el-row>
      </el-col>

      <el-col :span="17" class="context">
        <el-row>
          <span class="job-title">{{ data.projectName }}</span>
        </el-row>
        <el-row>
          <span>Catgory: </span>
          <span style="font-size: 0.9rem;">{{ data.artist.categories.join(' / ') }}</span>
        </el-row>
        <el-row>
          <el-col :span="8">
            <div>Skill:</div>
            <div>
              <span class="item" v-for="item in data.artist.skills">{{ item }}</span>
            </div>
          </el-col>
          <el-col :span="8">
            <div>Preference:</div>
            <div>
              <span class="item">{{ data.artist.jobTypes }}</span>
            </div>
          </el-col>
          <el-col :span="8">
            <div>Preference:</div>
            <div>
              <span class="item">{{ data.artist.site }}</span>
            </div>
          </el-col>
        </el-row>
        <el-row>
          <span>Clients: </span>
          <span style="font-size: 0.9rem;">{{ data.artist.clients }}</span>
        </el-row>
        <el-row class="proposal">
          <div class="title">Proposal:</div>
          <p style="word-wrap: break-word; text-align: left; font-size: 0.9rem">{{ data.info || 'Nothing' }}</p>
          <p v-if="$store.getters.isArtist">
            <el-button type="primary" @click="check()">Check This Job Post</el-button>
          </p>
          <p v-if="$store.getters.isEmployer">
            <el-button type="primary" @click="check()">Check This Job Post</el-button>
            <el-button type="primary" @click="hire()">Hire</el-button>
          </p>
        </el-row>
      </el-col>
    </el-row>

    <el-row class="label">
      <el-col :span="8" style="text-align: left;">
        <el-row class="item-con">{{ data.artist.firstName + ' ' + data.artist.lastName || '' }}</el-row>
        <el-row class="item-label">Apply as {{ data.category }}</el-row>
      </el-col>
      <el-col :span="4">
        <el-row class="item-con">{{ data.artist.stauts || 'AVAILABLE' }}</el-row>
        <el-row class="item-label">Status</el-row>
      </el-col>
      <el-col :span="4">
        <rate class="item-con" style="white-space: nowrap" v-model="data.artist.rating" disabled></rate>
        <el-row class="item-label">Rating</el-row>
      </el-col>
      <el-col :span="4">
        <el-row class="item-con">${{data.artist.hourlyRate }}/hr</el-row>
        <el-row class="item-label">Hourly Rate</el-row>
      </el-col>
      <el-col :span="4">
        <el-row class="item-con">{{ data.artist.experience }}YRS</el-row>
        <el-row class="item-label">Experience</el-row>
      </el-col>
    </el-row>
  </div>


</template>

<script>
  import Rate from '@/components/common/Rate'

  export default {
    props: ['data'],
    components: {
      Rate,
    },
    data() {
      return {}
    },
    methods: {
      check() {
        this.$router.push(`/jobs/${this.data.id}`)
      },
      async hire() {
        try {
          const result = await this.$confirm('Are you sure to hire this artist?', 'Confirmation', {
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
            type: 'warning'
          })
          console.log(this.data.artist)
          const data = await this.$http.post('/job/hire', {
            job_id: this.$route.params.id,
            artist_id: this.data.artist.id,
          })
          await this.$store.dispatch('updateSideBar')
          this.$message.success('Submit successfully')
          this.$router.push(`/user/open-jobs/${this.$route.params.id}`)
        } catch (_) {
        }
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import '../../assets/styles/base.scss';

  .job-title {
    font-weight: bold;
    font-size: 1.3rem;
    background: $yellow;
    padding: 3px;
  }

  .up {
    border-bottom: none;
    background-color: #F8F7F7;
    .portfolio {
      background-size: cover;
      background-position: center;
      min-height: 400px;
      .el-row {
        width: 60%;
        margin: 0 auto;
        text-align: center;
      }
      .info {
        padding: 2px 10px 2px 12px;
        color: $black;
        position: relative;
        height: 40px;
        line-height: 40px;
        margin-top: 20px;
        .con {
          font-weight: 900;
          position: relative;
          z-index: 10;
        }
        .bg {
          position: absolute;
          top: 0;
          bottom: 0;
          left: 2px;
          right: 0;
          height: 30px;
          margin: auto;
          background: $white;
          transform: rotate(5deg);
          z-index: 9;
        }
      }
      .check {
        margin-top: 30%;
        .el-button {
          background: $black;
          font-size: 0.8rem;
          height: 30px;
          border: 0;
          line-height: 0;
        }
      }
    }

    .context {
      padding: 20px 30px;
      .title {
        font-weight: 500;
        font-size: 1.25rem;
        height: 40px;
        line-height: 40px;
        position: relative;
        span {
          position: absolute;
          left: 50%;
          font-weight: normal;
          font-size: 0.9rem;
        }
      }
      .looking-for {
        span,
        p {
          background-color: $yellow;
        }
      }
      .el-row {
        line-height: 40px;
        .item {
          font-size: 0.8rem;
          display: inline-block;
          line-height: initial;
          text-align: center;
          background: #DEDEDE;
          padding: 2px 10px;
          margin-right: 5px;
          box-sizing: content-box;
          border-radius: 5px;
          &:last-of-type {
            margin-right: 0;
          }
        }
      }
    }

    .proposal {
      padding: 0 20px;
      margin: 20px 10px 10px;
      border-radius: 10px;
      background-color: $white;
      .title {
        text-align: center;
        font-size: 1.25rem;
        font-weight: 500;
        color: #95989A;
        border-bottom: 1px solid #ccc;
      }
      p {
        text-align: center;
        .el-button {
          border: none;
          color: $white;
          font-weight: normal;
          &:nth-child(1) {
            background-color: $yellow;
            color: $black;
          }
        }
      }
    }
  }

  .label {
    min-height: 80px;
    padding: 0 20px;
    text-align: center;
    background: $ultramarine;
    color: $white;

    .item-con {
      height: 50px;
      line-height: 50px;
      font-size: 1.2rem;
    }
    .item-label {
      font-size: 0.8rem;
    }
  }

  .el-rate {
    height: auto;
    display: flex;
    justify-content: space-around;
    /deep/ .el-rate__icon {
      padding-top: 10px;
      font-size: 1.5rem;
      &::before {
        color: $white;
      }
    }
  }
</style>
