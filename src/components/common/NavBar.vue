<template>
  <el-menu :default-active="$router.currentRoute.path" mode="horizontal" :router="true" class="menu">
    <el-menu-item index="/" class="share-creators item">
      <img src="~@/assets/images/logo-white.png" alt="Share Creators">
    </el-menu-item>

    <div class="menu-center">
      <el-menu-item index="/one-stop-service" class="item">
        One-Stop Service
        <div class="top-bg"></div>
      </el-menu-item>
      <!-- <el-menu-item v-if="$store.getters.isLoggedIn" index="/user/settings" class="item">My Profile</el-menu-item> -->
      <el-menu-item index="/jobs" class="item">
        Jobs Board
        <div class="top-bg"></div>
      </el-menu-item>
      <el-menu-item index="/artists" class="item">
        All Artists
        <div class="top-bg"></div>
      </el-menu-item>
      <el-menu-item index="/about-us" class="item">
        About Us
        <div class="top-bg"></div>
      </el-menu-item>
      <el-menu-item v-if="$store.getters.isEmployer" index="/post-job">
        <el-button class="post-job">Post A New Job</el-button>
      </el-menu-item>
      <!-- <el-menu-item v-if="$store.getters.isArtist || !$store.getters.isLoggedIn" index="/user/settings">
        <el-button class="post-job">Update Availability</el-button>
      </el-menu-item> -->
    </div>

    <div class="right" v-if="$store.getters.isLoggedIn">
      <el-menu-item index="/user" class="tool">My Creator Tool</el-menu-item>
    </div>
    <div class="right" v-else>
      <el-menu-item index="/signup" class="item">Sign up</el-menu-item>
      <el-menu-item index="/login" class="item">Login</el-menu-item>
    </div>
  </el-menu>
  <!--<el-dialog-->
  <!--title="提示"-->
  <!--:visible.sync="dialogVisible"-->
  <!--width="30%">-->
  <!--<span>这是一段信息</span>-->
  <!--<span slot="footer" class="dialog-footer">-->
  <!--<el-button @click="dialogVisible = false">取 消</el-button>-->
  <!--<el-button type="primary" @click="dialogVisible = false">确 定</el-button>-->
  <!--</span>-->
  <!--</el-dialog>-->
</template>

<script>
  export default {
    data() {
      return {
        dialogVisible: false
      }
    },
    methods: {
      handleClose(done) {
        this.$confirm('确认关闭？')
            .then(_ => {
              done();
            })
            .catch(_ => {
            });
      }
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../assets/styles/base.scss";

  .right {
    position: absolute;
    top: 0;
    right: 0;
  }

  .menu {
    background: $black;
    border-bottom: none;
    text-align: center;
    overflow: hidden;
    li {
      float: left;
      height: 60px;
    }
    .item {
      color: $white;
      &:hover {
        color: #ccc;
        background: $black;
      }
    }
    .share-creators {
      font-size: 20px;
      color: $white;
      position: absolute;
      top: 0;
      left: 0;
      img {
        height: 30%;
        margin: 0;
      }
    }
    .menu-center {
      display: inline-block;
      height: 60px;
    }
    .post-job {
      background: $ultramarine;
      border-radius: 60px;
      line-height: 8px;
      color: $white;
      border: none;
      font-weight: 300;
      &:hover {
        color: $white;
      }
    }
    .el-menu-item.tool {
      background: $ultramarine;
      color: $white;
      &:hover {
        background: $ultramarine;
        color: #ccc;
      }
    }
  }

  .el-menu-item:hover, .el-menu-item:focus {
    background: none;
  }

  .el-menu-item, .el-menu-item.is-active {
    border: none;
  }

  .menu .item:hover {
    background: none;
  }

  .is-active .top-bg {
    position: absolute;
    top: 27px;
    left: 10%;
    width: 80%;
    z-index: -10;
    height: 13px;
    background: $ultramarine;
  }

</style>
