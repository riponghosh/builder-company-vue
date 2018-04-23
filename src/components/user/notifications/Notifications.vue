<template>
  <div>
    <p>Notification List:</p>
    <el-collapse v-model="activeNames" @change="handleChange" class="border_none">
      <el-collapse-item v-for='(item, index) in notificatData' :title="item.title" :key="`item-${index}`" class="padleft border_none">
        <div>{{item.text}}</div>
      </el-collapse-item>
    </el-collapse>
  </div>
</template>

<script>
  export default {
    components: {},
    mounted() {
    },
    data() {
      return {
        activeNames: ['1'],
        notificatData:[
          {'title':'Job Production:  Second Review is ready.',
            'text':'Job Production:  Second Review is ready.Please confirm review and provide feedback to help designer successfully finish the job. You have 3 days to provide the feedback. '
          },
          {'title':'Job Production:  Second Review is ready.',
            'text':'Job Production:  Second Review is ready.Please confirm review and provide feedback to help designer successfully finish the job. You have 3 days to provide the feedback. '
          }
        ]
      }
    },
    methods: {
      handleChange(val) {
        console.log(val);
      }
    }
  }
</script>

<style lang="scss" scoped>
  .el-collapse-item__header{
    border-bottom: 0px;
  }
  /*.padleft{*/
    /*padding-left: 100px;*/
    /*box-sizing: border-box;*/
  /*}*/
  /*.border_none{*/
    /*border: 0px !important;*/
  /*}*/
</style>
