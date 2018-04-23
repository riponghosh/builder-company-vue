<template>
  <div class="bg">
    <div class="login">
      <span>{{ error }}</span>
      <div class="title">SHARE CREATORS</div>
      <p class="sub">Join us to work with pro freelance designers from all over the world!</p>
      <el-form label-position="top" :model="form" :rules="rules" ref="form">
        <el-form-item label="Email" prop="username">
          <el-input v-model="form.email"></el-input>
        </el-form-item>
        <el-form-item label="Password" prop="password">
          <el-input type="password" v-model="form.password"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="submit" :disabled="!enabled" :loading="loading">Login</el-button>
        </el-form-item>
      </el-form>
    </div>
  </div>
</template>

<script>
  export default {
    components: {},
    data() {
      return {
        loading: false,
        error: null,
        form: {
          email: '',
          password: '',
        },
        rules: {
          email: [
            { required: true, message: 'Please input email', trigger: 'blur,change' },
            { type: 'email', message: 'Invalid email address', trigger: 'blur,change' }
          ],
          password: [
            { required: true, message: 'Please input password', trigger: 'blur,change' }
          ]
        }
      }
    },
    computed: {
      enabled() {
        return this.form.email.length > 0 && this.form.password.length > 0
      },
    },
    methods: {
      async submit() {
        const valid = await this.$refs.form.validate()
        if (valid) {
          this.loading = true
          this.error = null
          try {
              this.form.email='admin';
              this.form.password='admin';
            const error = await this.$store.dispatch('login', {
              login:this.form,
            })

            if (error) {
              this.error = error
            } else {
              const type = this.$store.state.user.type
              const id = this.$store.state.user.id
              const data = await this.$http.get(`/${type}s/${id}`)
              if (data.first_name === null || data.company_name === null) {
                this.$router.push(`/${type}s/${id}/edit`)
              } else {
                this.$router.push('/user')
              }
            }
            this.loading = false
          } catch (_) {
            this.loading = false
          }
        }
      },
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .login {
    @include wcenter(420px);
    margin-top: 140px;
    background: #fff;
    padding: 40px 40px;
    box-sizing: border-box;
  }

  .bg {
    position: absolute;
    top: 0px;
    bottom: 0px;
    width: 100%;
    background: #eee;
    z-index: 1;
    background-image: url('../../../assets/images/sign-background.jpg');
    background-size: cover;
  }

  .title, .sub {
    text-align: center;
  }

  .title {
    font-size: 1.25rem;
    font-weight: 900;
  }

  .sub {
    color: #ddd;
    line-height: 24px;
  }

  .el-form {
    .el-form-item {
      margin-bottom: 10px;
    }
    /deep/ .el-input__inner {
      border-radius: 0;
    }
    /deep/ .el-form-item__label {
      padding: 0;
      line-height: 30px;
    }
    .el-button {
      background: $black;
      height: 40px;
      display: block;
      width: 100%;
      border-radius: 0;
      border: none;
      margin-top: 20px;
      &.is-disabled {
        &:hover, &:active {
          background-color: $blue;
        }
      }
    }
  }


</style>
