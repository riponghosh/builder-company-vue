<template>
  <div>
    <!--<category-bar></category-bar>-->
    <div class="inner">
      <div class="query-panel ">
        <!--<el-button @click="findPro">Find Pro</el-button>-->
        <span class="pannal_info">Jobs Board</span>
        <div class="right">
          <el-dropdown>
            <el-button type="primary" class="btn">
              Filter<i class="el-icon-arrow-down el-icon--right"></i>
            </el-button>
            <el-dropdown-menu slot="dropdown">
              <div class="dropdown-content">
                <div class="title">Rating</div>
                <div>
                  rating
                </div>
                <div class="title">Budget</div>
                <div>
                  rating
                </div>
                <div class="title">Preference</div>
                <div>
                  rating
                </div>
                <div class="title">Feature</div>
                <div>
                  rating
                </div>
              </div>
            </el-dropdown-menu>
          </el-dropdown>

          <el-dropdown>
            <el-button type="primary" class="btn">
              Sort<i class="el-icon-arrow-down el-icon--right"></i>
            </el-button>
            <el-dropdown-menu slot="dropdown">
              <div class="dropdown-content">
                hello
              </div>
            </el-dropdown-menu>
          </el-dropdown>
        </div>
      </div>
      <job-row v-for="row in tableData" :key="row.id" :data="row"></job-row>
      <el-button @click="loadMore" class="btn_more">See More</el-button>
    </div>
  </div>
</template>

<script>
  import CategoryBar from '../../common/CategoryBar.vue'
  import JobRow from '../../main/job/JobRow.vue'

  export default {
    components: {
      JobRow,
      CategoryBar,
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.query.category = to.query.category || this.$store.getters.defaultCategory.value
        vm.reloadData()
      })
    },
    data() {
      return {
        query: {
          category: null,
          rating: null,
          budget: null,
          preference: null,
          feature: null,
          page: 1,
          size: 20,
        },
        tableData: null,
      }
    },
    methods: {
      findPro() {

      },
      async reloadData() {
        this.tableData = null
        const data = await this.$http.get('/jobs', {
          params: {
            page: this.query.page,
            size: this.query.size,
          },
        })
        const items = data.items
        this.tableData = items
      },
      async loadMore() {
        const data = await this.$http.get('/jobs', {
          params: this.query,
        })
        const items = data.items
        this.tableData = [...this.tableData, ...items]
      },
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .pannal_info {
    font-size: 28px;
    font-weight: bold;
    padding: 2px 10px;
    color: #FFF500;
    background: #5055EC;
  }

  .btn {
    width: 160px;
    background: #fff;
    border: 1px solid #000;
    color: black;
    border-radius: 2px;
    /*coreect*/
    margin-left: 20px;
  }

  .btn_more {
    background: $yellow;
    border: none;
    border-radius: 2px;
    @include wwcenter(160);

  }

  .dropdown-content {
    padding: 5px 20px;

  }

  .query-panel {
    height: 100px;
    line-height: 100px;
    margin-bottom: 10px;
    .right {
      display: inline-block;
      float: right;
    }
  }
</style>
