<template>
  <div class="setting">
    <el-form label-position="top">
      <p class="status">Status</p>
      <el-row :gutter="20">
        <el-col :span="10">
          <el-form-item label="Availability">
            <el-select v-model="availability" placeholder="Availability">
            <el-option label="Available Now" value="available"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="10">
          <el-form-item label="On site / off site">
            <el-select v-model="site" placeholder="On site / off site">
              <el-option label="On site" value="onSite"></el-option>
              <el-option label="Off site" value="offSite"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row style="margin-top: 12px;margin-bottom: 40px"><el-button class="button-style">Go to My Calender</el-button></el-row>
      <el-row :gutter="60">
      <el-col :span="12">
        <p class="billingInfo">Billing Info</p>
        <el-form-item label="Full Name">
          <el-input v-model="fullName"></el-input>
        </el-form-item>
        <el-form-item label="Address">
          <el-input v-model="address"></el-input>
        </el-form-item>
        <el-row :gutter="20">
          <el-col :span="12">
            <el-form-item label="City">
              <el-input v-model="city"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="ZIP Code">
              <el-input v-model="zipCode"></el-input>
            </el-form-item>
          </el-col>
        </el-row>

        <el-form-item label="Country">
          <el-select v-model="country" placeholder="Country">
            <el-option label="China" value="china"></el-option>
          </el-select>
        </el-form-item>

      </el-col>

      <el-col :span="12">
        <p class="creditCard">Credit Card Info</p>
        <el-form-item label="Card Number">
          <el-input v-model="cardNumber"></el-input>
        </el-form-item>
        <el-form-item label="Cardholder Name">
          <el-input v-model="cardholderName"></el-input>
        </el-form-item>
        <el-form-item label="Expire Date" >
          <el-select v-model="expireDate" placeholder="Expire Date">
            <el-option label="2018/2/2" value="2018/2/2"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="CVV">
          <el-input v-model="cvv"></el-input>
        </el-form-item>
      </el-col>
      </el-row>
      <el-row style="margin-top: 12px;margin-bottom: 60px">
        <el-button class="button-style">Link a card</el-button>
        <el-button class="button-style">Link Paypal</el-button>
      </el-row>
    </el-form>
    <p class="notification">Notifications Preferences</p>
    <div v-for="item in 10" class="notify">Email notification when open jobs have applicants</div>
  </div>
</template>

<script>
  import ElInput from "../../../../node_modules/element-ui/packages/input/src/input";
  export default {
    components: {ElInput},
    mounted() {
    },
    data() {
      return {

        availability:'',
        site:'',

        fullName:'',
        address:'',
        city:'',
        zipCode:'',
        country:'',

        cardNumber:'',
        cardholderName:'',
        expireDate:'',
        cvv:''
      }
    },
    methods: {}
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";
  @mixin titleStyle($width){
    font-size: 22px;
    font-weight: bold;
    position: relative;
    &:before{
      content: '';
      display: block;
      width: $width;
      height: 14px;
      background: $yellow;
      position: absolute;
      top:6px;
      left: -10px;
      z-index: -1;
      transform: rotateZ(-2deg);
    }
  }
  .setting{
    padding: 20px 60px;
    max-width: 1200px;
  }
  .status{
    @include titleStyle(88px);
  }
  .billingInfo{
    @include titleStyle(128px);
  }
  .creditCard{
    font-size: 22px;
    font-weight: bold;
  }
  .notification{
    @include titleStyle(272px);
  }
  .el-form-item{
    .el-select{
      width: 100%;
    }
  }
  /deep/ .el-form-item__label{
    line-height: 0px;
  }
  .button-style{
    border: none;
    background: #000;
    color: #fff;
    border-radius: 0px;
  }
  .notify{
    line-height: 34px;
    position: relative;
    padding-left: 30px;
    &:before{
      content: "";
      display: block;
      width: 14px;
      height: 14px;
      border: 3px solid #000;
      background: $yellow;
      border-radius: 20px;
      position: absolute;
      left: -2px;
      top:6px;

    }
  }

</style>
