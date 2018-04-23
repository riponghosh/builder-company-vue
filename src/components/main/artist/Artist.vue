<template>
  <div v-loading="userId === null">
    <el-row style="border: 3px black solid">
      <el-col :span="6">
        <div class="pic">
          <div class="goback">
            <router-link to="/artists">
              <i class="el-icon-arrow-left"></i>
              Go Back to Artists List
            </router-link>
          </div>
          <div class="img" :style="{'background-image': 'url('+ avatar+')'}"></div>
          <div style="font-size: 1.25rem; font-weight:500;">{{lastName}} {{firstName}}</div>
          <div style="font-size: 0.9rem;">
            <i class="el-icon-location-outline" style="margin-right: 5px;"></i>{{location}}
          </div>
          <div v-if="isSelf" style="font-size: 0.9rem;">
            <router-link :to="`/artists/${id}/edit`">Profile Setting</router-link>
          </div>
          <div>
            <el-button @click="invite">Invite To Apply The Job</el-button>
            <el-button @click="mark" v-if="$store.getters.isEmployer">
              <span v-if="isBookmarked">Remove Bookmark</span>
              <span else>Bookmark</span>
            </el-button>
            <el-button>All Bookmarked Artists</el-button>
          </div>
          <el-row :gutter="40" class="share">
            <el-col :span="6">
              <el-button type="text">
                <img src="~@/assets/images/share-facebook.png" alt="Facebook">
              </el-button>
            </el-col>
            <el-col :span="6">
              <el-button type="text">
                <img src="~@/assets/images/share-twitter.png" alt="Facebook">
              </el-button>
            </el-col>
            <el-col :span="6">
              <el-button type="text">
                <img src="~@/assets/images/share-pinterest.png" alt="Facebook">
              </el-button>
            </el-col>
            <el-col :span="6">
              <el-button type="text">
                <img src="~@/assets/images/share-linkin.png" alt="Facebook">
              </el-button>
            </el-col>
          </el-row>
        </div>
      </el-col>
      <el-col :span="18" style="border-left: 3px black solid; min-height: 560px;">
        <el-row class="label">
          <el-col :span="6" style="text-align: center;">
            <div style="height: 40px; padding-top: 10px; width: 130px; margin: auto;">
              <rate :value="rating"></rate>
            </div>
            <div>Rating</div>
          </el-col>
          <el-col :span="6">
            <div>{{priceRange || '$$'}}</div>
            <div>Price Range</div>
          </el-col>
          <el-col :span="6">
            <div>${{hourlyRate || '-'}}/hr</div>
            <div>Hourly Rate</div>
          </el-col>
          <el-col :span="6">
            <div>{{experience || '-'}}</div>
            <div>Experience</div>
          </el-col>
        </el-row>

        <el-row class="main-info">
          <el-row>
            <p style="font-weight: bold; font-size: 1.2rem;">{{categories.join(' / ')}}</p>
          </el-row>
          <el-row>
            <el-col :span="8">
              <p>Skills</p>
              <p>
                <span v-for='item in skills' :key="item.replace(/\s/g,'-')">{{item}}</span>
              </p>
            </el-col>
            <el-col :span="8">
              <p>Preference (Job Type)</p>
              <p>
                <span>
                  {{jobTypes}}
                </span>
              </p>
            </el-col>
            <el-col :span="8">
              <p>Preference (Location)</p>
              <p>
                <span>
                  {{site || 'Off-Site'}}
                </span>
              </p>
            </el-col>
          </el-row>
          <el-row>
            <p>Clients</p>
            <p>
              {{clients || 'Kindle, P&G'}}
            </p>
          </el-row>
        </el-row>

        <el-row class="other" :gutter="30">
          <el-col :span="12">
            <p>Work History</p>
            <div class="other-content" v-for="item in works">
              <p>{{item.where + ((item.where && item.what) ? ', ' : '') + item.what}}</p>
              <p>{{item.when}}</p>
            </div>
          </el-col>
          <el-col :span="12">
            <div>
              <p>Education</p>
              <div class="other-content" v-for="item in educations">
                <p>{{item.where + ((item.where && item.what) ? ', ' : '') + item.what}}</p>
                <p>{{item.when}}</p>
              </div>
            </div>
            <p class="line"></p>
            <div>
              <p>Awards</p>
              <div class="other-content" v-for="item in awards">
                <p>{{item.when + ((item.when && item.what) ? ' ' : '') + item.what + ((item.where && item.what) ? ', ' : '') + item.where}}</p>
              </div>
            </div>
          </el-col>
        </el-row>
      </el-col>
    </el-row>

    <div style="margin: 30px;">
      <span style="background: black;color:white;padding: 3px 6px;">Portfolio</span>
      <el-row class="portfolio-border">
        <el-col v-for="(i, index) in portfolios" :span="8" :key="`potofolio-${index}`">
          <img :src="i.url" alt="">
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script>
  import JobRow from '../job/JobRow.vue'
  import Rate from '@/components/common/Rate'
  import moment from 'moment'

  export default {
    data() {
      return {
        userId: null,
        avatar: null,
        email: null,
        firstName: null,
        lastName: null,
        location: null,
        bio: null,
        phoneNumber: null,

        status: null,
        timeAvailable: null,
        rating: null,
        priceRange: null,
        hourlyRate: null,
        experience: null,

        categories: [],
        skills: [],
        site: null,
        jobTypes: null,
        clients: null,
        portfolios: [],

        works: [],
        educations: [],
        awards: [],
      }
    },
    components: {
      JobRow,
      Rate,
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.userId = null
        vm.avatar = null
        vm.email = null
        vm.firstName = null
        vm.lastName = null
        vm.location = null
        vm.bio = null
        vm.phoneNumber = null
        vm.status = null
        vm.timeAvailable = null
        vm.rating = null
        vm.priceRange = null
        vm.hourlyRate = null
        vm.experience = null
        vm.categories = []
        vm.skills = []
        vm.site = null
        vm.jobTypes = null
        vm.clients = null
        vm.works = []
        vm.educations = []
        vm.awards = []

        vm.reloadData()
      })
    },
    computed: {
      id() {
        return this.$route.params.id
      },
      isSelf() {
        return this.$store.state.user.id === this.id
      },
      isBookmarked() {
        return this.$store.state.user.savedArtists.find(i => i.id === this.id)
      },
    },
    methods: {
      async reloadData() {
        const id = this.id
        const data = await this.$http.get(`/artists/${id}`)
        this.userId = data.user_id
        this.avatar = data.avatar
        this.email = data.email
        this.firstName = data.first_name
        this.lastName = data.last_name
        this.location = data.location
        this.bio = data.bio
        this.phoneNumber = data.phone_number

        this.status = data.status
        this.timeAvailale = data.time_availale
        this.rating = data.rating
        this.priceRange = data.price_range
        this.hourlyRate = data.hourly_rate
        this.experience = data.experience

        this.categories = data.categories
        this.skills = data.skills
        this.site = data.site
        this.jobTypes = data.job_types
        this.clients = data.clients
        this.portfolios = data.portfolios

        this.works = data.experiences.filter((e) => {
          return e.type === 'work'
        }).map((e) => {
          let _from = e.when.split('-')[0]
          let _to = e.when.split('-')[1]
          let from = _from ? moment(_from).format('MMM YYYY') : ''
          let to = _to ? moment(_to).format('MMM YYYY') : ''
          return {
            type: e.type,
            what: e.what,
            when: from + ' - ' + to,
            where: e.where
          }
        })
        this.educations = data.experiences.filter((e) => {
          return e.type === 'education'
        }).map((e) => {
          let _from = e.when.split('-')[0]
          let _to = e.when.split('-')[1]
          let from = _from ? moment(_from).format('MMM YYYY') : ''
          let to = _to ? moment(_to).format('MMM YYYY') : ''
          return {
            type: e.type,
            what: e.what,
            when: from + ' - ' + to,
            where: e.where
          }
        })
        this.awards = data.experiences.filter((e) => {
          return e.type === 'award'
        }).map((e) => {
          let _from = e.when.split('-')[0]
          let from = _from ? moment(_from).format('MMM YYYY') : ''
          return {
            type: e.type,
            what: e.what,
            when: from,
            where: e.where
          }
        })

      },
      invite() {
        this.$confirm('Do you want to invite him/her to apply for your job?', 'Invite', {
          confirmButtonText: 'Yes',
          cancelButtonText: 'Cancel',
          type: 'warning'
        }).then(() => {
          this.$message({
            type: 'success',
            message: 'Invitation sent successfully'
          });
        })
      },
      async mark() {
        if (this.isBookmarked) {
          const result = await this.$http.get(`/saved-artists/${this.id}/delete`)
          this.$message.success('Remove bookmark successfully')
        } else {
          const result = await this.$http.get(`/saved-artists/${this.id}/save`)
          this.$message.success('Bookmark successfully')
        }
        this.$store.dispatch('updateSideBar')
      }
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .pic {
    padding: 40px 0;
    position: relative;
    width: 80%;
    margin: 0 auto;
    .img {
      @include adaptedSquaredImg(160px);
      border-radius: 50%;
    }
    div {
      margin: 10px auto;
      text-align: center;
    }
    .goback {
      position: absolute;
      top: 0;
      left: -5%;
      a {
        color: $black;
        font-size: 1.2rem;
        font-weight: bold;
      }
      .el-icon-arrow-left {
        background: $black;
        color: #fff;
        border-radius: 50%;
        padding: 3px;
        margin-right: 5px;
      }
    }
    .el-button {
      display: block;
      margin: 12px 0;
      padding: 18px 0;
      width: 100%;
      border-radius: 2px;
      color: $white;
      background-color: $black;
      border: none;
      font-size: 0.8rem;
      &:nth-child(1) {
        color: $black;
        background-color: $yellow;
      }
      &:nth-child(2) {
        background-color: $ultramarine;
      }
    }
    .share .el-button {
      background-color: transparent;
      padding: 0;
      margin: 0;
    }
  }

  .label {
    border-bottom: 1px solid $black;
    height: 80px;
    background: $yellow;
    color: $black;
    text-align: center;
    .el-col div {
      &:nth-child(1) {
        line-height: 50px;
        font-size: 1.4rem;
        font-weight: 500;
      }
      &:nth-child(2) {
        font-size: 0.9rem;
      }
    }
    /deep/ .el-rate {
      padding: 4px;
      height: auto;
      display: flex;
      justify-content: space-around;
      /deep/ .el-rate__icon {
        margin: 0 0 10px;
        font-size: 1.4rem;
        &::before {
          color: $black;
        }
        &.el-icon-star-on::before {
          content: '\E637';
          color: $black;
        }
      }
    }
  }

  .main-info {
    padding: 20px 40px 10px;
    border-bottom: 1px solid $black;
    .el-row {
      margin-bottom: 20px;
      p {
        margin: 0;
        span {
          display: inline-block;
          padding: 4px 20px;
          background: #EFEFEF;
          margin: 5px;
          font-size: 0.8rem;
          border-radius: 5px;
        }
        &:nth-child(1) {
          margin-bottom: 5px;
        }
        &:nth-child(2) {
          font-size: 0.9rem;
        }
      }
    }
  }

  .other {
    padding: 20px 40px 10px;
    .line {
      border-bottom: 1px solid $black;
      margin: 40px 40px 40px 0;
    }
    .other-content {
      margin-bottom: 20px;
      p {
        margin: 5px 0;
        font-size: 0.9rem;
      }
    }
  }

  .portfolio-border {
    border: 10px black solid;
    img {
      object-fit: cover;
      width: 100%;
      height: 400px;
      border: 10px solid black;
    }
  }

</style>
