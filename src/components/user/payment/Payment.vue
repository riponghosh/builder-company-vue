<template>
  <div style="padding: 40px 160px;">
    <p class="headline">My Payment</p>

    <el-row class="top">
      <el-col :span="12">
        <div class="title">Amount In My Account</div>
        <div class="info">$ {{ $store.state.user.amount }}</div>
      </el-col>
      <el-col :span="12">
        <div class="title">Other transaction</div>
        <div class="info">
          <div>Received In Total: <span>$ {{ $store.state.user.amount }} </span></div>
          <div>Panding To Receive: <span>$ 0</span></div>
        </div>
      </el-col>
    </el-row>
    <el-row class="bottom">
      <el-col :span="12">
        <div class="title">Trade History:</div>
        <div class="item" v-for="item in 6">+ Total Gain - Graphic Design for Adobe: <span>$8000</span></div>
      </el-col>
      <el-col :span="12">
        <div class="title">Detail Transaction History:</div>
        <div class="item" v-for="item in 6">+ Total Gain - Graphic Design for Adobe: <span>$8000</span></div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
//  import GridOne from './grid-one.vue'
//  import GridTwo from './grid-two.vue'
  import ElCol from "element-ui/packages/col/src/col";

  export default {
//    components: {ElCol},
    mounted() {
    },
    data() {
      return {}
    },
    methods: {}
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";
  .headline{
    font-weight: bold;
    font-size: 22px;
    position: relative;
    transform: translateX(-80px);
    &::before{
      display: block;
      content: "";
      width: 170px;
      height: 16px;
      background: $yellow;
      position: absolute;
      left: -24px;
      top:3px;
      z-index: -1;
      transform: rotateZ(-3deg);
    }
  }
  .top{
    border:3px solid #000;
    margin-bottom: 20px;
    text-align: center;

    .info{
      display: inline-block;
      width: 100%;
      height: 110px;
      box-sizing: border-box;
    }
    .el-col:nth-child(1){
      .title{
        background:$yellow;
        line-height: 56px;
        border-bottom: 3px solid #000;
      }
      .info{
        padding: 46px 0px;
        font-size: 18px;
        font-weight: bold;
      }
    }
    .el-col:nth-child(2){
      border-left: 3px solid #000;
      .title{
        background: $blue;
        color: #fff;
        line-height: 56px;
        border-bottom: 3px solid #000;
      }
      .info{
        line-height:34px;
        padding: 20px 0px;
        width: 280px;
        text-align: left;
        span{
          font-size: 18px;
          font-weight: bold;
        }
        .el-col:nth-child(2){
          border: none;
        }
      }
    }
  }
  .bottom{
    border:3px solid #000;
    text-align: center;

    .title{
      height: 60px;
      line-height: 60px;
      border-bottom: 1px solid #000;
    }
    .item{
      height: 44px;
      line-height: 44px;
      border-bottom: 1px solid #000;
      span{
        padding-left: 50px;
      }
    }
    .el-col:nth-child(1){
      background: $blue;
      color: #fff;
      font-weight: lighter;
      padding-bottom: 80px;
    }
    .el-col:nth-child(2){
      background: $yellow;
      border-left: 3px solid #000;
      padding-bottom: 80px;
    }
  }
</style>























