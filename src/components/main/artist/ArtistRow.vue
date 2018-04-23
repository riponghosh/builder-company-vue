<template>
  <div class="row">
    <div class="context">
      <div class="artist">
        <router-link :to="`/artists/${data.id}`">
          <div class="artist-icon" :style="{'background-image': 'url('+ data.avatar +')'}" v-if="data.avatar"></div>
          <div class="artist-icon mock" v-if="!data.avatar"></div>
        </router-link>
      </div>
      <div class="info">
        <div class="info-item name">
          {{data.lastName}} {{data.firstName}}
        </div>
        <div class="info-item items">
          <span class="info-item-label">Category:</span>
          <div class="info-item-con">
            <span v-for="item in data.categories" v-if="data.categories.length">{{item}}</span>
            <div v-if="!data.categories.length" style="display: inline-block;">
              <span>Graphic Design</span>
              <span>Motion Graphics</span>
              <span>2D Animation</span>
            </div>
          </div>
        </div>
        <div class="info-item items">
          <span class="info-item-label">Skills:</span>
          <div class="info-item-con">
            <span v-for="item in data.skills" v-if="data.skills">{{item}}</span>
            <div v-if="!data.skills" style="display: inline-block;">
              <span>Design</span>
              <span>Illustrator</span>
              <span>Photoshop</span>
            </div>
          </div>
        </div>
        <div class="info-item items">
          <span class="info-item-label">Preference:</span>
          <div class="info-item-con">

            <span v-if="data.jobTypes">{{data.jobTypes}}</span>
            <div v-if="!data.jobTypes" style="display: inline-block;">
              <span>Freelance On-going</span>
              <span>Freelance One Time Project</span>
              <span>Full-time</span>
            </div>
          </div>
        </div>
        <div class="info-item items">
          <span class="info-item-label">Preference:</span>
          <div class="info-item-con">
            <span v-if="data.site">{{data.site}}</span>
            <div v-if="!data.site" style="display: inline-block;">
              <span>On-site</span>
              <span>Off-site</span>
            </div>
          </div>
        </div>
        <div class="info-item clients">
          <span class="info-item-label">Clients:</span>
          <span class="info-item-con">{{data.clients || 'Adidas, Sagmeister& Walsh,  Frooti Fizz, Converse.'}}</span>
        </div>
      </div>
      <div class="pic">
        <div class="pic-item" v-for="i in data.portfolios" :style="{'background-image': 'url('+ i.url+')'}" v-if="data.portfolios.length"></div>

        <div class="pic-item mock" v-if="!data.portfolios.length"></div>
        <div class="pic-item mock" v-if="!data.portfolios.length"></div>
        <div class="pic-item mock" v-if="!data.portfolios.length"></div>
      </div>
    </div>
    <ul class="label">
      <li>
        <span class="item-con">{{data.status || 'AVAILABLE'}}</span>
        <span class="item-label">status</span>
      </li>
      <li>
        <rate v-model="data.rating"></rate>
        <span class="item-label">Rating</span>
      </li>
      <li>
        <span class="item-con">{{data.range || '$$'}}</span>
        <span class="item-label">Price Range</span>
      </li>
      <li>
        <span class="item-con">${{data.hourlyRate || '80'}}/hr</span>
        <span class="item-label">Hourly Rate</span>
      </li>
      <li>
        <span class="item-con">{{data.experience? (data.experience + ' YRS') : 'UNKNOW'}}</span>
        <span class="item-label">Experience</span>
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
    border: 3px solid $black;
    .context {
      overflow: hidden;
      padding: 30px 4%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      .artist {
        width: 10%;
        min-width: 120px;
        .artist-icon {
          @include adaptedSquaredImg();
          border-radius: 50%;
          &.mock {
            background-image: url('../../../assets/images/mock-avatar.jpg');
          }
        }
      }
      .info {
        width: 44%;
        .info-item {
          line-height: 40px;
        }
        .info-item-label {
          width: 18%;
          min-width: 90px;
          display: inline-block;
        }
        .info-item-con {
          width: 80%;
          font-size: 0.8rem;
          display: inline-block;
          vertical-align: top;
        }
        .name {
          font-weight: 500;
          font-size: 1.6rem;
        }
        .items {
          .info-item-con span {
            display: inline-block;
            min-width: 50px;
            line-height: initial;
            text-align: center;
            margin-right: 10px;
            background: #EFEFEF;
            border: 1px solid transparent;
            border-radius: 5px;
            padding: 4px 10px;
            box-sizing: content-box;
            &:last-of-type {
              margin-right: 0;
            }
          }
        }
        .experiences .info-item-con div:last-of-type {
          display: inline-block;
        }
      }
      .pic {
        width: 38%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        .pic-item {
          @include adaptedSquaredImg(30%);
        }
        .mock {
          &:nth-child(1) {
            background-image: url('../../../assets/images/mock-portfolio1.jpg');
          }
          &:nth-child(2) {
            background-image: url('../../../assets/images/mock-portfolio2.jpg');
          }
          &:nth-child(3) {
            background-image: url('../../../assets/images/mock-portfolio3.jpg');
          }
        }
      }

    }
    .label {
      height: 80px;
      text-align: center;
      background: $ultramarine;
      color: $white;
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
  }

  .el-rate {
    padding: 4px;
    height: auto;
    display: flex;
    justify-content: space-around;
    /deep/ .el-rate__icon {
      margin: 0 4px 10px;
      font-size: 1.5rem;
      &::before {
        color: $white;
      }
    }
  }
</style>
