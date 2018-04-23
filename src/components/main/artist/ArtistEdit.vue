<template>
  <div style="padding: 40px 10%">
    <el-form ref="form" :model="form" label-width="80px" label-position="top">
      <p class="title">Basics</p>
      <el-row>
        <el-col :span="8">
          <el-upload
            class="avatar-uploader"
            action="/api/storage/upload"
            :show-file-list="false"
            :on-success="handleAvatarSuccess">
            <img v-if="form.avatar" :src="form.avatar" class="avatar" width="150" height="150">
            <i v-else class="el-icon-plus profile-icon"></i>
          </el-upload>
        </el-col>
        <el-col :span="16">
          <el-row :gutter="40">
            <el-col :span="12">
              <el-form-item label="First Name">
                <el-input v-model="form.firsName"></el-input>
              </el-form-item>
              <el-form-item label="Last Name">
                <el-input v-model="form.lastName"></el-input>
              </el-form-item>
              <el-form-item label="Location">
                <el-input v-model="form.location"></el-input>
              </el-form-item>
              <el-form-item label="Previous Clients">
                <el-input v-model="form.clients"></el-input>
              </el-form-item>
              <!-- <el-form-item label="Availability">
                <el-input v-model="form.availability"></el-input>
              </el-form-item> -->
            </el-col>
            <el-col :span="12">
              <el-form-item label="Year of Experience">
                <el-select v-model="form.experience">
                  <el-option v-for="item in experience" :key="item.value" :label="item.label" :value="item.value"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item label="Hourly Rate $">
                <el-input v-model="form.hourlyRate"></el-input>
              </el-form-item>
              <el-form-item label="Preference (Job Type)">
                <el-select v-model="form.jobTypes">
                  <el-option v-for="item in jobTypes" :key="item.value" :label="item.label" :value="item.value"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item label="Preference ( Location )">
                <el-select v-model="form.site">
                  <el-option v-for="item in site" :key="item.value" :label="item.label" :value="item.value"></el-option>
                </el-select>
              </el-form-item>

            </el-col>
          </el-row>
          <el-form-item label="Work Categories ( Up to 3 Tags )">
            <el-select v-model="form.categories" multiple :multiple-limit="3">
              <el-option v-for="item in categories" :key="item.value" :label="item.label" :value="item.label">
              </el-option>
            </el-select>
          </el-form-item>
          <el-row>
          </el-row>
          <el-form-item label="Skills ( Up to 6 Tags )">
            <el-select v-model="form.skills" multiple :multiple-limit="6">
              <el-option v-for="item in skills" :key="item.value" :label="item.label" :value="item.value">
              </el-option>
            </el-select>
          </el-form-item>
          <el-row>
          </el-row>
          <el-row>
            <el-form-item label="Bio">
              <el-input type="textarea" v-model="form.bio" class="bio"></el-input>
            </el-form-item>
          </el-row>
        </el-col>
      </el-row>
      <el-row class="line"></el-row>
      <p class="title">Work History</p>
      <el-row :gutter="40" v-for="(work, index) in form.work" :key="`work-${index}`">
        <el-col :span="8">
          <el-form-item label="Employer">
            <el-input v-model="work.where"></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="8">
          <el-form-item label="Job Title">
            <el-input v-model="work.what"></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="6">
          <el-form-item label="Time">
            <el-date-picker
              v-model="work.when"
              type="daterange"
              range-separator="-"
              unlink-panels
              start-placeholder="From"
              end-placeholder="To">
            </el-date-picker>
          </el-form-item>
        </el-col>
        <el-col :span="2">
          <el-button size="small" @click="addOne(work)">+</el-button>
          <el-button size="small" @click="subtractOne(work)">-</el-button>
        </el-col>
      </el-row>
      <p class="title">Education</p>
      <el-row :gutter="40" v-for="(education ,index) in form.education" :key="`edu-${index}`">
        <el-col :span="8">
          <el-form-item label="School">
            <el-input v-model="education.where"></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="8">
          <el-form-item label="Major">
            <el-input v-model="education.what"></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="6">
          <el-form-item label="Time">
            <el-date-picker
              v-model="education.when"
              type="daterange"
              range-separator="-"
              unlink-panels
              start-placeholder="From"
              end-placeholder="To">
            </el-date-picker>
          </el-form-item>
        </el-col>
        <el-col :span="2">
          <el-button size="small" @click="addOne(education)">+</el-button>
          <el-button size="small" @click="subtractOne(education)">-</el-button>
        </el-col>
      </el-row>
      <p class="title">Awards</p>
      <el-row :gutter="40" v-for="(award, index) in form.award" :key="`award-${index}`">
        <el-col :span="8">
          <el-form-item label="Name">
            <el-input v-model="award.where"></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="8">
          <el-form-item label="Prize">
            <el-input v-model="award.what"></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="6">
          <el-form-item label="Time">
            <el-date-picker
              v-model="award.when"
              type="daterange"
              range-separator="-"
              unlink-panels
              start-placeholder="From"
              end-placeholder="To">
            </el-date-picker>
          </el-form-item>
        </el-col>
        <el-col :span="2">
          <el-button size="small" @click="addOne(award)">+</el-button>
          <el-button size="small" @click="subtractOne(award)">-</el-button>
        </el-col>
      </el-row>
      <el-row class="line"></el-row>
      <p class="title">Upload Your Portfolios </p>
      <el-row>
        <el-upload
          action="/api/storage/upload"
          list-type="picture-card"
          :file-list="form.portfolios"
          :on-success="handlePortfolioSuccess"
          :on-preview="handlePictureCardPreview"
          :on-remove="handleRemove">
          <i class="el-icon-plus"></i>
        </el-upload>
        <el-dialog :visible.sync="dialogVisible">
          <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>
      </el-row>
      <el-row class="line"></el-row>
      <el-row>
        <el-button type="primary" @click="onSubmit" class="btn">Submit</el-button>
      </el-row>
    </el-form>
  </div>
</template>

<script>
  import ElRow from "element-ui/packages/row/src/row";
  import moment from 'moment'
  import { mapGetters } from 'vuex'

  export default {
    components: { ElRow },
    data() {
      return {
        dialogImageUrl: '',
        dialogVisible: false,
        form: {
          avatar: '',
          firsName: '',
          lastName: '',
          location: '',
          // availability: '',
          bio: '',
          experience: '',
          clients: '',
          site: '',
          work: [{ type: '', where: '', what: '', when: '' }],
          education: [{ type: '', where: '', what: '', when: '' }],
          award: [{ type: '', where: '', what: '', when: '' }],
          skills: [],
          categories: [],
          portfolios: [],
          hourlyRate: '',
          jobTypes: '',

        },
      }
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.reloadData()
      })
    },
    computed: {
      id() {
        return this.$router.currentRoute.params.id
      },
      categories() {
        return this.$store.state.config.category
      },
      experience() {
        return this.$store.state.config.experience
      },
      skills() {
        return this.$store.state.config.skills
      },
      site() {
        return this.$store.state.config.site
      },
      jobTypes() {
        return this.$store.state.config.jobTypes
      },
    },
    methods: {
      async reloadData() {
        const data = await this.$http.get(`/artists/${this.id}`, {
          params: {},
        })
        let experiences = data.experiences.map((e) => {
          if (e.when) {
            let from = moment(e.when.split('-')[0]).toDate()
            let to = moment(e.when.split('-')[1]).toDate()
            e.when = [from, to]
          }
          return e;
        })

        let _work = data.experiences.filter((e) => {
          return e.type === 'work'
        })
        let _education = data.experiences.filter((e) => {
          return e.type === 'education'
        })
        let _award = data.experiences.filter((e) => {
          return e.type === 'award'
        })

        this.form.userId = data.user_id
        this.form.avatar = data.avatar
        this.form.firsName = data.first_name
        this.form.lastName = data.last_name
        this.form.location = data.location
        // this.form.availability = data.availability
        this.form.clients = data.clients
        this.form.bio = data.bio
        this.form.skills = data.skills.map(i => {
          return i
        })
        this.form.experience = data.experience
        this.form.site = data.site
        this.form.work = _work.length ? _work : [{ type: 'work', where: '', what: '', when: '' }]
        this.form.education = _education.length ? _education : [{ type: 'education', where: '', what: '', when: '' }]
        this.form.award = _award.length ? _award : [{ type: 'award', where: '', what: '', when: '' }]
        this.form.hourlyRate = data.hourly_rate,
          this.form.jobTypes = data.job_types,
          this.form.categories = data.categories.map(i => {
            return i
          }),
          this.form.portfolios = data.portfolios
      },

      async onSubmit() {
        let _experiences = this.form.work.concat(this.form.education, this.form.award)
        let experiences = _experiences.map((e) => {
          if (e.when.length) {
            let from = moment(e.when[0]).format('YYYY.MM.DD')
            let to = moment(e.when[1]).format('YYYY.MM.DD')
            e.when = from + '-' + to
          }
          return e
        })

        let postBody = {
          user_id: this.form.userId,
          avatar: this.form.avatar,
          first_name: this.form.firsName,
          last_name: this.form.lastName,
          location: this.form.location,
          // availability: this.form.availability,
          bio: this.form.bio,
          skills: this.form.skills,
          experience: this.form.experience,
          clients: this.form.clients,
          site: this.form.site,
          experiences: experiences,
          hourly_rate: this.form.hourlyRate,
          job_types: this.form.jobTypes,
          categories: this.form.categories,
          portfolios: this.form.portfolios
        }

        const data = await this.$http.post(`/artists${this.id ? '/' + this.id : ''}`, postBody)
        this.$message.success('Submit successfully')
        this.$router.push(`/artists/${this.id}`)
      },

      handleAvatarSuccess(res, file) {
        this.form.avatar = res.data.URL
      },
      handlePortfolioSuccess(res, file) {
        let portfolio = {
          name: file.name,
          url: res.data.URL
        }
        this.form.portfolios.push(portfolio)
      },
      handleRemove(file, fileList) {
        this.form.portfolios = fileList
      },
      handlePictureCardPreview(file) {
        this.dialogImageUrl = file.url;
        this.dialogVisible = true;
      },

      addOne(experience) {
        let _experience = {
          type: experience.type,
          where: '',
          what: '',
          when: ''
        }
        let experiences = this.form[experience.type]
        let index = experiences.indexOf(experience)
        if (index > -1) {
          experiences.splice(index + 1, 0, _experience);
        }
      },

      subtractOne(experience) {
        let experiences = this.form[experience.type]
        if (experiences.length > 1) {
          let index = experiences.indexOf(experience)
          if (index > -1) {
            experiences.splice(index, 1);
          }
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .title {
    font-size: 1.25rem;
    font-weight: 500;
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
    text-align: center;
    background: #111;
    &:hover {
      background: #444;
    }
    .avatar {
      border-radius: 50%;
    }
    i {
      color: white;
      font-size: 30px;
    }
  }

  .bio /deep/ .el-textarea__inner {
    height: 100px;
    vertical-align: top;
  }

  .el-form /deep/ {
    .el-form-item__label {
      padding: 0;
      line-height: 30px;
    }
    .el-form-item {
      margin-bottom: 15px;
    }
    .el-input input, textarea, .el-date-editor {
      border-radius: 0;
    }
    .el-select {
      display: block;
      .el-tag {
        background-color: #eee;
        border-radius: 20px;
      }
    }
    .el-date-editor {
      width: 100%;
    }
    .el-button--small {
      width: 30px;
      height: 30px;
      line-height: 30px;
      padding: 0;
      border-radius: 50%;
    }
    .el-col-2 {
      padding-top: 32px;
      padding-left: 0 !important;
      padding-right: 0 !important;
    }
  }

  .line {
    border-bottom: 1px solid #eee;
    margin: 40px -6%;
  }

  .exp, .connect {
    background: $blue;
    padding: 20px 120px;
    ul {
      padding: 0px 0px 20px 0px;
    }
    li {
      float: left;
      margin-right: 5%;
      span {
        padding-right: 18px;
      }
      button {
        background: #000;
        border: 0px;
        color: #fff;
        padding: 6px 40px;
      }
    }
  }

  .portfolio {
    padding: 20px 120px;
    overflow: hidden;
    ul {
      padding-left: 0px;
      margin-right: -40px;
      li {
        img {
          display: block;
          width: 100%;
          height: 300px;
          background: #ccc;
        }
      }
    }
  }

  .pb_80 {
    padding-bottom: 80px;
  }

  .p_20 {
    padding: 0px 20px;
  }

  .cl {
    overflow: hidden;
  }

  .btn {
    @include wwcenter(140px);
    background: $blue;
    border: 0px;
    border-radius: 4px;

  }

  /*.avatar {*/
  /*width: 178px;*/
  /*height: 178px;*/
  /*display: block;*/
  /*}*/
</style>
