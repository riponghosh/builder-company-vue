<template>
  <div>
    <!--{{ JSON.stringify(data) }}-->
    <el-steps :active="activeStep" id="steps">
      <div class="steps-bg">
        <div class="steps-bg-finished"></div>
      </div>
      <el-step v-for="(step, index) in steps" :key="step.title">
        <div slot="title">
          {{ step.title }}
        </div>
        <div slot="description">
          <step :data="step"></step>
        </div>
      </el-step>
    </el-steps>
  </div>
</template>

<script>
  import Step from './Step.vue'

  export default {
    components: {
      Step,
    },
    data() {
      return {}
    },
    computed: {
      id() {
        return this.$route.params.id
      },
      data() {
        return this.$store.state.openJob
      },
      reviews() {
        return this.data.contract ? this.data.reviews : []
      },
      ratings() {
        return this.data.contract ? this.data.reviews : []
      },
      activeStep() {
        // WAIT_EMPLOYER_SIGN | WAIT_ARTIST_SIGN
        // WAIT_ARTIST_INVITE | WAIT_EMPLOYER_REVIEW
        // WAIT_RATE
        // FINISHED
        let step = 0
        if (this.data.contract && !['WAIT_EMPLOYER_SIGN', 'WAIT_ARTIST_SIGN'].includes(this.data.contract.status)) {
          step = this.reviews.filter(i => i.status === 'ACCEPTED').length + 1
        }
        return step
      },
      steps() {
        // 计算有多少 review
        const reviewCount = this.$store.getters.reviewCount
        const reviews = new Array(reviewCount).fill(0).map((_, index) => {
          return {
            title: `Round ${index + 1} Review`
          }
        })

        // 拼装 steps
        const signContract = {
          title: 'Sign Contract',
        }
        const rating = {
          title: 'Rating & Payment',
        }
        return [signContract, ...reviews, rating].map((i, index) => {
          i.index = index
          i.status = 'ACTIVE'
          if (index < this.activeStep) {
            i.status = 'DONE'
          } else if (index > this.activeStep) {
            i.status = 'WAITING'
          }
          return i
        })
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import "../../../../assets/styles/base.scss";

  #steps {
    position: relative;

    .steps-bg {
      position: absolute;
      top: -2px;
      left: -2px;
      width: 100%;
      height: 50px;
      border-top: 2px solid $black;
      border-bottom: 2px solid $black;
      background-image: linear-gradient(90deg, #FFE0E6, #FFFCD2, #E3FFE7);
      &::before, &::after {
        content: "";
        height: 50px;
        position: absolute;
        border-left: 2px solid $black;
        z-index: 1;
      }
      &::before {
        left: 0;
      }
      &::after {
        right: 0;
      }
      .steps-bg-finished {
        position: absolute;
        left: 2px;
        width: 20px;
        height: 100%;
        // background-image: linear-gradient(90deg, #FF4A70, #FFFB00, #64FF79);
      }
    }
    /deep/ .el-step {
      .el-step__head {
        height: 50px;
        line-height: 50px;
        margin-left: 20px;
        box-sizing: border-box;
        &::before {
          content: "";
          display: block;
          background: $black;
          width: 1px;
          height: 80px;
          position: relative;
          top: 50px;
          left: 0;
        }
        &::after {
          content: "";
          display: block;
          background: $black;
          width: 10px;
          height: 10px;
          position: relative;
          border-radius: 10px;
          top: 46px;
          left: -4px;
        }
        .el-step__line {
          display: none;
        }
        .el-step__icon {
          display: none;
        }
      }
      .el-step__main {
        background: transparent;
        .el-step__title, .el-step__description {
          margin-left: -40px;
        }
      }

      &:first-child {
        .el-step__head {
          &::before {
            left: 0;
          }
          &::after {
            left: -4px;
          }
        }
        .el-step__main {
          .el-step__title, .el-step__description {
            margin-left: 0;
          }
        }
      }
      &:last-child {
        .el-step__head {
          margin-left: 0;
          &::before {
            left: 20px;
          }
          &::after {
            left: calc(20px - 4px);
          }
        }
        .el-step__main {
          .el-step__title, .el-step__description {
            margin-left: -80px;
          }
        }
      }

      .el-step__description.is-wait {
        display: none;
      }

      .el-step__head.is-process {
        &::before {
          height: 190px;
          top: 0;
        }
        &::after {
          top: 0;
        }
      }
      .el-step__title.is-process {
        padding-top: 140px;
      }

    }
  }

</style>
