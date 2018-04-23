<template>
  <div class="row">
    <div class="job">
      <div class="title">
        <router-link style="color: black;" :to="`/jobs/${data.id}`">{{ data.projectName }}</router-link>
        <span>
          <i class="el-icon-location-outline" v-if="data.location" style="margin-right: 5px;"></i>
          {{ data.location }}
        </span>
        <el-row :gutter="40">
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
      <div class="looking-for">
        <span>
          <router-link :to="`/employers/${data.employer.id}`">{{ data.employer.name }}</router-link>
        </span>
        looking for
        <span style="display: inline-block;">
          {{ data.site }},
          {{ data.timeType }},
          {{ data.category }}
        </span>
        Designer.
      </div>
      <div class="skill">
        <div style="width: 55%;">
          <p style="width: 20%;">
            Skills Required:
          </p>
          <p style="width: 70%;">
            <span v-for="item in data.skills">{{item}}</span>
          </p>
        </div>
        <div style="width: 45%;">
          <p style="width: 26%;">
            Bounnus Points:
          </p>
          <p style="width: 70%;">
            <span v-for="item in data.bonusPoints">{{item}}</span>
          </p>
        </div>
      </div>
      <div>
        <div>Project Description:</div>
        <div style="margin-top: 2px;">
          {{ data.info }}
        </div>
      </div>
    </div>
    <ul class="label">
      <li>
        <span class="item-con">{{ data.deadline}}</span>
        <span class="item-label">Deadline</span>
      </li>
      <li>
        <span class="item-con">{{ data.applied || 0 }}</span>
        <span class="item-label">Applied</span>
      </li>
      <li>
        <rate v-model="data.rating"></rate>
        <span class="item-label">Rating</span>
      </li>
      <li>
        <span class="item-con">{{ data.experience? (data.experience + ' YRS') : 'UNKNOW' }}</span>
        <span class="item-label">Experience Required</span>
      </li>
      <li>
        <span class="item-con" style="font-weight: normal;">{{ '$' + data.budget }}</span>
        <span class="item-label">Budget</span>
      </li>
    </ul>
  </div>
</template>

<script>
  import Rate from '@/components/common/Rate'

  export default {
    props: ['data'],
    components: {
      Rate,
    },
    data() {
      return {}
    },
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .row {
    border: 3px solid #000;
  }

  .job {
    padding: 10px 4% 30px;
    div {
      margin-top: 10px;
    }
    .title {
      font-weight: 500;
      font-size: 1.6rem;
      height: 40px;
      line-height: 40px;
      position: relative;
      span {
        position: absolute;
        left: 55%;
        font-weight: normal;
        font-size: 0.9rem;
      }
      .el-row {
        position: absolute;
        left: 70%;
        top: 0;
        width: 25%;
        margin-top: 0;
        .el-col {
          margin-top: 0
        }
        .el-button {
          padding: 0;
        }

      }
    }
    .looking-for {
      a {
        color: $black;
      }
      span {
        background-color: $yellow;
      }
    }
    .skill {
      overflow: hidden;
      div, p {
        float: left;
      }
      p {
        margin: 0;
      }
      span {
        font-size: 0.8rem;
        display: inline-block;
        line-height: initial;
        text-align: center;
        margin: 0px 10px 5px 0;
        background: #eee;
        border: 1px solid transparent;
        border-radius: 5px;
        padding: 4px 12px;
        box-sizing: content-box;
        color: #aaa;
        &:last-of-type {
          margin-right: 0;
        }
      }
    }
  }

  .label {
    height: 80px;
    text-align: center;

    li {
      display: inline-block;
      padding: 0 4%;
      span {
        display: block;
      }
      .item-con {
        line-height: 50px;
        font-size: 1.6rem;
        font-weight: 500;
      }
      .item-label {
        font-size: 0.9rem;
      }
    }
  }

  .row:nth-child(even) .label {
    background: $ultramarine;
    color: $white;
  }

  .row:nth-child(odd) .label {
    background: $yellow;
    color: $black;
    /deep/ .el-rate .el-rate__icon {
      &::before {
        color: $black;
      }
      &.el-icon-star-on::before {
        color: $black;
      }
    }
  }
</style>
