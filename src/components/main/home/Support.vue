<template>
  <div class="support">
    <p>TRUSTED BY OVER 2,000 OF THE WORLD’S MOST
      INNOVATIVE COMPANIES IN THE WORLD.</p>
    <div class="brank">
      <span v-for="item in 10" class="left">LOGO</span>
    </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {}
    }
  }
</script>
<style lang="scss">
  @import "../../../assets/styles/base.scss";
  .support{
    width: 100%;
    height: 500px;
    overflow: hidden;
    p{
      @include wcenter(700px);
      font-size: 26px;
      text-align: center;
      padding-top: 60px;
      padding-bottom: 20px;
    }
    .brank{
      @include wcenter(1200px);
      span{
        display: block;
        width: 180px;
        text-align: center;
        line-height: 100px;
      }
    }

  }
</style>
