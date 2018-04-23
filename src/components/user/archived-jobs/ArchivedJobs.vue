<template>
  <div>
    <p>Job History</p>
    <el-table
      :data="tableData"
      style="width: 100%"
      align="center"
      border
      class="table-border">
      <el-table-column
        prop="date"
        label="Data"
        width="180"
        align="center">
      </el-table-column>
      <el-table-column
        prop="name"
        label="Project Name"
        align="center"
      >
      </el-table-column>
      <el-table-column
        prop="designer"
        label="Designer"
        align="center">
      </el-table-column>
      <el-table-column
        prop="payment"
        label="Payment"
        align="center">
      </el-table-column>

    </el-table>
    <el-pagination
      layout="prev, pager, next"
      :total="50">
    </el-pagination>
    <!--<category-bar></category-bar>-->
    <!--<div class = "inner">-->
    <!--<div class="query-panel ">-->
    <!--&lt;!&ndash;<el-button @click="findPro">Find Pro</el-button>&ndash;&gt;-->
    <!--<span class = "pannal_info">Jobs Board</span>-->
    <!--<div class="right">-->
    <!--<el-dropdown>-->
    <!--<el-button type="primary" class="btn">-->
    <!--Filter<i class="el-icon-arrow-down el-icon&#45;&#45;right"></i>-->
    <!--</el-button>-->
    <!--<el-dropdown-menu slot="dropdown">-->
    <!--<div class="dropdown-content">-->
    <!--<div class="title">Rating</div>-->
    <!--<div>-->
    <!--rating-->
    <!--</div>-->
    <!--<div class="title">Budget</div>-->
    <!--<div>-->
    <!--rating-->
    <!--</div>-->
    <!--<div class="title">Preference</div>-->
    <!--<div>-->
    <!--rating-->
    <!--</div>-->
    <!--<div class="title">Feature</div>-->
    <!--<div>-->
    <!--rating-->
    <!--</div>-->
    <!--</div>-->
    <!--</el-dropdown-menu>-->
    <!--</el-dropdown>-->

    <!--<el-dropdown>-->
    <!--<el-button type="primary" class = "btn">-->
    <!--Sort<i class="el-icon-arrow-down el-icon&#45;&#45;right"></i>-->
    <!--</el-button>-->
    <!--<el-dropdown-menu slot="dropdown">-->
    <!--<div class="dropdown-content">-->
    <!--hello-->
    <!--</div>-->
    <!--</el-dropdown-menu>-->
    <!--</el-dropdown>-->
    <!--</div>-->
    <!--</div>-->
    <!--<job-row v-for="row in tableData" :key="row.id" :data="row"></job-row>-->
    <!--<el-button @click="loadMore" class = "btn_more">See More</el-button>-->
    <!--</div>-->
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
        vm.query.category = vm.query.category || vm.$store.getters.defaultCategory.value
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
        //        tableData: null,
        tableData: [{
          date: '12/12/2017',
          name: 'Motion Graphics For Social Media',
          designer: 'Jone Black',
          payment: '$9000'
        }, {
          date: '12/12/2017',
          name: 'Motion Graphics For Social Media',
          designer: 'Jone Black',
          payment: '$9000'
        }, {
          date: '12/12/2017',
          name: 'Motion Graphics For Social Media',
          designer: 'Jone Black',
          payment: '$9000'
        }, {
          date: '12/12/2017',
          name: 'Motion Graphics For Social Media',
          designer: 'Jone Black',
          payment: '$9000'
        }]
      }
    },
    methods: {
      findPro() {

      },
      async reloadData() {
        //        this.tableData = null
        const data = await this.$http.get('/jobs', {
          params: {
            page: this.query.page,
            size: this.query.size,
          },
        })
        const items = data.items
        //        this.tableData = items
      },
      async loadMore() {
        const data = await this.$http.get('/jobs', {
          params: this.query,
        })
        const items = data.items
        //        this.tableData = [...this.tableData, ...items]
      },
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .table-border {
    border: 3px solid #000;
  }
</style>
