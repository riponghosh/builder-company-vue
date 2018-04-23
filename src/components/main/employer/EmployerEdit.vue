<template>
  <div>
    <div class="banner">
      <!--<span>Drag To Upload</span>-->
      <!--<span>Profile Background Photo</span>-->
    </div>

    <el-form ref="form" :model="form" label-width="80px" label-position="top">
      <el-upload
        class="avatar-uploader"
        action="/api/storage/upload"
        name="file"
        :show-file-list="false"
        :on-success="handleAvatarSuccess">
        <img v-if="form.avatarImageUrl" :src="form.avatarImageUrl" class="avatar" width="150" height="150">
        <i v-else class="el-icon-plus profile-icon"></i>
      </el-upload>

      <div class="basic">
        <p style="padding-left: 10px; font-size: 20px; font-weight: bold">Basic</p>
        <el-row :gutter="220">
          <el-col :span="12">
            <div class="item">
              <span>Company Name</span>
              <el-input v-model="form.name"></el-input>
            </div>
            <div class="item">
              <span>Industry</span>
              <el-input v-model="form.industry"></el-input>
            </div>
            <div class="item">
              <span>Location</span>
              <el-input v-model="form.location"></el-input>
            </div>
            <div class="item">
              <span>Email</span>
              <el-input v-model="form.email"></el-input>
            </div>
          </el-col>

          <el-col :span="12">
            <div class="item">
              <span>About our company</span>
              <el-input v-model="form.aboutCompany" type="textarea" :rows="12"></el-input>
            </div>
          </el-col>
        </el-row>
      </div>
    </el-form>
    <el-button type="primary" @click="onSubmit" class="submit">Submit</el-button>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        form: {
          avatarImageUrl: '',
          name: '',
          industry: '',
          location: '',
          email: '',
          aboutCompany: '',
        },
      }
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        console.log('beforeRouteEnter')
        vm.reloadData()
      })
    },
    computed: {
      id() {
        return this.$router.currentRoute.params.id
      },
    },
    methods: {
      async reloadData() {
        const data = await this.$http.get(`/employers/${this.id}`, {
          params: {},
        })
        this.form.name = data.company_name
        this.form.industry = data.industry
        this.form.location = data.location
        this.form.email = data.email
        this.form.aboutCompany = data.about
        this.form.avatarImageUrl = data.avatar
      },
      async onSubmit() {
        const id = this.id
        const data = await this.$http.post(`/employers/${id}`, {
          company_name: this.form.name,
          industry: this.form.industry,
          location: this.form.location,
          email: this.form.email,
          about: this.form.aboutCompany,
          avatar: this.form.avatarImageUrl,
        })
        this.$router.push(`/employers/${this.id}`)
      },
      handleAvatarSuccess(res, file) {
        this.form.avatarImageUrl = res.data.URL
      },
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .banner {
    width: 100%;
    padding-top: 80px;
    span {
      display: block;
      @include wcenter(300px);
      text-align: center;
      font-size: large;
    }
  }

  .avatar-uploader {
    margin-top: -50px;
    border-radius: 80px;
    cursor: pointer;
    position: relative;
    top: 80px;
    z-index: 2;
    @include wcenter(150px);
    @include lcenter(150px);
    background: #111;
    &:hover {
      background: #444;
    }
    .avatar {
      border-radius: 50%;
    }
  }

  .basic {
    background: $yellow;
    padding: 20px 10% 40px 10%;
    .item {
      height: 90px;
      span {
        padding-left: 10px;
        padding-bottom: 2px;
      }
    }
  }

  .profile-icon {
    font-size: 28px;
    color: #8c939d;
    width: 150px;
    height: 150px;
    line-height: 150px;
    text-align: center;
  }

  .submit {
    margin: 60px 0;
    @include wwcenter(140px);
    background: $blue;
    border: 0px;
    border-radius: 4px;

  }

</style>
