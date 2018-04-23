<template>
  <div v-loading="title === null">
    <el-dialog title="Submit Proposal" :visible.sync="showProposal">
      <el-form :model="form">
        <el-form-item label="Proposal">
          <el-input type="textarea" :rows="5" v-model="form.proposal"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="showProposal = false">Cancel</el-button>
        <el-button type="primary" @click="submitProposal">Submit</el-button>
      </div>
    </el-dialog>

    <div class="title">
      <div class="goback">
        <router-link to="/jobs">
          <i class="el-icon-arrow-left"></i>
          Go Back to Jobs Board
        </router-link>
      </div>
      <div class="headlind">
        <p style="font-size: 4rem;">{{title}}</p>
        <p style="font-size: 2rem; line-height: 2.2rem;">{{subtitle}}</p>
      </div>
    </div>
    <div class="info">
      <div class="info-content">
        <div class="center-inner">
          <div class="item">
            <p>Company Name</p>
            <p>{{companyName}}</p>
          </div>
          <div class="item">
            <p>Company Location</p>
            <p>{{location}}</p>
          </div>
          <div class="item">
            <p>Category</p>
            <p>{{category}}</p>
          </div>
          <div class="item">
            <p>Required Skills</p>
            <p>
              <span v-for="item in skills">{{item}}</span>
            </p>
          </div>
          <div class="item">
            <p>Preference</p>
            <p>{{timeType}}</p>
          </div>
        </div>
      </div>
      <div class="info-content">
        <div class="center-inner">
          <div class="item">
            <p>Budget</p>
            <p>$ {{budget}}</p>
          </div>
          <div class="item">
            <p>Deadline</p>
            <p>{{deadline}}</p>
          </div>
          <div class="item">
            <p>Year of Experience Required</p>
            <p>{{experience? (experience + ' YRS') : '-'}}</p>
          </div>
          <div class="item">
            <p>Is The Project Confidential?</p>
            <p>{{isConfidential}}</p>
          </div>
          <div class="item">
            <p>Bonnus Points</p>
            <p>
              <span v-for="item in bonnusPoints">{{item}}</span>
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="additional-info">
      <p>What we need for this project? Additional Information/ Preference about the Design？Information about our company.</p>
      <div class="border">{{ info }}</div>
    </div>

    <div class="action-panel">
      <div v-if="$store.getters.isEmployer && isSelf">
        <el-button class="button" @click="$router.push(`/jobs/${$route.params.id}/edit`)">Edit Job</el-button>
        <el-button class="button" @click="showDeletePanel = true">Delete Job</el-button>
      </div>
      <div v-if="$store.getters.isArtist">
        <el-button class="button" @click="showProposal = true">Submit Proposal</el-button>
      </div>

      <el-dialog title="Are you sure to delete?" :visible.sync="showDeletePanel" width="40%">
        <span>You still could check applied artists list in your managment tool page.</span>
        <span slot="footer" class="dialog-footer">
          <el-button @click="showDeletePanel = false">Yes, delete.</el-button>
          <el-button @click="showDeletePanel = false">No, I want to keep it!</el-button>
        </span>
      </el-dialog>
    </div>
  </div>
</template>

<script>
  export default {
    components: {},
    async beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.title = null
        vm.subtitle = null
        vm.companyName = null
        vm.category = null
        vm.budget = null
        vm.skills = []
        vm.experience = null
        vm.deadline = null
        vm.location = null
        vm.companyName = null
        vm.isConfidential = null
        vm.bonnusPoints = null
        vm.info = null
        vm.userId = null
        vm.showProposal = false
        vm.showDeletePanel = false
        vm.timeType = null
        vm.form = {
          proposal: '',
        }
        vm.reloadData()
      })
      next()
    },
    data() {
      return {
        title: null,
        subtitle: null,
        companyName: null,
        category: null,
        budget: null,
        skills: [],
        experience: null,
        deadline: null,
        location: null,
        companyName: null,
        isConfidential: null,
        bonnusPoints: null,
        info: null,
        userId: null,
        timeType: null,

        showProposal: false,
        showDeletePanel: false,

        form: {
          proposal: '',
        },
      }
    },
    computed: {
      isSelf() {
        return this.userId
      }
    },
    methods: {
      async reloadData() {
        const data = await this.$http.get(`/jobs/${this.$route.params.id}`)
        this.title = `${data.category} Designer`
        this.subtitle = `${data.employer.company_name} looking for ${data.site} ${ data.time_type } ${ data.category } Designer`
        this.companyName = data.employer.company_name
        this.category = data.category
        this.budget = data.budget
        this.skills = data.skills
        this.experience = data.experience
        this.deadline = this.$moment(data.deadline).format('YYYY-MM-DD')
        this.location = data.location
        this.companyName = data.employer.company_name
        this.isConfidential = data.is_confidential
        this.bonnusPoints = data.bonus_points
        this.info = data.info
        this.userId = data.user_id,
        this.timeType = data.time_type
      },
      async deleteJob() {
        const data = await this.$http.post(`/jobs/${this.$route.params.id}`, {
          job_id: this.$route.params.id,
          content: this.form.proposal,
        })
        this.$message.success('Delete successfully')
        this.showProposal = false
      },
      async submitProposal() {
        const data = await this.$http.post('proposals', {
          job_id: this.$route.params.id,
          content: this.form.proposal,
        })
        this.$message.success('Submit successfully')
        this.$router.push(`/user/applied-jobs/${this.$route.params.id}`)
        this.showProposal = false
      },
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .title {
    background: $yellow;
    min-height: 300px;
    border: 1px solid $black;
    border-bottom: 2px solid $black;
    .goback {
      padding-left: 40px;
      padding-top: 20px;
      .el-icon-arrow-left {
        background: #000;
        color: #fff;
        border-radius: 50%;
        padding: 1px;
      }
    }
    .headlind {
      @include wcenter(1050px);
      line-height: 20px;
      font-weight: bold;
    }
  }

  .info {
    border: 1px solid $black;
    border-bottom: none;
    overflow: hidden;
    .info-content {
      overflow: hidden;
      width: 50%;
      float: left;
      box-sizing: border-box;
      padding: 40px 0;
      &:nth-child(1) {
        border-right: 3px solid $black;
      }
      .center-inner {
        padding-left: 30%;
        background-color: $white;
        .item {
          padding: 4px 0px 10px;
          p {
            margin: 10px 0;
          }
          p:nth-child(1) {
            font-size: 1.2rem;
            font-weight: 500;
          }
          p:nth-child(2) {
            font-size: 0.9rem;
            font-weight: 300;
            span {
              display: inline-block;
              padding: 4px 20px;
              background: #EFEFEF;
              margin: 5px;
              font-size: 0.9rem;
              border-radius: 5px;
            }
          }
        }
      }
    }

  }

  .additional-info {
    width: 100%;
    height: 320px;
    background: $ultramarine;
    padding: 40px 10%;
    box-sizing: border-box;
    p {
      font-size: 1.25rem;
      color: $white;
    }
    .border {
      border: 2px solid $black;
      border-radius: 4px;
      background: white;
      padding: 30px;
    }
  }

  .button {
    width: 180px;
    background: $yellow;
    border: 0px;
    border-radius: 0;
    margin: 0 40px;
    &:hover {
      color: $ultramarine;
    }
  }

  .action-panel {
    text-align: center;
    padding: 30px;
    /deep/ .el-dialog__wrapper {
      .el-dialog {
        height: 450px;
      }
      .el-dialog__header {
        padding-top: 80px;
      }
      .el-dialog__title {
        font-size: 1.25rem;
        font-weight: 900;
      }
      .el-dialog__body {
        padding: 10px 20% 20px;
        font-size: 0.9rem;
      }
      .el-dialog__footer {
        .el-button {
          display: block;
          margin: 0 auto;
          width: 50%;
          border-radius: 0;
          border: none;
          &:hover {
            color: $ultramarine;
          }
          &:nth-child(1) {
            background: #ddd;
            margin-bottom: 20px;
          }
          &:nth-child(2) {
            background: $yellow;
          }
        }
      }
    }
  }
</style>
