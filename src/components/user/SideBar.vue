<template>
  <el-menu :default-active="$route.path" @select="handleSelect">

    <div v-if="$store.getters.isEmployer">
      <el-menu-item :index="`/employers/${$store.state.user.id}`">
        <i class="el-icon-location"></i>
        <span>My Company Page</span>
      </el-menu-item>
    </div>

    <div v-if="$store.getters.isArtist">
      <el-menu-item :index="`/artists/${$store.state.user.id}`">
        <i class="el-icon-location"></i>
        <span>My Profile Page</span>
      </el-menu-item>
    </div>

    <el-submenu index="open-jobs">
      <template slot="title">
        <i class="el-icon-location"></i>
        <span>Open Jobs</span>
      </template>
      <el-menu-item :index="`/user/open-jobs/${i.id}`" v-for="i in openJobs" :key="i.id">{{ i.projectName }}</el-menu-item>
    </el-submenu>


    <el-submenu index="applied-jobs" v-if="$store.getters.isArtist">
      <template slot="title">
        <i class="el-icon-location"></i>
        <span>Applied Jobs</span>
      </template>
      <el-menu-item :index="`/user/applied-jobs/${i.id}`" v-for="i in appliedJobs" :key="i.id">{{ i.projectName }}</el-menu-item>
    </el-submenu>

    <el-submenu index="applied-artists" v-if="$store.getters.isEmployer">
      <template slot="title">
        <i class="el-icon-location"></i>
        <span>Applied Artists</span>
      </template>
      <el-menu-item :index="`/user/applied-artists/${i.job.id}`" v-for="i in appliedArtists" :key="i.id">{{ i.job.projectName }}</el-menu-item>
    </el-submenu>

    <el-menu-item index="/user/saved-artists" v-if="$store.getters.isEmployer">
      <i class="el-icon-menu"></i>
      <span slot="title">Saved Artists</span>
    </el-menu-item>


    <el-menu-item index="/user/archived-jobs">
      <i class="el-icon-menu"></i>
      <span slot="title">Jobs History</span>
    </el-menu-item>


    <el-menu-item index="/user/payment">
      <i class="el-icon-menu"></i>
      <span slot="title">My Payment</span>
    </el-menu-item>


    <el-menu-item index="/user/notifications" style="margin-bottom: 40px;">
      <i class="el-icon-menu"></i>
      <span slot="title">Notifications</span>
    </el-menu-item>


    <el-menu-item index="/user/calendar">
      <i class="el-icon-menu"></i>
      <span slot="title">Production Calendar</span>
    </el-menu-item>


    <el-menu-item index="/user/assistant">
      <i class="el-icon-menu"></i> <span slot="title">Creators Assistant</span>
    </el-menu-item>


    <el-menu-item index="/user/settings">
      <i class="el-icon-menu"></i>
      <span slot="title">Account Setting</span>
    </el-menu-item>

    <el-menu-item index="/user/logout" style="position: relative;">
      <i class="el-icon-menu"></i>
      <span slot="title">Logout</span>
    </el-menu-item>

  </el-menu>
</template>

<script>
  export default {
    data() {
      return {}
    },
    mounted() {
      this.$store.dispatch('updateSideBar')
    },
    methods: {
      handleSelect(key, keyPath) {
        this.$router.push(key)
        if (key === '/user/logout') {
          this.$store.dispatch('logout')
          this.$router.push('/')
        }
      }
    },
    computed: {
      openJobs() {
        const items = this.$store.state.user.openJobs
        return items ? items : []
      },
      appliedJobs() {
        const items = this.$store.state.user.appliedJobs
        return items ? items : []
      },
      appliedArtists() {
        const items = this.$store.state.user.appliedArtists
        return items ? items : []
      },
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../assets/styles/base.scss";

  .el-menu {
    display: flex;
    flex-direction: column;
    background-color: $black;
    color: $white;
    border: 0;
    /deep/ .el-menu-item, /deep/ .el-submenu__title {
      color: $white;
      i, button {
        color: $white;
      }
      &:hover, &:active, &:focus, &.is-active {
        background-color: $yellow;
        color: $black;
        i, button {
          color: $black;
        }
      }
    }
    /deep/ .el-menu {
      background-color: transparent;
    }
  }
</style>
