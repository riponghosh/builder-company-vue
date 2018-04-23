<template>
  <el-form ref="form" :model="form" label-width="80px" label-position="top">
    <el-row class="section-1">
      <el-col :span="8">
        <el-form-item>
          <el-select v-model="form.site" placeholder="Localtion Preference">
            <el-option v-for="item in site" :key="item.value" :label="item.label" :value="item.value"></el-option>
          </el-select>
        </el-form-item>
      </el-col>
      <el-col :span="8">
        <el-form-item>
          <el-select v-model="form.timeType" placeholder="Job Type">
            <el-option v-for="item in jobTypes" :key="item.value" :label="item.label" :value="item.value"></el-option>
          </el-select>
        </el-form-item>
      </el-col>
      <el-col :span="8">
        <el-form-item>
          <el-select v-model="form.category" placeholder="Category">
            <el-option v-for="item in categories" :key="item.value" :label="item.label" :value="item.label"></el-option>
          </el-select>
        </el-form-item>
      </el-col>
    </el-row>
    <el-row class="section-2">
      <el-col :span="12" style="padding-right: 10%;">
        <div style="font-size: 1.25rem; font-weight: 500;">Basic</div>
        <el-form-item label="Job Name">
          <el-input v-model="form.name"></el-input>
        </el-form-item>
        <el-form-item label="Job Location">
          <el-input v-model="form.location"></el-input>
        </el-form-item>
        <el-form-item label="Year of Experience Required">
          <el-select v-model="form.experience">
            <el-option v-for="item in experience" :key="item.value" :label="item.label" :value="item.value"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="Skills Required (Up to 6 Skills)">
          <el-select v-model="form.skills" multiple :multiple-limit="6">
            <el-option v-for="item in skills" :key="item.value" :label="item.label" :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="Budget (Fixed Price)">
          <el-input type="number" v-model="form.pricePerHour"></el-input>
        </el-form-item>
        <el-form-item label="Deadline Date">
          <el-date-picker v-model="form.deadline" type="date"></el-date-picker>
        </el-form-item>
      </el-col>
      <el-col :span="12">
        <div></div>
      </el-col>
    </el-row>

    <div class="section-3">
      <el-row>
        <el-col :span="12" style="padding-right: 10%;">
          <div style="font-size: 1.25rem; font-weight: 500">Optional</div>
          <el-form-item label="Keep Your Company Name Confidential in the Job Post?">
            <el-select v-model="form.isConfidential">
              <el-option label="YES" :value="true"></el-option>
              <el-option label="NO" :value="false"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="Bonus Point (Up to 3 points, seperated by comma)">
            <el-input v-model="form.bonnusPoints"></el-input>
          </el-form-item>
          <el-form-item label="About Company / Company Link">
            <el-input v-model="form.aboutCompany"></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <div style="font-size: 1.25rem; font-weight: 500">
            <div>How to find the best designer within 24 hours?</div>
            <div>Our statistic data my help you!</div>
          </div>
          <ol style="padding-left: 1em; font-size: 0.9rem; line-height: 1.5rem;">
            <li>Add Clear Project Name.</li>
            <li>Add skills tag that you need for the project, we will help you match the designers you need.</li>
            <li>Add Clear budgets, we will help you match different experienced level designers.</li>
            <li>Industry experiences is directly correlated with the price. Base on your budget, and our price suggestion data, you could find a suitable designer.</li>
            <li>You are able to ask designers to fix the design 3 times by default setting. If you would like to add review times, please have an agreement with the designer, or add extra budget to the project.</li>
            <li>Employer must deposit the design fee to our website. If you didn’t find a suitable designer, you would receive the full refund with no charge.</li>
            <li>When designers finished the first review, they would receive 30% of the design. After the second review, designers would receive 60% of the design fee. The third review, and 90% of the design. After employer provides the rating, designers would receive the whole design fee.</li>
          </ol>
        </el-col>
      </el-row>
      <div style="margin-top: 40px">
        <el-form-item label="What we need for this project? Additional Information/ Preference about the Design？Information about our company.">
          <el-input v-model="form.whatWeNeed" type="textarea" :rows="4"></el-input>
        </el-form-item>
      </div>
    </div>
    <div class="submit-btn">
      <el-button type="primary" @click="submit" class="btn">Post To Find Pros</el-button>
    </div>
  </el-form>
</template>

<script>
  import moment from 'moment'

  export default {
    data() {
      return {
        form: {
          site: '',
          timeType: '',
          category: '',

          name: '',
          location: '',
          experience: '',
          skills: '',
          pricePerHour: '',
          deadline: '',

          isConfidential: '',
          bonnusPoints: '',
          aboutCompany: '',
          whatWeNeed: '',
        },
      }
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        if (vm.id) {
          vm.reloadData()
        }
      })
    },
    computed: {
      id() {
        return this.$route.params.id
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
        const data = await this.$http.get(`/jobs/${this.id}`)
        this.form.site = data.site
        this.form.timeType = data.time_type
        this.form.category = data.category

        this.form.name = data.project_name
        this.form.location = data.location
        this.form.experience = data.experience
        this.form.skills = data.skills
        this.form.pricePerHour = data.budget
        this.form.deadline = data.deadline

        this.form.isConfidential = data.is_confidential
        this.form.bonnusPoints = data.bonus_points.join(',')
        this.form.aboutCompany = data.about_company
        this.form.whatWeNeed = data.info
      },
      async submit() {
        const postBody = {
          'site': this.form.site,
          'time_type': this.form.timeType,
          'category': this.form.category,

          'project_name': this.form.name,
          'location': this.form.location,
          'experience': this.form.experience,
          'skills': this.form.skills,
          'budget': this.form.pricePerHour,
          'deadline': this.form.deadline,

          'is_confidential': this.form.isConfidential,
          "bonus_points": this.form.bonnusPoints.split(','),
          'about_company': this.form.aboutCompany,
          'info': this.form.whatWeNeed,

          'images': [],
        }
        console.log(postBody)
        const data = await this.$http.post(`/jobs${this.id ? '/' + this.id : ''}`, postBody)
        this.$message.success('Submit successfully')
        Object.keys(this.form).forEach((key) => {
          this.form[key] = ''
        })
        this.$router.push(`/jobs/${data.id}`)
      },
      handleAvatarSuccess(res, file) {
        this.profileImageUrl = URL.createObjectURL(file.raw);
      },
      beforeAvatarUpload(file) {
        const isJPG = file.type === 'image/jpeg';
        const isLt2M = file.size / 1024 / 1024 < 2;

        if (!isJPG) {
          this.$message.error('上传头像图片只能是 JPG 格式!');
        }
        if (!isLt2M) {
          this.$message.error('上传头像图片大小不能超过 2MB!');
        }
        return isJPG && isLt2M;
      }
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .section-1 {
    .el-col {
      border: 2px solid $black;
      &:nth-child(1) {
        background: $ultramarine;
        /deep/ input {
          background-color: $white;
          color: $black;
        }
      }
      &:nth-child(2) {
        background: $white;
        border-left-width: 0;
      }
      &:nth-child(3) {
        background: $yellow;
        border-left-width: 0;
      }
    }
    .el-form-item {
      text-align: center;
      padding: 0;
      margin: 50px auto;
      height: 40px;
      width: 70%;
    }
    .el-select {
      width: 100%;
    }
    /deep/ input {
      border-radius: 20px;
      border: none;
      text-align: center;
      background-color: $ultramarine;
      color: $white;
      font-weight: 500;
    }
    /deep/ .el-input__suffix {
      left: 10%;
      right: auto;
    }
  }

  .section-2, .section-3 {
    padding: 40px 10%;
    .el-form-item {
      margin-bottom: 10px;
      /deep/ {
        .el-form-item__label {
          padding: 0;
        }
        .el-select {
          width: 100%;
          .el-tag {
            background-color: #EFEFEF;
            color: $black;
            border-radius: 20px;
          }
          .el-tag__close {
            background: none;
            color: $black;
          }
        }
        .el-form-item__label {
          color: $black;
        }
      }
    }
  }

  .section-2 {
    .el-col:nth-child(2) {
      padding-top: 10%;
      div {
        width: 100%;
        padding-top: calc(100% * 2 / 3);
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-image: url('../../../assets/images/bg_job_edit.jpg');
      }
    }
  }

  .section-3 {
    background: #EFEFEF;
    /deep/ textarea {
      height: 200px;
    }
  }

  .submit-btn {
    text-align: center;
    margin: 40px 0;
    .btn {
      border: 0;
      border-radius: 0;
      width: 180px;
      background: $yellow;
      color: $black;
      &:hover {
        color: $ultramarine;
      }
    }
  }


</style>
