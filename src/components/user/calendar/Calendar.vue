<template>
  <div>
    <div class="project left">
      <div class="date">date</div>
      <div v-for="item in projects" :class="item.style">{{item.label}}</div>
    </div>
    <full-calendar  locale="en" id="calendar" class=""></full-calendar>

  </div>
</template>

<script>
  import fullCalendar from 'vue-fullcalendar'
  export default {
    components: {
      'full-calendar': require('vue-fullcalendar')
    },
    mounted() {
    },
    data() {
      return {
        projects:[
          {
              label:"project-first",
              style:"project-first"
          },
          {
            label:"project-second",
            style:"project-second"
          },
          {
            label:"project-third",
            style:"project-third"
          },
          {
            label:"project-fourth",
            style:"project-fourth"
          }
        ]
      }
    },
    methods: {}
  }
</script>

<style lang="scss" >
  /*@import '~fullcalendar/dist/fullcalendar.css';*/
  @import "../../../assets/styles/base.scss";
  #calendar {
    padding-left: 12vw;
    .full-calendar-body{
      border: 2px solid #000;
      .weeks {
        background-color: $yellow;
        height: 40px;
        line-height: 40px;
        .week{
          border-right: none;
        }
      }
    }
  }
  .project{
    width: 12vw;
    height: 696px;
    margin-top: 59px;
    border: 2px solid #000;
    text-align: center;
    margin-left: 1.6vw;
    background: #ffffff;
    div{
      height: 110px;
      line-height: 110px;
    }
    .date{
      width: 12vw;
      height: 40px;
      line-height: 40px;
      background:$yellow;
    }
  }

  .project-first{
    background: $blue;
    color: #fff;
  }
  .project-second{
    background: pink;
  }
  .project-third{
    background: $yellow;
  }
  .project-fourth{
    background: #000;
    color: #fff;
  }

</style>
