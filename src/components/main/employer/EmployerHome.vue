<template>
  <div>
    <div class="banner">
      <p>Find The Most Suitable Designer From Worldwide.</p>
      <div class="btn-guide">
        <el-button class="btn co_black">Find Pro</el-button>
        <el-button class="btn co_yellow">One-Stop Service</el-button>
        <el-button class="btn co_black">Pro List</el-button>
      </div>
    </div>
    <category-bar></category-bar>
    <div class="top-artists pd cl">
      <p>Top Rating Artists</p>
      <div v-for="item in 9" class="item-artist left mb_30">
        <img src="" alt="">
        <div class="label">
          <div class="left">
            <span>Ada Lingzi Liu</span>
            <span>UX Designer</span>
            <span>Statue:Avaliable</span>
          </div>
          <div class="left">
            <span>$100/hr</span>
            <span>5</span>
            <span>experience + 5 years</span>
          </div>
        </div>
      </div>
    </div>
    <el-button class="btn_yellow mt_40">See More</el-button>
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
      margin-bottom: 100px;
    }
    .btn-guide{
      @include wcenter(512px);
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
        height: 110px;
        padding: 10px 30px;
        box-sizing: border-box;
        background: #000;
        color: #fff;
        div{
          width: 50%;
          span{
            display: block;
            line-height: 30px;
          }
        }

      }
    }
  }
  .btn_yellow{
    border: 0px;
    background: $yellow;
    @include wwcenter(200px);
  }
  .pd{
    padding: 0px 10%;
  }
  .cl{
    overflow: hidden;
  }
  .btn{
    width: 160px;
    border: 0px;
  }

</style>


