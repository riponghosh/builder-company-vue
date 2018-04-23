<template>
  <section class="footer">
    <el-row class="footer-container" justify="space-between" type="flex">
      <el-col :span="15">
        <div class="link-bar">
          <span style="font-size: 22px">Share Creators</span>
          <router-link class="link" to="/jobs">Jobs Board</router-link>
          <router-link class="link" to="/artists">All Artists</router-link>
          <router-link class="link" to="/one-stop-service">One-Stop Service</router-link>
          <router-link class="link" to="/about-us">About Us</router-link>
        </div>
        <div class="contact-info">
          <span>Contact Us: Contact@yizhenart.com</span>
          <span>Address: San Francisco</span>
        </div>
      </el-col>
      <el-col :span="9">
        <el-row style="width: 510px;float: right">
          <el-col :span="13" style="margin-top: 10px;">
            <img src="~@/assets/images/brand.png" alt="" width="260px">
          </el-col>
          <el-col :span="11">
            <div style="font-size: 16px;margin-bottom: 12px">Subscribe to our newsletter</div>
            <div class="search">
              <el-input></el-input>
              <el-button>OK</el-button>
            </div>
          </el-col>
        </el-row>
      </el-col>
    </el-row>
  </section>
</template>

<script>
  import ElRow from "element-ui/packages/row/src/row";

  export default {
    components: { ElRow },
    data() {
      return {}
    }
  }
</script>

<style lang="scss" scoped>
  .footer {
    background: #000;
    color: #fff;
    padding: 50px 60px;
    min-width: 1200px;
    box-sizing: border-box;
  }

  .link-bar {
    margin-bottom: 28px;
    span {
      margin-right: 42px;
    }
  }

  .contact-info {
    span {
      margin-right: 40px;
    }
  }

  .search {
    /deep/ .el-input {
      float: left;
      width: 176px;
      border: 0px;

      /deep/ .el-input__inner {
        background-color: #000;
        border-radius: 4px 0px 0px 4px;
      }

    }
    /deep/ .el-button {
      width: 56px;
      border-radius: 0px 4px 4px 0px;
      color: #000;
      border: 1px solid #fff;
    }
  }

  .link {
    margin-right: 40px;
    text-decoration: none;
    color: white;
  }
</style>
