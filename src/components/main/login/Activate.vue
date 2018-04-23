<template>
  <div class="bg">
    <div class="activate">
      <div class="title">SHARE CREATORS</div>
      <p class="sub">Connect design pros from worldwide.</p>
      <div class="no-result" v-if="submission == false">
        <div class="content">
          <div>Please wait...</div>
        </div>
      </div>
      <div class="no-result" v-if="submission !== false">
        <div class="content">
          <div>Authentication expired or failed!</div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
  export default {
    components: {},
    data() {
      return {
        submission: false,
      }
    },
    computed: {
      id() {
        return this.$route.params.id
      },
      authKey() {
        return this.$route.params.authKey
      }
    },
    methods: {
      async submit() {
          console.log(this.id);
          console.log(this.authKey);
          try {
            const error = await this.$store.dispatch('activate', {
              id: this.id,
              authKey: this.authKey
            })

            console.log('heaven');

            if (error) {
              this.loading = false
              this.submission = true
            } else {
              this.$router.push(`/Login`)
            }

            // const id = this.$store.state.user.id
            // this.$router.push(`/Login`)
            // this.loading = false
            // this.submission = true
          } catch (_) {

            console.log('earth');
            this.loading = false
            this.submission = true
          }
      }
    },

    created: function (){
          console.log('hi');
          // console.log(authKey);
          this.submit();
    }
  }
</script>


<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .activate {
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



