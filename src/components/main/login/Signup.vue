<template>
  <div class="bg">
    <div class="signup">
      <span>{{ error }}</span>
      <div class="title">SHARE CREATORS</div>
      <p class="sub">Connect design pros from worldwide.</p>
      <el-form v-if="submission == false" label-position="top" :model="form" :rules="rules" ref="form">
        <el-form-item label="Register As" prop="type">
          <el-select v-model="form.type" placeholder="Select Type">
            <el-option label="Company" value="employer"></el-option>
            <el-option label="Artist" value="artist"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item prop="username" label="Email">
          <el-input v-model="form.username"></el-input>
        </el-form-item>
        <el-form-item prop="password" label="Password">
          <el-input type="password" v-model="form.password" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item prop="confirmPassword" label="ConfirmPassword">
          <el-input type="password" v-model="form.confirmPassword" auto-complete="off"></el-input>
        </el-form-item>

        <el-form-item prop="submit">
          <el-button type="primary" @click="submit(form)" :disabled="!enabled" :loading="loading">Join Now</el-button>
        </el-form-item>
      </el-form>
      <div class="no-result" v-if="submission !== false">
        <div class="content">
          <div>Please check your email for verification link.</div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
  export default {
    components: {},
    data() {
      const validatePassword = (rule, value, callback) => {
        if (value.length <= 6) {
          callback(new Error('Password at least 6 charactors'))
        } else {
          callback()
        }
      }
      const validateConfirmPassword = (rule, value, callback) => {
        if (value !== this.form.password) {
          callback(new Error('Password not same'))
        } else {
          callback()
        }
      }
      return {
        isMounted: false,
        error: null,
        form: {
          type: 'employer',
          username: '',
          password: '',
          confirmPassword: '',
        },
        rules: {
          type: [
            { required: true, message: 'Pleae select type', trigger: 'blur,change' }
          ],
          username: [
            { required: true, message: 'Please input email', trigger: 'blur,change' },
            { type: 'email', message: 'Invalid email address', trigger: 'blur,change' }
          ],
          password: [
            { required: true, message: 'Please input password', trigger: 'blur,change' },
            { validator: validatePassword, trigger: 'blur,change' }
          ],
          confirmPassword: [
            { required: true, message: 'Please confirm password', trigger: 'blur,change' },
            { validator: validateConfirmPassword, trigger: 'blur,change' }
          ],
        },
        loading: false,
        submission: false,
      }
    },
    mounted() {
      this.isMounted = true;
    },
    computed: {
      enabled() {
        return this.form.type.length > 0 && this.form.username.length > 0 && this.form.password.length > 0 && this.form.confirmPassword.length > 0
      },
    },
    methods: {
      async submit() {
        const valid = await this.$refs.form.validate()
        if (valid) {
          this.error = null
          this.loading = true
          try {
            await this.$store.dispatch('signup', {
              type: this.form.type,
              username: this.form.username,
              password: this.form.password,
            })
            // const id = this.$store.state.user.id
            // this.$router.push(`/${this.form.type}s/${id}/edit`)
            this.submission = true
            this.loading = false
          } catch (_) {
            this.loading = false
          }
        }
      }
    }
  }
</script>


<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .signup {
    @include wcenter(420px);
    background: #fff;
    padding: 40px 40px;
    box-sizing: border-box;
    .title {
      font-size: 20px;
      text-align: center;
      span {
        display: block;
      }
    }
  }

  .bg {
    position: absolute;
    top: 0px;
    bottom: 0px;
    width: 100%;
    padding-top: 160px;
    background: #eee;
    z-index: 1;
    background-image: url('../../../assets/images/sign-background.jpg');
    background-size: cover;
  }

  .error {
    color: $error;
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
    /deep/ .el-select {
      width: 100%;
    }
    .el-button {
      background: $yellow;
      color: $black;
      height: 40px;
      display: block;
      width: 100%;
      border-radius: 0;
      border: none;
      margin-top: 20px;
      &.is-disabled {
        &:hover, &:active {
          background-color: $blue;
          color: $white;
        }
      }
    }
  }

</style>



