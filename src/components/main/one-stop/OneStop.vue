<template>
  <div class="oss">

    <section>
      <div class="banner-container">
        <el-row>
          <span>One-stop service leverage the award-winning</span>
        </el-row>
        <el-row>
          <span>talents on our platform to get the</span>
        </el-row>
        <el-row>
          <span>best possible quality design.</span>
        </el-row>
        <el-row class="contact-button">
          <el-button type="primary">
            <a href="mailto:contact@sharecreators.com" target="_top">
              Contact Us Get A Quote
            </a>
          </el-button>
        </el-row>
      </div>
    </section>

    <section>
      <el-row class="introduct-one-container">
        <el-col :span="13">
          <el-row>
            <span>HALF</span>
          </el-row>
          <el-row>
            <span>PRICE</span>
          </el-row>
          <el-row>
            <span>FOR</span>
          </el-row>
          <el-row>
            <span>STARTUPS</span>
          </el-row>
          <el-row class="contact-button">
            <el-button type="primary">
              <a href="mailto:contact@sharecreators.com" target="_top">
                Contact Us Get A Quote
              </a>
            </el-button>
          </el-row>
        </el-col>
        <el-col :span="11">
          <div>We invest the future!</div>
          <div>We provide half market price
            high-quality design service to
            early-stage startups.
          </div>
          <div>We understand early-stage startups could be
            budget sensitive.We work with selected early-
            stage startups with half of the studio market
            price( project budget above 10k),to help you with
            high-quality UI/UX design, marketing campaign
            design, explanatory video, UA design etc. As your
            company grows, you need to work with us in the
            next 12 months for further two times with full
            market price(Each further design jobs budget
            above 10k). Talk to us to find out more!
          </div>
        </el-col>
      </el-row>
    </section>

    <section>
      <div>
        <iframe src="https://www.youtube.com/embed/Se0YpMT1dTk" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
      </div>
    </section>

    <section>
      <el-row class="introduct-one-container">
        <el-col :span="13">
          <el-row>
            <span>LET'S</span>
          </el-row>
          <el-row>
            <span>BUILD</span>
          </el-row>
          <el-row class="contact-button">
            <el-button type="primary">
              <a href="mailto:contact@sharecreators.com" target="_top">
                Contact Us Get A Quote
              </a>
            </el-button>
          </el-row>
        </el-col>
        <el-col :span="11">
          <div>Why choose us?</div>
          <div>We are the new type of creative
            studio. We understand talents
            are the soul of creation.
          </div>
          <div>The tremendous scale of our talents
            pool is much more diverse and bigger
            than traditional art agency. Our one-
            stop service enables us to leverage the
            award-winning talents on our platform
            to get the best possible quality design.
          </div>
        </el-col>
      </el-row>
    </section>

    <section>
      <el-row class="introduct-three-container">
        <el-col :span="12">
          <div class="item title">We help you save budgets.</div>
          <div class="item">We carefully manage every
            production step to ensure the high
            quality and accurate budgets control. The budgets that we save
            can eventually benefit our clients.
          </div>
          <div class="item headline">
            <el-row>
              <span>DESIGN</span>
            </el-row>
            <el-row>
              <span>MATTERS</span>
            </el-row>
            <el-row class="contact-button">
              <el-button type="primary">
                <a href="mailto:contact@sharecreators.com" target="_top">
                  Contact Us Get A Quote
                </a>
              </el-button>
            </el-row>
          </div>
        </el-col>
        <el-col :span="12">
          <div class="item headline">
            <el-row>
              <span>DESIGN</span>
            </el-row>
            <el-row>
              <span>BUILD</span>
            </el-row>
            <el-row>
              <span>LAUNCH</span>
            </el-row>
          </div>
          <div class="item title">
            Our design style is customizable base on your needs.
          </div>
          <div class="item">
            We carefully pick the right artists from our large talent pool to work with us, base on your design request.
          </div>
        </el-col>
      </el-row>
    </section>

    <section>
      <div class="portfolio-container">
        <el-row class="title">
          <span>One-Stop Service Portfolio</span>
        </el-row>
        <el-row class="el-row-bg">
        </el-row>
        <el-row :gutter="20">
          <el-col :span="12">
            <el-row class="el-row-bg">
            </el-row>
            <el-row class="el-row-bg">
            </el-row>
          </el-col>
          <el-col :span="12">
            <el-row class="el-row-bg">
            </el-row>
          </el-col>
        </el-row>
        <el-row class="contact-button">
          <el-button type="primary">See More</el-button>
        </el-row>
      </div>
    </section>

    <section>
      <el-row class="title">Talk to us to get a quote!</el-row>
      <el-row class="text">
        <p>We are so proud to connect design pros</p>
        <p>worldwide to crafting unique ideas</p>
        <p>and tell your stories!</p>
      </el-row>
      <el-row class="contact-button">
        <el-button type="primary">
          <a href="mailto:contact@sharecreators.com" target="_top">
            Contact Us Get A Quote
          </a>
        </el-button>
      </el-row>
    </section>
  </div>
</template>

<script>
  import ElRow from "element-ui/packages/row/src/row";

  export default {
    components: { ElRow },
    data() {
      return {}
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .oss {
    text-align: center;
    min-width: 1200px;
  }

  section {
    height: calc(100vh - 60px);
    box-sizing: border-box;
    div {
      box-sizing: border-box;
    }
    .contact-button {
      position: absolute;
      bottom: 10vh;
      left: 0;
      right: 0;
      .el-button {
        border-radius: 0;
        border: 0;
        font-weight: normal;
        a {
          color: $white;
        }
      }
    }
  }

  section:nth-child(1) {
    height: calc(60vh - 60px);
    .banner-container {
      height: 100%;
      background-image: url('../../../assets/images/oss-banner.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      padding-top: 5vh;
      position: relative;

      .el-row {
        margin: 12px 0;
        span {
          font-size: 1.25rem;
          font-weight: bold;
          padding: 3px;
          background-color: $white;
        }
        &:nth-child(3) span {
          background-color: $yellow;
        }
        .el-button {
          background-color: $ultramarine;
        }
      }
    }
  }

  section:nth-child(2), section:nth-child(4) {
    border: 25px solid $ultramarine;
    .introduct-one-container {
      text-align: left;
      height: 100%;
      .el-col {
        position: relative;
        height: 100%;
        &:nth-child(1) {
          padding: 10vh 0 0 8vw;
          span {
            font-size: 14vh;
            font-weight: 900;
            -webkit-text-stroke: 4px $ultramarine;
            color: $ultramarine;
            line-height: 14vh;
            font-family: 'Source Sans Pro';
          }
          .contact-button {
            left: 8vw;
            .el-button {
              background-color: $ultramarine;
            }
          }
        }
        &:nth-child(2) {
          padding: 7vh 8vw 0 0;
          font-size: 1.4rem;
          line-height: 4.4vh;
          font-weight: 300;
          div {
            margin-bottom: 3vh;
            &:nth-child(1) {
              font-size: 1.7rem;
            }
            &:nth-child(2) {
              font-size: 3.8vh;
              font-weight: 500;
              line-height: 4.5vh;
            }
          }
        }
      }
    }
  }

  section:nth-child(3) {
    background: $black;
    padding: 10vh 8vw;
    div {
      border: 6px solid $white;
      height: 100%;
      iframe {
        height: 100%;
        width: 100%;
      }
    }
  }

  section:nth-child(4) {
    .introduct-one-container {
      .el-col:nth-child(1) {
        span {
          font-size: 27vh;
          line-height: 22vh;
        }
        .contact-button {
          left: 0;
          text-align: center;
          bottom: 15vh;
        }
      }
      .el-col:nth-child(2) {
        padding-top: 10vh;
      }
    }
  }

  section:nth-child(5) {
    border: 25px solid $yellow;
    .introduct-three-container {
      text-align: left;
      height: 100%;
      .el-col {
        position: relative;
        height: 100%;
        font-size: 1.5rem;
        line-height: 4.3vh;
        font-weight: 300;
        &:nth-child(1) {
          padding: 7vh 1vw 0 8vw;
        }
        &:nth-child(2) {
          padding: 7vh 8vw 0 1vw;
        }
        .item {
          margin-bottom: 4vh;
          &.title {
            font-size: 3.5vh;
            font-weight: 500;
            line-height: 4.5vh;
          }
          &.headline {
            span {
              font-size: 10vh;
              font-weight: 500;
              -webkit-text-stroke: 2px $yellow;
              color: $yellow;
              line-height: 10vh;
            }
            .contact-button {
              left: 8vw;
              bottom: 20vh;
              .el-button {
                background-color: $yellow;
                a {
                  color: $black;
                }
              }
            }
          }
        }
      }
    }
  }


  section:nth-child(6) {
    border: 25px solid $blue;
    height: calc((100vh - 60px) * 2);
    position: relative;
    .portfolio-container {
      padding: 7vh 8vw;
      .el-row:nth-child(1) {
        margin-bottom: 5vh;
        span {
          font-weight: bold;
          font-size: 2rem;
          position: relative;
          z-index: 1;
          &:before {
            content: "";
            display: block;
            width: 400px;
            height: 40px;
            background: $yellow;
            position: absolute;
            top: 0;
            left: -5px;
            z-index: -1;
            transform: rotateZ(2deg);
          }
        }
      }
      .el-row-bg {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
      }
      .el-row:nth-child(2) {
        height: calc((100vh - 60px + 20px) / 2);
        margin-bottom: 20px;
        background-image: url('../../../assets/images/portfolio.png');
        background-position: top center;
      }
      .el-row:nth-child(3) {
        height: calc(100vh - 60px + 20px);
        .el-col:nth-child(1) {
          .el-row:nth-child(1) {
            height: calc((100vh - 60px) / 2);
            margin-bottom: 20px;
            background-image: url('../../../assets/images/portfolio_one.png');
          }
          .el-row:nth-child(2) {
            height: calc((100vh - 60px) / 2);
            background-image: url('../../../assets/images/portfolio_two.png');
            background-position: center right;
            margin: 0;
          }
        }
        .el-col:nth-child(2) {
          .el-row {
            height: calc(100vh - 60px + 20px);
            background-image: url('../../../assets/images/portfolio_three.png');
            margin: 0;
          }
        }
      }
      .contact-button {
        bottom: 5vh;
        .el-button {
          background-color: $black;
        }
      }
    }
  }


  section:nth-child(7) {
    border: 25px solid $yellow;
    text-align: center;
    position: relative;
    .el-row:nth-child(1) {
      padding-top: 22vh;
      font-size: 2rem;
      letter-spacing: 4px;
      font-weight: 300;
      margin-bottom: 3vh;
    }
    .el-row:nth-child(2) {
      font-size: 2.5rem;
      letter-spacing: 2px;
      margin-bottom: 3vh;
      font-weight: 400;
      p {
        margin: 10px 0;
      }
    }
    .el-row:nth-child(3) {
      bottom: 20vh;
      .el-button {
        background-color: $yellow;
        a {
          color: $black;
        }
      }
    }
  }


</style>
