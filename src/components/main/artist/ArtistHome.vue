<template>
  <div>
    <div class="banner">
      <p>One-Stop Service Help You Sol
        Feature Cases & Designers</p>
      <el-button class="btn">See All Available Jobs</el-button>
    </div>
    <category-bar></category-bar>
    <div class="opening-jobs pd">
      <span class="fz_24">Current Opening Jobs</span>
      <div v-for="item in 4" class="item-job mb_30">
        <div class="info ">
          <p class="fz_24">Social App Looking For Motion Graphic Designer</p>
          <p>Adobe looking for Off - Site, Freelance, Motion Graphic Designer.</p>
          <div class="cl">
            <div class="skills left">
              Skills Required:
              <span v-for='item in 2'>Web</span>
            </div>
            <div class="bonnus-points left">
              Bonnus Points:
              <span v-for='item in 2'>Dog</span>
            </div>
            <div class="left location">
              Location:<span>San Francisco</span>
            </div>
          </div>

          <div class="description">
            <p>Project Description:</p>
            <p>
              We are looking for a freelancer who can give a professional touch to the existing website www.startoonlabs.com. We are looking for end to end services UX/UI, Content development based on our inputs,
              front end & back end and SEO with google analytics. Looking for a long collaboration with the suitable candidate. More.</p>
          </div>
        </div>
        <ul class="label">
          <li v-for="item in 4" class="left">
            <span>20 HRS</span>
            <span>Pitch time left</span>
          </li>
        </ul>
      </div>
    </div>
    <el-button class="btn_blue">See All Availabel Jobs</el-button>
    <div class="top-artists pd cl">
      <p>Top Rating Artists</p>
      <div v-for="item in 9" class="item-artist left mb_30">
        <img src="" alt="">
        <div class="label">
          <span>AdaL.</span>
          <span>Avaliable</span>
          <span class="right">UX Deigner</span>
        </div>
      </div>
    </div>
    <el-button class="btn_blue mt_40">More Pro</el-button>
    <Support></Support>
  </div>
</template>
<script>
  import CategoryBar from '../../common/CategoryBar.vue'
  import Support from '../home/Support.vue'
  export default {
    components: {
      CategoryBar,
      Support
    },
    data() {
      return {}
    }
  }
</script>
<style lang="scss">
  @import "../../../assets/styles/base.scss";

  .banner {
    width: 100%;
    height: 400px;
    p {
      padding-top: 60px;
      @include wcenter(600px);
      text-align: center;
      font-size: 28px;
    }
    .btn {
      margin-top: 100px;
      border: 0px;
      background: $yellow;
      color: #000;
      @include wwcenter(200px);

    }
  }
  .item-job{
    .info{
      width: 100%;
      border: 1px solid #ccc;
      border-bottom: none;
      height: 300px;
      padding: 20px 60px;
      box-sizing: border-box;
      line-height: 44px;
      p{
        margin: 0px;
      }
      .skills,.bonnus-points,.location{
        width: 33.33333%;
        span{
          display: inline-block;
          background: #000;
          color: #fff;
          padding: 0px 20px;
          margin-right: 10px;
          box-sizing: border-box;
          line-height: 22px;
        }
      }
      .description{
        line-height: 28px;
      }
    }
    .label{
      width: 100%;
      background: $yellow;
      overflow: hidden;
      li{
        width: 160px;
        span{
          display: block;
          line-height: 30px;
          text-align: center;
        }
      }
    }
  }
  .top-artists{
    margin-right: -20px;
    .item-artist{
      width: 33.3333%;
      border-right: 20px solid transparent;
      box-sizing: border-box;
      /*background: pink;*/
      img{
        display: block;
        width: 100%;
        height: 300px;
        background: #eee;
      }
      .label{
        height: 60px;
        padding: 20px;
        box-sizing: border-box;
        background: #000;
        color: #fff;
        span{
          display: inline-block;
          width: 100px;
        }
      }
    }
  }

  .pd{
    padding: 0px 10%;
  }
  .cl{
    overflow: hidden;
  }
  .btn_blue {
    border: 0px;
    background: $blue;
    color: #fff;
    @include wwcenter(200px);
  }


</style>
