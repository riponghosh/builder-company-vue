<template>
  <div>
    <category-bar></category-bar>
    <div class="inner">
      <div class="query-panel">
        <div class="panel-info">
          Jobs Board
          <div class="bg"></div>
        </div>
        <div class="panel-sort">
          <el-input v-model="query.search" placeholder="Search job name" style="width: 200px"></el-input>
          <el-dropdown trigger="click">
            <el-button type="primary" class="btn">
              Filter<i class="el-icon-caret-bottom"></i>
            </el-button>
            <el-dropdown-menu slot="dropdown">
              <div class="dropdown-content">
                <el-row style="margin: 10px -15px;">
                  <el-col :span="20">
                    <el-button @click="clearFilter">Clear All</el-button>
                  </el-col>
                  <el-col :span="4">
                    <el-button icon="el-icon-close"></el-button>
                  </el-col>
                </el-row>
                <el-row :gutter=80 style="width: 540px">
                  <el-col :span="12">
                    <el-row class="title">Budget</el-row>
                    <el-row>
                      <el-slider
                        v-model="query.budget"
                        range
                        :min="0"
                        :max="4"
                        :show-tooltip="false"
                        show-stops>
                      </el-slider>
                    </el-row>
                    <el-row style="font-size: 0.8rem; margin: 0 -20px;">
                      <el-col :span="5">$ 0K</el-col>
                      <el-col :span="5">$ 3K</el-col>
                      <el-col :span="5">$ 5K</el-col>
                      <el-col :span="4">$ 10K</el-col>
                      <el-col :span="5" style="text-align: right;">$ 10K+</el-col>
                    </el-row>
                    <el-row class="title">Rating</el-row>
                    <el-row>
                      <el-checkbox-group v-model="query.rating">
                        <el-checkbox :label="i" v-for="i in [1,2,3,4,5]" :key="`rating-${i}`" style="display: block;">
                          <i class="el-icon-star-on" v-for="(_, j) in Array(i)" :key="`rating-star-${j}`"></i>
                        </el-checkbox>
                      </el-checkbox-group>
                    </el-row>
                  </el-col>
                  <el-col :span="12">
                    <el-row class="title">Preference (Job Type)
                      <el-checkbox-group v-model="query.type">
                        <el-checkbox style="display: block;" label="Freelance On-going">Freelance On-going Project</el-checkbox>
                        <el-checkbox style="display: block;" label="Freelance One Time">Freelance One Time Project</el-checkbox>
                        <el-checkbox style="display: block;" label="Full-time">Full-time</el-checkbox>
                      </el-checkbox-group>
                    </el-row>
                    <el-row class="title">Preference (Location)</el-row>
                    <el-row>
                      <el-checkbox-group v-model="query.site">
                        <el-checkbox style="display: block;" label="On-Site">On Site</el-checkbox>
                        <el-checkbox style="display: block;" label="Off-Site">Off Site</el-checkbox>
                      </el-checkbox-group>
                    </el-row>
                  </el-col>
                </el-row>
              </div>
            </el-dropdown-menu>
          </el-dropdown>

          <el-dropdown trigger="click">
            <el-button type="primary" class="btn">
              Sort<i class="el-icon-caret-bottom"></i>
            </el-button>
            <el-dropdown-menu slot="dropdown">
              <div class="dropdown-content">
                <el-row style="margin: 10px -15px;">
                  <el-col :span="20">
                    <el-button @click="sort = null">Clear All</el-button>
                  </el-col>
                  <el-col :span="4">
                    <el-button icon="el-icon-close"></el-button>
                  </el-col>
                </el-row>
                <el-row style="width: 180px">
                  <el-radio v-model="sort" style="display: block;" label="RATING_HL">Rating:High to Low</el-radio>
                  <el-radio v-model="sort" style="display: block;" label="RATING_LH">Rating:Low to High</el-radio>
                  <el-radio v-model="sort" style="display: block;" label="PRICE_HL">Price:High to Low</el-radio>
                  <el-radio v-model="sort" style="display: block;" label="PRICE_LH">Price:Low to High</el-radio>
                </el-row>
              </div>
            </el-dropdown-menu>
          </el-dropdown>
        </div>
      </div>
      <job-row class="job-row" v-for="row in computedDataTable" :key="row.index" :data="row"></job-row>
      <div v-loading="tableData === null" v-if="tableData === null" style="height: 100px;">&nbsp;</div>
      <div class="no-result" v-if="tableData !== null && !computedDataTable.length">
        <div class="content">
          <p>Your search/choose did not return any content.</p>
        </div>
      </div>
      <div class="see-more" v-if="totalItem">
        <el-pagination
          @current-change="changePage"
          background
          layout="prev, pager, next"
          :page-size="3"
          :currentPage="1"
          :total="totalItem">
        </el-pagination>
      </div>
    </div>
  </div>
</template>

<script>
  import CategoryBar from '../../common/CategoryBar.vue'
  import JobRow from './JobRow.vue'

  export default {
    components: {
      JobRow,
      CategoryBar,
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.query.category = vm.$router.currentRoute.query.category || vm.$store.getters.defaultCategory.value
        vm.reloadData()
      })
    },
    data() {
      return {
        query: {
          search: '',
          category: this.$router.currentRoute.query.category || this.$store.getters.defaultCategory.value,
          rating: [],
          budget: [0, 4],
          type: [],
          site: [],
          page: 1,
          size: 3,
        },
        sort: null,
        tableData: null,
        totalItem: null,
      }
    },
    watch: {
      '$route.query.category'() {
        this.query.category = this.$router.currentRoute.query.category || this.$store.getters.defaultCategory.value
      },
    },
    computed: {
      computedDataTable() {
        let data = this.tableData
        if (data === null) {
          return data
        }
        data = data.filter(i => {
          const budgetRank = this.getBudgetRank(i.budget)
          if (budgetRank <= this.query.budget[0] || budgetRank > this.query.budget[1]) {
            return false
          }
          if (this.query.rating.length > 0 && !this.query.rating.includes(i.rating)) {
            return false
          }
          if (this.query.type.length > 0 && !this.query.type.includes(i.timeType)) {
            return false
          }
          if (this.query.site.length > 0 && !this.query.site.includes(i.site)) {
            return false
          }
          let pass = this.query.category === i.category.toLowerCase().replace(' ', '-')
          console.log(this.query.category, i.category.toLowerCase().replace(' ', '-'))
          if (this.query.search.length > 0) {
            pass = pass && i.projectName.includes(this.query.search)
          }
          return pass
        })
        data = data.sort((a, b) => {
          switch (this.sort) {
            case 'RATING_HL': {
              return a.rating < b.rating
            }
            case 'RATING_LH': {
              return a.rating > b.rating
            }
            case 'PRICE_HL': {
              return a.budget < b.budget
            }
            case 'PRICE_LH': {
              return a.budget > b.budget
            }
            default: {
              return b.createdAt - a.createdAt
            }
          }
        })
        this.totalItem = data.length
        data = data.slice((this.query.page - 1) * this.query.size, this.query.page * this.query.size)
        return data
      },
    },
    methods: {
      async reloadData() {
        this.tableData = null
        this.totalItem = 0
        const data = await this.$http.get('/jobs', {
          //          params: {
          //             page: this.query.page,
          //             size: this.query.size,
          //          },
        })
        this.tableData = data.items.map(i => {
          return {
            id: i.id,
            jobTitle: i.job_title,
            projectName: i.project_name,
            userId: i.user_id,
            timeType: i.time_type,
            site: i.site,
            budget: i.budget,
            experience: i.experience,
            deadline: i.deadline ? this.$moment(i.deadline).format('YYYY-MM-DD') : '-',
            info: i.info,
            location: i.location,
            category: i.category,
            employer: {
              id: i.employer.user_id,
              name: i.employer.company_name,
            },
            employmentType: i.employment_type,
            status: i.status,
            isConfidential: i.is_confidential,
            createdAt: i.created_at,
            updatedAt: i.updated_at,
            bonusPoints: i.bonus_points,
            skills: i.skills,
            images: i.images,
          }
        })
        this.totalItem = this.tableData.length
      },
      clearFilter() {
        this.query.budget = [0, 4]
        this.query.rating = []
        this.query.type = []
        this.query.site = []
      },
      changePage(currentPage) {
        this.query.page = currentPage
      },
      getBudgetRank(value) {
        if (value <= 0) {
          return 0
        }
        if (value > 0 && value <= 3000) {
          return 1
        }
        if (value > 3000 && value <= 5000) {
          return 2
        }
        if (value > 5000 && value <= 10000) {
          return 3
        }
        if (value > 10000) {
          return 4
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .query-panel {
    margin: 30px 0 50px;
    overflow: hidden;
    .panel-info {
      font-size: 1.8rem;
      font-weight: 900;
      padding: 2px 10px 2px 12px;
      color: $white;
      float: left;
      position: relative;
      height: 60px;
      line-height: 60px;
      .bg {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 2px;
        right: 0;
        height: 40px;
        margin: auto;
        background: $ultramarine;
        transform: rotate(5deg);
        z-index: -1;
      }
    }
    .panel-sort {
      float: right;
    }
    .btn {
      width: 160px;
      border: 1px solid $black;
      border-radius: 0;
      color: $black;
      background: $white;
      margin-left: 20px;
      position: relative;
      .el-icon-caret-bottom {
        position: absolute;
        right: 20px;
        font-size: 1.25rem;
        color: $blue;
        top: 10px;
      }
    }
  }

  .dropdown-content {
    min-width: 140px;
    padding: 10px 40px;
    .el-button {
      padding: 0;
      border: none;
    }
    .el-row {
      margin: 10px 0;
    }
    /deep/ .el-radio__input.is-checked .el-radio__inner {
      background: $yellow;
      border: 3px solid $black;
    }

    .el-icon-star-on::before {
      color: $ultramarine;
      font-size: 1.2rem;
      padding: 0 3px;
    }

    /deep/ .el-slider__runway {
      margin: 5px 0;
      height: 12px;
      border-radius: 10px;
      .el-slider__bar {
        height: 12px;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
      }
      .el-slider__stop {
        width: 12px;
        height: 12px;
      }
      .el-slider__button-wrapper {
        width: 12px;
        height: 12px;
        top: -5px;
      }
      .el-slider__button {
        background: $yellow;
        border: 2px solid $black;
      }
    }
    .el-switch {
      border-radius: 15px;
    }
    .el-switch.is-checked {
      /deep/ .el-switch__core .el-switch__button {
        background: $blue;
      }
    }
    /deep/ .el-switch__core {
      height: 18px;
      .el-switch__button {
        background: $yellow;
        border: 2px solid $black;
        top: -2px;
        left: -1px;
      }
    }
    .title {
      margin-top: 20px;
    }
  }

  .job-row {
    margin-bottom: 30px;
    &:last-of-type {
      margin-bottom: 0;
    }
  }

  .no-result {
    text-align: center;
    margin-bottom: 80px;
    margin-top: 40px;
    .content {
      width: 40%;
      min-width: 480px;
      margin: 0 auto 30px;
      padding: 10px 20px 20px;
      border: 1px solid #95989A;
      background-color: #F8F7F7;
    }
    .el-button {
      margin: 0 40px;
      min-width: 150px;
      border-radius: 0;
    }
  }

  .see-more {
    text-align: center;
    margin: 60px 0;
    .el-pagination /deep/ {
      .btn-prev, .btn-next {
        border: 1px solid $black;
        border-radius: 50%;
        background-color: transparent;
      }
      .number, .el-icon-more {
        color: $black;
        background-color: transparent;
        &.active {
          color: $white;
          background-color: $black;
          border-radius: 50%;
        }
      }
    }
  }
</style>
