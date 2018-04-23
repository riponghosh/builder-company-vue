<template>
  <div class="about-us">

    <section>
      <div class="banner-container">
        <el-row>
          <span>Our Mission is to</span>
        </el-row>
        <el-row>
          <span>Connet Design Pros From Worldwide.</span>
        </el-row>
      </div>
    </section>

    <section>
      <div class="contact-container">
        <el-row>contact@sharecreators.com</el-row>
        <el-row>
          <span>We Care About Your</span>
        </el-row>
        <el-row>
          <span>Feedback!</span>
        </el-row>
      </div>
    </section>

    <section>
      <el-row>
        <el-col :span="13"></el-col>
        <el-col :span="11">
          <p style="margin-bottom: 5vh">Who are we?</p>
          <p>
            We are an award-winning team
            based in Silicon Vally, San Francisco.
          </p>
          <p>
            Our mission is to connect design
            pros from worldwide. We are working
            so hard to combine arts and fine
            tech, in order to make designers and
            hirers satisfied and work happy. Let
            us know your thought! We are also
            excited to talk about dogs and cats.
          </p>
        </el-col>
      </el-row>
    </section>

    <section>
      <el-row>
        <el-col :span="11">
          <p style="margin-bottom: 5vh; font-size: 1.7rem; font-weight: 500;">Current Hiring</p>
          <p>Motion Garaphic Artists</p>
          <p>Graphic Designer </p>
          <p>Product Manager</p>
          <p>UI/UX Designer</p>
          <p style="margin-bottom: 5vh">Front End Engineer</p>
          <p>Let’s keep in touch:</p>
          <p>job@sharecreators.com</p>
        </el-col>
        <el-col :span="13"></el-col>
      </el-row>
    </section>

    <section>
      <div class="partners-container">
        <el-row>
          <span>Our Strategic Partners</span>
        </el-row>
        <el-row>
          <el-col :span="8">
            <div class="icon">
              <img src="~@/assets/images/newcode_logo.png" alt="" width="80px">
            </div>
            <div class="text">Influencers</div>
          </el-col>
          <el-col :span="8">
            <div class="icon" style="padding-top: 20px; box-sizing: border-box">
              <img src="~@/assets/images/interpret_logo.png" alt="" width="100px">
            </div>
            <div class="text">User Experice</div>
          </el-col>
        </el-row>
      </div>
    </section>
  </div>
</template>

<script>
  export default {
    data() {
      return {
      }
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .about-us {
    min-width: 1200px;
    text-align: center;
  }

  section {
    height: calc(100vh - 60px);
    box-sizing: border-box;
    div {
      box-sizing: border-box;
    }
  }

  section:nth-child(1) {
    background: #F9ECC8;
    .banner-container {
      height: 100%;
      background-image: url('../../../assets/images/feature_works.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;

      .el-row {
        padding-top: 5vh;
        &:nth-child(1) span {
          font-size: 2rem;
          z-index: 1;
          position: relative;
          &:after {
            content: "";
            width: 250px;
            height: 40px;
            background: $yellow;
            position: absolute;
            top: 0;
            left: -5px;
            transform: rotate(2deg);
            z-index: -1;
          }
        }
        &:nth-child(2) span {
          font-size: 3.5rem;
          font-weight: bold;
          background: $white;
          padding: 0px 10px;
        }
      }
    }
  }

  section:nth-child(2) {
    border: 25px solid $black;
    position: relative;
    .contact-container {
      .el-row {
        &:nth-child(1) {
          font-size: 2rem;
          letter-spacing: 4px;
          font-weight: 300;
          margin-bottom: 20px;
          padding-top: 25vh;
        }
        span {
          font-size: 3.5rem;
          font-weight: 300;
          padding: 0px 10px;
          letter-spacing: 2px;
          z-index: 1;
          position: relative;
          &:after {
            content: "";
            height: 35px;
            background: $yellow;
            position: absolute;
            top: 30px;
            left: -90px;
            z-index: -1;
          }
        }
        &:nth-child(2) span:after {
          width: 750px;
        }
        &:nth-child(3) span:after {
          width: 450px;
        }
      }
    }
  }

  section:nth-child(3) {
    border: 25px solid $blue;
    .el-row {
      height: 100%;
      .el-col {
        height: 100%;
        &:nth-child(1) {
          background-image: url('../../../assets/images/jumping-cute-playing-animals.png');
          background-size: cover;
          background-position-x: 75%;
          background-position-y: 20%;
          background-repeat: no-repeat;
        }
        &:nth-child(2) {
          padding: 10vh 8vw;
          p {
            font-size: 1.5rem;
            text-align: left;
            margin: 0;
            font-weight: 300;
            line-height: 5vh;
          }
        }
      }
    }
  }

  section:nth-child(4) {
    border: 25px solid $yellow;
    .el-row{
      height: 100%;
      .el-col {
        height: 100%;
        &:nth-child(1) {
          padding: 10vh 8vw;
          p {
            font-size: 1.5rem;
            text-align: left;
            margin: 0;
            font-weight: 300;
            line-height: 5vh;
          }
        }
        &:nth-child(2) {
          background-image: url('../../../assets/images/lady.png');
          background-size: cover;
          background-position-x: 55%;
          background-position-y: 50%;
          background-repeat: no-repeat;
        }
      }
    }
  }

  section:nth-child(5) {
    height: auto;
    background: $black;
    .partners-container{
      width: 1000px;
      height: 260px;
      color: $white;
      margin: 0 auto;
      .el-row:nth-child(1) {
        padding: 40px 0;        
        span {
          font-size: 2rem;
          z-index: 1;
          position: relative;
          color: $black;
          &:after {
            content: "";
            width: 325px;
            height: 40px;
            background: $yellow;
            position: absolute;
            top: 0;
            left: -5px;
            transform: rotate(2deg);
            z-index: -1;
          }
        }
      }
      .icon{
        height: 100px;
      }
      .text{
        font-size: 14px;
      }
    }
  }
</style>
