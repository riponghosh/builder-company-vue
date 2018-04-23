<template>
  <div>
    <category-bar></category-bar>
    <div class="inner">
      <div class="query-panel">
        <div class="panel-info">
          Artists
          <div class="bg"></div>
        </div>
        <div class="panel-sort">
          <el-input v-model="query.search" placeholder="Search name" style="width: 200px"></el-input>
          <el-dropdown trigger="click">
            <el-button type="primary" class="btn">
              Filter<i class="el-icon-caret-bottom"></i>
            </el-button>
            <el-dropdown-menu slot="dropdown">
              <div class="dropdown-content" style="min-width: 470px;">
                <el-row style="margin: 10px -15px;">
                  <el-col :span="20">
                    <el-button @click="clearFilter">Clear All</el-button>
                  </el-col>
                  <el-col :span="4">
                    <el-button icon="el-icon-close"></el-button>
                  </el-col>
                </el-row>
                <el-row>
                  <el-col :span="12">
                    <el-row class="title">Rating</el-row>
                    <el-row>
                      <el-checkbox-group v-model="query.rating">
                        <el-checkbox :label="i" v-for="i in [1,2,3,4,5]" :key="`rating-${i}`" style="display: block;">
                          <i class="el-icon-star-on" v-for="(_, j) in Array(i)" :key="`rating-star-${j}`"></i>
                        </el-checkbox>
                      </el-checkbox-group>
                    </el-row>
                    <el-row class="title">Price</el-row>
                    <el-row>
                      <el-checkbox-group v-model="query.price">
                        <el-checkbox :label="i" v-for="i in [1,2,3,4,5]" :key="`price-${i}`" style="display: block;">
                          <span class="el-icon-custom-dollar" v-for="(_, j) in Array(i)" :key="`price-dollar-${j}`">$</span>
                        </el-checkbox>
                      </el-checkbox-group>
                    </el-row>
                  </el-col>
                  <el-col :span="12">
                    <el-row class="title">Exp</el-row>
                    <el-row>
                      <el-slider
                        v-model="query.experience"
                        range
                        :min="0"
                        :max="4"
                        :show-tooltip="false"
                        :format-tooltip="formatTooltip"
                        show-stops>
                      </el-slider>
                    </el-row>
                    <el-row style="font-size: 0.5rem;text-align: center;">
                      <el-col :span="5">0 Year</el-col>
                      <el-col :span="5">1 Year</el-col>
                      <el-col :span="5">3 Year</el-col>
                      <el-col :span="5">5 Year</el-col>
                      <el-col :span="4">5+ Year</el-col>
                    </el-row>
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
                <el-row>
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
      <artist-row class="artist-row" v-for="row in computedDataTable" :key="row.index" :data="row"></artist-row>
      <div v-loading="tableData === null" v-if="tableData === null" style="height: 100px;">&nbsp;</div>
      <div class="no-result" v-if="tableData !== null && !computedDataTable.length">
        <div class="content">
          <p>Your search/choose did not return any content.</p>
        </div>
      </div>
      <div class="see-more" v-if="computedDataTable.length">
        <el-pagination
          background
          layout="prev, pager, next"
          :page-size="query.size"
          :total="filteredDataTable.length"
          @current-change="clickPage">
        </el-pagination>
      </div>
    </div>
  </div>
</template>

<script>
  import CategoryBar from '../../common/CategoryBar.vue'
  import ArtistRow from './ArtistRow.vue'

  export default {
    components: {
      ArtistRow,
      CategoryBar,
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.reloadData()
      })
    },
    data() {
      return {
        query: {
          category: this.$router.currentRoute.query.category || this.$store.getters.defaultCategory.value,
          search: '',
          rating: [],
          price: [],
          experience: [0, 4],
          type: [],
          site: [],
          page: 1,
          size: 3,
        },
        sort: null,
        tableData: null,
      }
    },
    watch: {
      '$route.query.category'() {
        this.query.category = this.$router.currentRoute.query.category || this.$store.getters.defaultCategory.value
      },
    },
    computed: {
      filteredDataTable() {
        let data = this.tableData
        if (data === null) {
          return []
        }
        data = data.filter(i => {
          if (i.hourlyRate === null || i.exp === null) {
            return false
          }
          if (this.query.rating.length > 0 && !this.query.rating.includes(Math.round(i.rating))) {
            return false
          }
          const expLevel = {
            '0-1': 1,
            '1-3': 2,
            '3-5': 3,
            '5+': 4,
          }[i.experience]
          if (this.query.experience[0] > expLevel || this.query.experience[1] < expLevel) {
            return false
          }
          if (this.query.type.length > 0 && !this.query.type.includes(i.jobTypes)) {
            return false
          }
          if (this.query.site.length > 0 && !this.query.site.includes(i.site)) {
            return false
          }
          let pass = i.categories.map(item => item.toLowerCase().replace(' ', '-')).includes(this.query.category)
          console.log(i.categories.map(item => item.toLowerCase().replace(' ', '-')))
          console.log(this.query.category)
          if (this.query.search.length > 0) {
            pass = pass && i.firstName.includes(this.query.search) || i.lastName.includes(this.query.search)
          }
          return pass
        })
        return data
      },
      computedDataTable() {
        let data = this.filteredDataTable
        data = data.sort((a, b) => {
          switch (this.sort) {
            case null: {
              return b.createdAt - a.createdAt
            }
            case 'RATING_HL': {
              return a.rating < b.rating
            }
            case 'RATING_LH': {
              return a.rating > b.rating
            }
            case 'PRICE_HL': {
              return a.hourlyRate < b.hourlyRate
            }
            case 'PRICE_LH': {
              return a.hourlyRate > b.hourlyRate
            }
          }
        })
        data = data.slice((this.query.page - 1) * this.query.size, this.query.page * this.query.size)
        return data
      },
    },
    methods: {
      clearFilter() {
        this.query.price = []
        this.query.rating = []
        this.query.exp = [0, 4]
        this.query.type = []
        this.query.site = []
      },
      formatTooltip(value) {
        return `${value} Year${value > 1 ? 's' : ''}`
      },
      clickPage(currentPage) {
        this.query.page = currentPage
      },
      async reloadData() {
        this.tableData = null
        console.log('data')
        const data = await this.$http.get('/artists', {})

        this.tableData = data.items.map(i => {
          return {
            id: i.user_id,
            categories: i.categories,
            experience: i.experience,
            createdAt: i.created_at,
            portfolios: i.portfolios,
            rating: i.rating || 3,
            skills: i.skills,
            jobTypes: i.job_types,
            hourlyRate: i.hourly_rate,
            updatedAt: i.updated_at,
            clients: i.clients,
            availability: i.availability,
            site: i.site,
            location: i.location,
            phoneNumber: i.phone_number,
            bio: i.bio,
            email: i.email,
            firstName: i.first_name,
            lastName: i.last_name,
            avatar: i.avatar,
            experiences: i.experiences.map(i => {
              return {
                type: i.type,
                where: i.where,
                what: i.what,
                when: i.when,
              }
            }),
          }
        })
      },
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .query-panel {
    margin: 30px 0 30px;
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
      margin: 5px 0 10px;
    }
    /deep/ .el-radio__input.is-checked .el-radio__inner {
      background: $yellow;
      border: 3px solid $black;
    }

    .el-icon-star-on::before, .el-icon-custom-dollar {
      color: $ultramarine;
      font-size: 1.2rem;
      padding: 0 3px;
    }
    .el-icon-custom-dollar {
      font-weight: bold;
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
      span {
        font-size: 0.8rem;
        margin-left: 5px;
      }
    }
  }

  .artist-row {
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
