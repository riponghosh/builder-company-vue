<template>
  <div class="page-content">


<div class="space-6"></div>
<div class="col-sm-10 col-sm-offset-1">
    <div id="login-box" class="login-box visible widget-box no-border">
        <div class="widget-body">
            <div class="widget-main">
                

                <form name="loginForm" class="form-horizontal" :model="login" :rules="rules" ref="form" @submit.prevent='submit'>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="email"> Username </label>
                        <div class="col-sm-7">
                           <span class="block input-icon input-icon-right">
                                <input type="text" class="form-control" placeholder="Username" name="email" v-model="login.email" required focus/>
                                <i class="ace-icon fa fa-user"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="password"> Password </label>
                        <div class="col-sm-7">
                           <span class="block input-icon input-icon-right">
                                <input type="password" class="form-control" placeholder="Password" v-model="login.password" required/>
                                <i class="ace-icon fa fa-lock"></i>
                            </span>
                        </div>
                    </div>
                    <div class="space"></div>
                     <div class="clearfix">
                                                        <div class="row">
                         <label class="col-sm-3 control-label no-padding-right"> </label>
                        <div class="col-sm-7">
                            <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                <i class="ace-icon fa fa-key"></i>
                                Login
                            </button>
                                                            </div>
                        </div>
                    </div>
                        <div class="space-4"></div>
                <!-- <span class="lbl col-sm-3"> </span><div class="col-sm-7">Don't have an account? <a href="#/signup">Signup</a></div> -->
                </form>

                
                
            </div><!-- /widget-main -->

            
        </div><!-- /widget-body -->
    </div><!-- /login-box -->

</div><!-- /position-relative -->
</div>
</template>

<script>
  export default {
    components: {},
    data() {
      return {
        loading: false,
        error: null,
        login: {
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
        return this.login.email.length > 0 && this.login.password.length > 0
      },
    },
    methods: {
      async submit() {
        // const valid = await this.$refs.login.validate()
        if (1) {
          this.loading = true
          this.error = null
          try {
            const error = await this.$store.dispatch('login', {
              customer:this.login,
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

