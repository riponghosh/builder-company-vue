<template>
  <div>
    <div class="company">
      <el-row class="banner">
        <div class="info">
          <div class="logo">
            <img :src="avatar || 'https://app-images.hiive.co.uk/images/static/missing/company-avatar.png?missing=true&width=320&height=320'" alt="" width="162" height="162">
          </div>
          <span style="font-size: 20px; padding: 10px 0px 6px 0px">{{name || '-'}}</span>
          <span><i class="location-icon"></i>{{location || '-'}}</span>
          <span>Industry: {{industry || '-'}}</span>
          <router-link :to="`/employers/${id}/edit`" v-if="$store.state.user.id === id" style="color: #FFF500; font-size: 14px;text-decoration-line: none">Profile Setting</router-link>
        </div>
      </el-row>

      <el-row class="info-bar" type="flex" justify="center">
        <el-row type="flex" justify="center" style="width: 900px; padding: 14px 0px">
          <el-col :span="6">
            <span>{{openJobs || '-'}}</span>
            <span> Opening Job </span>
          </el-col>
          <el-col :span="6">
            <span>{{postedJobs || '-'}}</span>
            <span> Job Posted </span>
          </el-col>
          <el-col :span="6">
            <span>{{payLevel || '-'}}</span>
            <span> Pay </span>
          </el-col>
          <el-col :span="6">
            <span>
              <rate :value="rating"></rate>
            </span>
            <span> Rating </span>
          </el-col>
        </el-row>
      </el-row>

      <el-row class="intro">
        <p style="font-size:18px; font-weight:bold;">Company Info</p>
        <div style="font-size:16px; line-height:30px;">{{about || 'Adobe Systems Incorporated is an American multinational computer software company. The company is headquartered in San Jose, California, United States. Adobe has historically focused upon the creation of multimedia and creativity software products, with a more recent foray towards rich Internet application software development. It is best known for Photoshop, an image editing software, Acrobat Reader, the Portable Document Format (PDF) and Adobe Creative Suite, as well as its successor Adobe Creative Cloud.'}}</div>
      </el-row>
    </div>
  </div>
</template>

<script>
  import ArtistRow from '../artist/ArtistRow.vue'
  import Rate from '@/components/common/Rate'

  export default {
    data() {
      return {
        avatar: null,
        name: null,
        location: null,
        industry: null,
        about: null,
        openJobs: null,
        postedJobs: null,
        payLevel: null,
        rating: null,
      }
    },
    components: {
      ArtistRow,
      Rate,
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.reloadData()
      })
    },
    computed: {
      id() {
        return this.$router.currentRoute.params.id
      },
      isSelf() {
        return this.$store.state.user.id === this.id
      },
    },
    methods: {
      async reloadData() {
        const data = await this.$http.get(`/employers/${this.id}`)
        this.avatar = data.avatar
        this.name = data.company_name
        this.location = data.location
        this.industry = data.industry
        this.about = data.about
        this.openJobs = data.open_jobs
        this.postedJobs = data.posted_jobs
        this.payLevel = data.pay_level
        this.rating = data.rating
      },
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .company {
    position: relative;
    width: 100%;
    border: 3px solid #000;
    box-sizing: border-box;
  }

  .banner {
    width: 100%;
    height: 410px;
    background-image: url('../../../assets/images/profile-back.jpg');
    background-size: cover;
  }

  .info {
    @include wcenter(200px);
    position: absolute;
    top: 40px;
    left: 50%;
    margin-left: -100px;
    height: 300px;
    font-size: 14px;
    line-height: 26px;
    text-align: center;
    color: #fff;
    span {
      display: block;
    }
  }

  .logo {
    @include wcenter(170px);
    @include lcenter(170px);
    border-radius: 90px;
    background: #DD1C22;
    border: 4px solid rgba(255, 255, 255, 0.3);
    box-sizing: border-box;
    img {
      border-radius: 50%;
    }
  }

  .info-bar {
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    background: $yellow;
    span {
      display: block;
      text-align: center;
    }

    .el-col {
      span:nth-of-type(1) {
        font-size: 22px;
        font-weight: bold;
      }
    }
  }

  .intro {
    padding: 10px 10% 10px 10%;
    padding-bottom: 40px;
  }

  // 以下弃用
  .location-icon::before {
    content: '';
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 8px;
    border: 2px solid #ddd;
    margin-right: 6px;
  }

  .btn {
    @include wwcenter(110px);
    background: $blue;
    color: #fff;
    display: block;

  }

  .pre_projects {
    li {
      .text {
        padding: 20px 50px;
        background: #fff;
        ul > li {
          float: left;
          span {
            margin-left: 10px;
            display: inline-block;
            background: #000;
            color: #fff;
            padding: 0px 16px;
          }
        }

      }
      .label {
        background: $blue;
        color: #fff;
        height: 80px;
        text-align: center;
        padding: 0px 50px;
        ul {
          margin-right: -30px;
          li {
            float: left;
            height: 80px;
            span {
              display: block;
              height: 40px;
              line-height: 40px;
              margin-right: 30px;
            }
          }
        }
      }
    }
  }

  .pre_works {
    .pic {
      width: 100%;
      height: 360px;
      background: #ccc;
      position: relative;
      .label {
        position: absolute;
        bottom: 0px;
        width: 100%;
        box-sizing: border-box;
        padding: 16px 40px;
        background: rgba(0, 0, 0, 0.2);
        color: #fff;
        div {
          line-height: 22px;
          font-size: 14px;
        }
      }
    }
    .pic_child {
      margin-top: 30px;
      width: 100%;
      div {
        width: 50%;
        height: 360px;
        float: left;
        box-sizing: border-box;
        img {
          width: 100%;
          height: 100%;
        }
        div {
          width: 100%;
          height: 300px;
          background: #eee;
        }
      }
    }

  }

  .brs_30 {
    border-right: 30px solid transparent;
  }

  .btn_yellow {
    @include wwcenter(100px);
    background: $yellow;
    border-radius: 4px;
    margin-top: 50px;
  }

  .project_title {
    background: #000;
    color: #fff;
    width: 320px;
    display: inline-block;
    @include lcenter(40px);
    padding-left: 20px;
    padding-top: 10px;
    margin-top: 40px;
  }

  .project_bg {
    background: #000;
    padding: 50px 0px;
    overflow: hidden;
  }

  .inner_1200 {
    @include wcenter(1200px);
  }

  .inner_1100 {
    @include wcenter(1100px);
  }

</style>
