<template>
  <div class="home">
    <section class="first">
      <div class="border-content">
        <div class="text">
          <div>WE HELP U FIND</div>
          <div class="bg-yellow">TOP & AWARD-WINNING</div>
          <span class="bg-yellow">ART & DESIGN PRO</span>
          <div>FROM</div>
          <div>WORLDWIDE</div>
        </div>
        <div class="btn-container">
          <div class="hire-pros">
            <span class="context">HIRE PROS</span>
            <span class="arrow-white"></span>
          </div>
          <div class="join-as">
            <span class="context">JOIN US A PRO</span>
            <span class="arrow-blue"></span>
          </div>
        </div>
        <div class="img-container">
          <div style="width:42vh; height:42vh; overflow: hidden" class="picture">
            <img src="~@/assets/images/first.png" alt="">
          </div>
          <div class="brand">
            <img src="~@/assets/images/brand.png" alt="">
          </div>
        </div>
      </div>
    </section>

    <section class="second">
      <div class="title">WHO ARE WE ?</div>
      <div class="btn-arrow">
        <span class="arrow-down-left"></span>
      </div>
      <div class="border-content">
        <div class="text">
          <div>WE ARE A</div>
          <div>FREELANCE</div>
          <div>DESIGNERS</div>
          <div>PLATFORM</div>
        </div>
        <div class="description">
          Let you work with worldwide<br>
          art pros both online & onsite<br>
          seamlessly
        </div>
        <div class="img-container">
          <div style="width: 46vh; height: 62vh; overflow: hidden;background: pink">
            <img src="~@/assets/images/second.png" alt="">
          </div>
        </div>
        <div class="bottom">
          <div><span v-for="item in 6" class="react"></span></div>
          <div><span v-for="item in 8" class="react"></span></div>
        </div>
      </div>
    </section>

    <section class="third">
      <div class="title">VIDEO</div>
      <div class="btn-arrow">HOW</div>
      <div class="border-content">
        <div class="video">
          <iframe src="https://www.youtube.com/embed/Siwio1dxxlg" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
        <div class="decorate-line"></div>
      </div>
      <div class="watch">
        <span class="context">WATCH</span>
        <div class="arrow-container"><span class="arrow-watch"></span></div>
      </div>
    </section>

    <section class="four">
      <span class="why">WHY</span>
      <div class="circle"></div>
      <!--start-slide-->
      <div class="slide-container">
        <div class="next-arrow-container" @click="whyNextPannal">
          <div class="next-arrow"></div>
        </div>
        <div class="last-arrow-container" @click="whyLastPannal">
          <div class="last-arrow"></div>
        </div>
        <ul class="indicators">
          <li @click="whyIndex = 0" v-bind:class="{ active: whyIndex === 0 }"></li>
          <li @click="whyIndex = 1" v-bind:class="{ active: whyIndex === 1 }"></li>
          <li @click="whyIndex = 2" v-bind:class="{ active: whyIndex === 2 }"></li>
          <li @click="whyIndex = 3" v-bind:class="{ active: whyIndex === 3 }"></li>
        </ul>
        <!--four-pannel-first-->
        <div class="main-container" id="four-pannel-first" v-if="whyIndex === 0">
          <div class="main-content">
            <div class="title">WHY HIRERS LOVE US?</div>
            <div class="context">Staff hand-pick and fine tech, make sure you can find the most suitable designers fast!
            </div>
            <el-row>
              <el-col :span="12" class="hand-pick">
                <div class="headline">Staff Hand-Pick</div>
                <div class="describe" style="margin-bottom: 30px">1.Our design team will hand-pick and recommend designers from award-winning talents pool if you didn’t find suitable designers within 3 days.</div>
                <div class="describe">2.Our design team feature hand-pick artists every day on our website.</div>
              </el-col>
              <el-col :span="12" class="advance-technology">
                <div class="headline">Advanced Technology</div>
                <div class="describe">The powerful built-in statistical analytic algorithm, analysis your requirements and designers performance. Data helps us determine who fits your job requirements.</div>
              </el-col>
            </el-row>
            <div class="img-container">
              <div style="width: 400px; height: 580px; overflow: hidden;">
                <img src="~@/assets/images/eye.png" alt="" width="500px" style="transform: translateY(-2px);">
              </div>

            </div>
          </div>
        </div>
        <!--four-pannel-second-->
        <div class="main-container" id="four-pannel-second" v-if="whyIndex === 1">
          <div class="main-content">
            <div class="title">WHY HIRERS LOVE US?</div>
            <div class="context" style="width: 340px">
              Clearly marked artists’ <span style="color: #fff">Availability, Rating, and Price Range.</span></div>
            <el-row>
              <el-col :span="12" class="hand-pick">
                <div class="headline">Availability</div>
                <div class="describe">We understand check every freelancer’s availability and price range could be time-consuming. Available designers rank on the top of search results. If the artists that you want to work with are not available, you can see their soonest available time.</div>
              </el-col>
              <el-col :span="12" class="advance-technology">
                <div class="headline">Work Attitude And Price Range</div>
                <div class="describe">Rating system helps you to know designers rating provided by previous hirers. We help you compare designers price with industry standard price.</div>
              </el-col>
            </el-row>
            <div class="img-container">

              <div style="width: 360px; height: 310px; overflow: hidden;">
                <img src="~@/assets/images/why-slider-second1.png" alt="" width="362px" style="transform: translateY(-2px);">
              </div>
              <div style="width: 360px; height: 273px; overflow: hidden;">
                <img src="~@/assets/images/why-slider-second2.png" alt="" width="360px" style="transform: translateY(-2px);">
              </div>
              <div style="width: 360px; height: 90px; overflow: hidden;">
                <img src="~@/assets/images/why-slider-second3.png" alt="" style="transform: translateY(-2px);">
              </div>

            </div>
          </div>
        </div>
        <!--four-pannel-third-->
        <div class="main-container" id="four-pannel-third" v-if="whyIndex === 2">
          <div class="main-content">
            <div class="title">WHY HIRERS LOVE US?</div>
            <div class="context">Advanced search, the most popular designers rank on the top.</div>
            <el-row>
              <el-col :span="24" class="hand-pick">
                <div class="headline">We Encourage A Players</div>
                <div class="describe" style="width: 350px;">Search filter enables hirers to discover creatives by rating provided by previous hirers, availability, experience, rate, location, and skills. We feature best performers.</div>
              </el-col>
            </el-row>
            <div class="img-container">
              <div style="width: 360px; height: 280px; overflow: hidden; ">
                <img src="~@/assets/images/why-slider-second2.png" alt="" width="362px" style="transform: translateY(-2px);">
              </div>
              <div style="width: 280px; height: 340px; overflow: hidden;">
                <img src="~@/assets/images/why-slider-third2.png" alt="" width="280px" style="transform: translateY(-2px);">
              </div>

            </div>
          </div>
        </div>
        <!--four-pannel-fourth-->
        <div class="main-container" id="four-pannel-fourth" v-if="whyIndex === 3">
          <div class="main-content">
            <div class="title">WHY HIRERS LOVE US?</div>
            <div class="context">What services are we providing?</div>
            <el-row>
              <el-col :span="12" class="hand-pick">
                <div class="headline">Find Freelance/
                  Full-time Artists Fast
                </div>
                <div class="describe">You can find designers and artists ranging from Advertising, Design, Game, Technology Development, Animation, Feature film production, Drawing, Photography, and Writing etc.</div>
              </el-col>
              <el-col :span="12" class="advance-technology">
                <div class="headline">One-Stop Service Art
                  Agency
                </div>
                <div class="describe">Tell us about your project, our own creative agency team provides full-service design from idea generation to production completion with selected long-term cooperated best designers from our patform.</div>
              </el-col>
            </el-row>
            <div class="img-container">

              <div style="width: 340px; height: 540px; overflow: hidden;  ">
                <img src="~@/assets/images/why-slider-fourth.png" alt="" width="553px" style="transform: translateX(-36px); margin-top: -6px">
              </div>

            </div>
          </div>
        </div>
        <!--end-slide-->
      </div>
      <div class="next-content"></div>
    </section>

    <section class="five">
      <div class="refer"><span>REFER</span></div>
      <div class="btn-arrow">
        <span class="arrow-down-right"></span>
      </div>
      <!--start-slide-->
      <div class="slide-container">
        <div class="next-arrow-container" @click="referNextPannal">
          <div class="next-arrow"></div>
        </div>
        <div class="last-arrow-container" @click="referLastPannal">
          <div class="last-arrow"></div>
        </div>
        <ul class="indicators">
          <li @click="referIndex = 0" v-bind:class="{ active: referIndex === 0 }"></li>
          <li @click="referIndex = 1" v-bind:class="{ active: referIndex === 1 }"></li>
          <li @click="referIndex = 2" v-bind:class="{ active: referIndex === 2 }"></li>
          <li @click="referIndex = 3" v-bind:class="{ active: referIndex === 3 }"></li>
        </ul>
        <!--five-pannel-first-->
        <div class="border-content" id="five-pannel-first" v-if="referIndex === 0">
          <div class="text">
            <div class="headline">TRY & REFER</div>
            <div class="context">Refer friends,get $20 commission fee discount for both you and your friends.</div>
          </div>
          <div class="description-one">
            <div>Get the first job for free</div>
            <div>We would like you to explore our product, try to use the product for free for the first time.</div>
          </div>
          <div class="description-two">
            <div>Traditional agency charge 30%,we only charge 10% commission fee</div>
            <div>In Designer's first $500 received design fee,we charge freelancers 20% commission fee. Wheb designer
              receives total design fee from $500-$10,000,we charge 10% commission fee. When designer receives totall
              design fee higher than $10,000,we only charge 5%.
            </div>
          </div>
          <div class="description-three">
            <div>Refer more, save more</div>
            <div>After your friends finish registration,you and your firends both will receive an email of $20
              discount code for the commission fee.
            </div>
          </div>
          <div class="img-container">
            <div style="width: 340px; height: 540px; overflow: hidden; ">
              <img src="~@/assets/images/circle_lady.png" alt="" width="500px" style="transform: translateX(-140px) translateY(-30px)">
            </div>
          </div>
          <div class="decorate-line"></div>
        </div>
        <!--five-pannel-second-->
        <div class="border-content" id="five-pannel-second" v-if="referIndex === 1">
          <div class="text">
            <div class="headline">EASILY MANAGE ENTIRE PRODUCTION CYCLE WITH OUR MANAGEMENT TOOL</div>
          </div>
          <div class="description-one">
            <div>Track every production</div>
            <div>Track every job production process. Freelancers are able to remind hirers to review design updates.</div>
          </div>
          <div class="description-two">
            <div>Get payments on time</div>
            <div>Deposit payments from employers will be made on the web after signed contract. We keep payment safe.</div>
            <div>Designers get paid by work progression. Hirers and designer have agreement on revisions milestone and review date. For example, once the first review is done, designers receive 30% of the total design fee.</div>
          </div>
          <div class="description-three">
            <div>Easily handle contract & NDA</div>
            <div>We provide standardized contract and none disclosure agreement. You can change the contract by easily enter several key informatio.</div>
          </div>
          <div class="img-container">
            <div style="width: 340px; height: 470px; overflow: hidden; ">
              <img src="~@/assets/images/refer-slider-second1.png" alt="" width="342px" style="">
            </div>
            <div style="width: 540px; height: 150px; overflow: hidden;">
              <img src="~@/assets/images/refer-slider-second2.png" alt="" width="540px" style="">
            </div>
          </div>
          <div class="decorate-line"></div>
        </div>
        <!--five-pannel-third-->
        <div class="border-content" id="five-pannel-third" v-if="referIndex === 2">
          <div class="text">
            <div class="headline">MAKE EVERYTHING ORGANIZED</div>
          </div>
          <div class="description-one">
            <div>Built-in chat box</div>
            <div>Designers are able to talk and share docs with hirers within the built-in chat box, instead of lost in thousands of emails. Designers submit files under the same chat box, get files fast and organized.</div>
          </div>
          <div class="description-two">
            <div>Change per design for 3 times</div>
            <div>Hires can ask changes/revisions per job for 3 times. If more changes/revisions are needed, hirers and designers need to have an agreement and update the contract.</div>
          </div>
          <div class="description-three">
            <div>Work calendar</div>
            <div>Work Calendar reminds you when is the deadline and countdown how many days left for the jobs.</div>
          </div>
          <div class="img-container">
            <div style="width: 500px; height: 358px; overflow: hidden;">
              <img src="~@/assets/images/refer-slider-third.png" alt="" width="513px" style="transform: translateY(-1px) translateX(-1px)">
            </div>
          </div>
          <div class="decorate-line"></div>
        </div>
        <!--five-pannel-fourth-->
        <div class="border-content" id="five-pannel-fourth" v-if="referIndex === 3">
          <div class="text">
            <div class="headline">LASER FOCUSED DESIGNER PLATFORM</div>
          </div>
          <div class="description-one">
            <div>The Laser focused</div>
            <div style="margin-bottom: 15px">We are striving to improve your art and design work experiences! :)</div>
            <div style="margin-bottom: 15px">Unlike other freelancer platforms, we are proud to laser-focused on art and design and provide creative solutions.</div>
            <div>As a designer, you definitely know the pain of revision, or even cannot receive payment on time etc. We are helping you solve it with our online management tool.</div>
          </div>
          <div class="description-two">
            <div>Large space to showcase your portfolio</div>
            <div>Specifically designed personal profile and portfolio page help you attract more attention. Let your work speak, instead of using long and boring words.</div>
          </div>
          <div class="img-container">
            <div style="width: 440px; height: 320px; overflow: hidden;">
              <img src="~@/assets/images/refer-slider-fourth1.png" alt="">
            </div>
            <div style="width: 440px; height: 320px; overflow: hidden; ">
              <img src="~@/assets/images/refer-slider-fourth2.png" alt="">
            </div>
          </div>
          <div class="decorate-line"></div>
        </div>
        <!--end-slide-->
      </div>
    </section>

    <section class="six">
      <div class="title">Users & Founding Team</div>
      <div class="circle"></div>
      <!--start-slide-->
      <div class="slide-container">
        <div class="next-arrow-container" @click="teamNextPannal">
          <div class="next-arrow"></div>
        </div>
        <div class="last-arrow-container" @click="teamLastPannal">
          <div class="last-arrow"></div>
        </div>
        <ul class="indicators">
          <li @click="teamIndex = 0" v-bind:class="{ active: teamIndex === 0 }"></li>
          <li @click="teamIndex = 1" v-bind:class="{ active: teamIndex === 1 }"></li>
          <li @click="teamIndex = 2" v-bind:class="{ active: teamIndex === 2 }"></li>
          <li @click="teamIndex = 3" v-bind:class="{ active: teamIndex === 3 }"></li>
        </ul>
        <!--six-pannel-first-->
        <div class="main-container" id="six-pannel-first" v-if="teamIndex === 0">
          <div class="border-container">
            <div class="text">
              Our mission is to connect pro creators from worldwide. We belive hirers should find suitable
              designer easy and fast. Designers should be treated better. Our team is working so hard in order to achieve that goal.
            </div>
            <div class="text-bottom">
              <span>Ada L</span>
              <div>Co-founder & CEO of Share Creators inc.</div>
            </div>
            <div class="img-container">
              <div class="img">
                <img src="~@/assets/images/six-slider-1.png" alt="">
              </div>
              <div class="decorate-line"></div>
            </div>
            <div class="border"></div>
            <div class="semicolon">
              <img src="~@/assets/images/home-semicolon.png" alt="" width="160px">
            </div>
          </div>
        </div>
        <!--six-pannel-second-->
        <div class="main-container" id="six-pannel-second" v-if="teamIndex === 1">
          <div class="border-container">
            <div class="text">
              I love how Creativer works! It helps me found a wonderful freelance work, and get paided instantly.
            </div>
            <div class="text-bottom">
              <span>Yaya Xu</span>
              <div>Award-Winning Designer in NYC</div>
            </div>
            <div class="img-container">
              <div class="img">
                <img src="~@/assets/images/six-slider-2.png" alt="">
              </div>
              <div class="decorate-line"></div>
            </div>
            <div class="border"></div>
            <div class="semicolon">
              <img src="~@/assets/images/home-semicolon.png" alt="" width="160px">
            </div>
          </div>
        </div>
        <!--six-pannel-third-->
        <div class="main-container" id="six-pannel-third" v-if="teamIndex === 2">
          <div class="border-container">
            <div class="text">
              I think the product tool helps me solve a lot of freelance work problems, I would like
              to continue using it.
            </div>
            <div class="text-bottom">
              <span>Amelia Chen</span>
              <div>Motion Graphic Designer in NYC</div>
            </div>
            <div class="img-container">
              <div class="img">
                <img src="~@/assets/images/six-slider-3.png" alt="">
              </div>
              <div class="decorate-line"></div>
            </div>
            <div class="border"></div>
            <div class="semicolon">
              <img src="~@/assets/images/home-semicolon.png" alt="" width="160px">
            </div>
          </div>
        </div>

        <!--six-pannel-fourth-->
        <div class="main-container" id="six-pannel-fourth" v-if="teamIndex === 3">
          <div class="border-container">
            <div class="text">
              We believe design production tools should be efficient, let creators focused on creativity itself. Our art and design freelancer platform connect/ manage design pros Online & Offline from worldwide seamlessly.
            </div>
            <div class="text-bottom">
              <span>Hui Yang</span>
              <div>Co-founder & CEO of Share Creators inc.</div>
            </div>
            <div class="img-container">
              <div class="img" style="background-color: #E85022">
                <img src="~@/assets/images/fourth.png" alt="" style="height:510px; transform: translate(40px, -60px)">
              </div>
              <div class="decorate-line"></div>
            </div>
            <div class="border"></div>
            <div class="semicolon">
              <img src="~@/assets/images/home-semicolon.png" alt="" width="160px">
            </div>
          </div>
        </div>
        <!--end-slide-->
      </div>
    </section>
  </div>
</template>

<script>
  import CategoryBar from '../../common/CategoryBar.vue'

  export default {
    components: {
      CategoryBar
    },
    data() {
      return {
        whyIndex: 0,
        referIndex: 0,
        teamIndex: 0
      }
    },
    computed: {
      // whyIndex() {
      //   return this.whyIndex
      // },
      // referIndex() {
      //   return this.referIndex
      // },
      // teamIndex() {
      //   return this.teamIndex
      // }
    },
    methods: {
      whyNextPannal() {
        this.whyIndex < 3 ? this.whyIndex++ : this.whyIndex = 0
      },
      whyLastPannal() {
        this.whyIndex > 0 ? this.whyIndex-- : this.whyIndex = 3
      },
      referNextPannal() {
        this.referIndex < 3 ? this.referIndex++ : this.referIndex = 0
      },
      referLastPannal() {
        this.referIndex > 0 ? this.referIndex-- : this.referIndex = 3
      },
      teamNextPannal() {
        this.teamIndex < 3 ? this.teamIndex++ : this.teamIndex = 0
      },
      teamLastPannal() {
        this.teamIndex > 0 ? this.teamIndex-- : this.teamIndex = 3
      }
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  @mixin arrow($color) {
    display: inline-block;
    width: 24px;
    height: 2px;
    background: $color;
    position: relative;
    top: -4px;
    left: 7px;
    transform: rotateZ(45deg);
    &:before, &:after {
      content: "";
      display: block;
      width: 16px;
      height: 2px;
      background: $color;
      position: absolute;
      top: 5px;
      left: -2px;
      transform: rotateZ(45deg);
    }
    &:after {
      top: -5px;
      transform: rotateZ(135deg);
    }
  }

  @mixin decorate-line() {
    width: 5px;
    height: 26px;
    background: white;
    &:after {
      content: '';
      display: block;
      width: 15px;
      height: 5px;
      background: white;
      position: relative;
      top: 10px;
      left: 1px;
    }
  }

  @mixin last-arrow() {
    width: 36px;
    height: 3px;
    background: #fff;
    transform: rotateZ(-45deg);
    &:before {
      content: "";
      display: block;
      width: 36px;
      height: 3px;
      background: #fff;
      position: relative;
      left: -17px;
      top: 17px;
      transform: rotateZ(90deg);
    }
  }

  @mixin next-arrow() {
    @include last-arrow();
    transform: rotateZ(135deg);
  }

  @mixin indicators($top, $left, $bgcolor) {
    position: absolute;
    top: $top;
    left: $left;
    width: 140px;
    li {
      display: inline-block;
      width: 10px;
      height: 10px;
      margin: 10px;
      border-radius: 50%;
      background-color: rgba(255, 255, 255, 0.4);
      &:hover {
        cursor: pointer;
        background-color: $bgcolor;
      }
      &.active {
        background-color: $bgcolor;
      }
    }
  }

  .home {
    min-width: 1200px;
    text-align: center;
  }

  .first {
    background: #18baa1;
    height: 94vh;
    /*min-height: 1000px;*/
    box-sizing: border-box;
    /*padding: 94px 0px 90px 0px;*/
    padding: 6vh 0px;
    .border-content {
      /*border: 16px solid #fff;*/
      border: 2.5vh solid #fff;
      display: inline-block;
      width: 75vh;
      /*min-width: 500px;*/
      height: 63vh;
      /*min-height: 500px;*/
      /*padding: 50px 6px 40px 20px;*/
      padding: 7vh 0vh 6vh 4vh;
      text-align: left;
      /*transform: translateX(-140px);*/
      transform: translateX(-16vh);
      position: relative;
      &:before {
        content: '';
        display: block;
        width: 40px;
        height: 40px;
        background: #fff;
        position: absolute;
        left: -58px;
        bottom: -58px;
      }
      .text {
        position: relative;
        left: 40px;
        color: #333;
        font-size: 6.4vh;
        font-weight: 900;
        /*transform: translateX(6vh);*/
        div {
          margin-bottom: 2vh;
        }
        .bg-yellow {
          display: inline-block;
          background: $yellow;
          padding: 0px 10px 0px 6px;
          transform: translateX(-0.6vh);
        }
      }
      .btn-container {
        position: relative;
        left: 40px;
        margin-top: 6vh;
        .hire-pros,.join-as{
          width: 26.8vh;
          height: 5.8vh;
          line-height: 4.8vh;
        }
        .hire-pros {
          position: relative;
          /*width: 210px;*/
          /*height: 40px;*/
          /*line-height: 40px;*/
          background: #305DFF;
          border: 0.3vh solid #305DFF;
          /*margin-bottom: 10px;*/
          margin-bottom: 1.8vh;
          .context {
            background: #ffffff;
            display: inline-block;
            /*width: 170px;*/
            width: 21.4vh;
            line-height: 5.7vh;
            text-align: center;
            color: #305DFF;
            font-weight: bold;
          }
          .icon {
            color: #ffffff;
          }
          &:after, &:before {
            display: block;
            content: '';
            width: 2px;
            height: 16px;
            position: absolute;
            right: -10px;
            top: -30px;
            background: #FFF95C;
          }
          &:before {
            transform: rotateZ(90deg);
            right: -24px;
            top: -10px;
          }
        }
        .join-as {
          /*width: 210px;*/
          /*height: 40px;*/
          /*line-height: 40px;*/
          background: #FFF95C;
          /*border: 2px solid #FFF95C;*/
          border: 0.3vh solid #FFF95C;
          position: relative;
          .context {
            background: #305DFF;
            display: inline-block;
            /*width: 170px;*/
            width: 21.4vh;
            line-height: 5.7vh;
            text-align: center;
            color: #FFF95C;
            font-weight: bold;
          }
          .icon {
            color: #305DFF;
          }
          &:after, &:before {
            display: block;
            content: '';
            width: 2px;
            height: 16px;
            background: #fff;
            position: absolute;
            left: -6px;
            top: 60px;
          }
          &:before {
            transform: rotateZ(90deg);
            left: -20px;
            top: 40px;
          }
        }
      }
      .img-container {
        position: absolute;
        right: -34vh;
        bottom: 40px;
        /*padding: 10vh 0 3vh 0;*/
        background: #28b9a1;
        border-top: 12vh solid #28b9a1;
        border-bottom: 3vh solid #28b9a1;
        z-index: -1;
        &:after, &:before {
          display: block;
          content: '';
          width: 2px;
          height: 16px;
          background: #fff;
          position: absolute;
          right: -16px;
          top: 70px;
        }
        &:before {
          transform: rotateZ(90deg);
          right: -30px;
          top: 90px;
        }
        img{
            width: 100%;
          }
        .brand {
          position: absolute;
          right: -2vh;
          width: 25.4vh;
        }
      }
    }
  }

  .second {
    background: #4739a0;
    height: 94vh;
    /*min-height: 800px;*/
    /*padding: 90px 0px 90px 0px;*/
    padding: 5vh 0px;
    box-sizing: border-box;
    position: relative;
    .title {
      color: #fff;
      position: absolute;
      left: 84px;
      top: 50px;
      font-weight: 200;
      font-size: 20px;
      &:before {
        content: '';
        display: block;
        position: absolute;
        left: -84px;
        top: 16px;
        width: 80px;
        height: 2px;
        background: #fff;
      }
    }
    .btn-arrow {
      position: absolute;
      right: 24px;
      top: 46px;
      width: 40px;
      height: 40px;
      box-sizing: border-box;
      border: 2px solid #fff;
    }
    .border-content {
      /*border: 16px solid #fff;*/
      border: 2.5vh solid #fff;
      display: inline-block;
      /*width: 340px;*/
      width: 44vh;
      height: 54vh;
      /*height: 420px;*/
      /*padding: 80px 24px 120px 140px;*/
      padding: 10vh 2vh 12vh 15vh;
      text-align: left;
      /*transform: translateX(110px);*/
      transform: translateX(15vh);
      position: relative;
      color: #fff;
      &:after {
        content: '';
        display: block;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 3px solid #fff;
        position: absolute;
        right: 20px;
        top: 20px;
      }
      .text {
        /*font-size: 42px;*/
        font-size: 6.4vh;
        font-weight: bold;
        /*line-height: 52px;*/
      }
      .description {
        /*margin-top: 120px;*/
        margin-top: 14vh;
        /*padding-top: 32px;*/
        padding-top: 4vh;
        /*font-size: 22px;*/
        font-size: 3.4vh;
        font-weight: lighter;
        position: relative;
        &:before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          width: 40px;
          height: 10px;
          background: #fff;
        }
      }
      .img-container {
        position: absolute;
        /*left: -280px;*/
        left: -42vh;
        /*top: 46px;*/
        top:3.8vh;
        padding: 30px 0;
        background: #473d9d;
        &:after, &:before {
          display: block;
          content: '';
          width: 2px;
          height: 16px;
          background: #fff;
          position: absolute;
          left: -10px;
          bottom: 8px;
        }
        &:before {
          transform: rotateZ(90deg);
          left: -22px;
          bottom: 24px;
        }
        img{
          width: 118%;
          height: 116%;
          transform: translateX(-7.8vh) translateY(-0.3vh);
        }
      }
      .bottom {
        position: absolute;
        bottom: -66px;
        left: -15px;
        .react {
          display: inline-block;
          width: 10px;
          height: 10px;
          background: #4400A0;
          margin-right: 20px;
        }
      }
    }

  }

  .third {
    background: #faab3c;
    position: relative;
    /*padding-top: 134px;*/
    box-sizing: border-box;
    height: 94vh;
    /*min-height: 800px;*/
    padding: 12vh 0px 8vh 0px;
    .title {
      color: #fff;
      position: absolute;
      left: 84px;
      top: 40px;
      font-weight: 200;
      font-size: 22px;
      &:before {
        content: '';
        display: block;
        position: absolute;
        left: -84px;
        top: 18px;
        width: 74px;
        height: 2px;
        background: #fff;
      }
    }
    .btn-arrow {
      position: absolute;
      right: 80px;
      top: 24px;
      width: 120px;
      text-align: right;
      font-size: 34px;
      color: #fff;
      font-weight: bold;
      border-bottom: 4px solid #fff;
      &:after {
        content: "/ / / / /";
        display: block;
        position: absolute;
        right: -50px;
        top: 30px;
        font-size: 14px;
      }
    }

    .border-content {
      /*border: 16px solid #fff;*/
      border: 2.5vh solid #fff;
      display: inline-block;
      /*padding: 30px 0px;*/
      padding: 3vh 0px;
      text-align: left;
      position: relative;
      color: #fff;
      /*transform: translateX(-50px);*/
      transform: translateX(-6vh);
      .video {
        position: relative;
        /*left: 140px;*/
        left: 12vh;
        /*border: 8px solid #faab3c;*/
        border: 1.6vh solid #faab3c;
        box-sizing: border-box;
        iframe {
          margin-bottom: -0.6vh;
          /*width: 830px;*/
          width: 96vh;
          /*height: 500px;*/
          height: 60vh;
        }
        &:after, &:before {
          display: block;
          content: '';
          width: 2px;
          height: 16px;
          background: #fff;
          position: absolute;
          right: -14px;
          top: -22px;
        }
        &:before {
          transform: rotateZ(90deg);
          right: -28px;
          top: -8px;
        }
      }
      &:after, &:before {
        display: block;
        content: '';
        width: 2px;
        height: 16px;
        background: #fff;
        position: absolute;
        right: -24px;
        bottom: -56px;
      }
      &:before {
        transform: rotateZ(90deg);
        right: -42px;
        bottom: -40px;
      }
      .decorate-line {
        @include decorate-line();
        position: absolute;
        bottom: -56px;
        left: -16px;

      }
    }
    .watch {
      position: absolute;
      right: 40px;
      bottom: 30px;
      width: 48px;
      border: 4px solid #000;
      box-sizing: border-box;
      z-index: 22;
      padding-top: 6px;
      .context {
        font-size: 26px;
        word-wrap: break-word;
        letter-spacing: 5px;
        font-weight: bold;
        padding: 4px 2px;
      }
      .arrow-container {
        width: 40px;
        height: 40px;
        background: $yellow;
        border-top: 4px solid #000;
      }
      .arrow-watch {
        @include arrow(#000);
        height: 3px;
        top: 7px;
        left: 1px;
        &:after, &:before {
          height: 3px;
        }

      }

    }
  }

  .four {
    background: #fff;
    /*background: #ed4e53;*/
    position: relative;
    height: 890px;
    .why {
      position: absolute;
      left: -10px;
      top: -28px;
      font-size: 130px;
      font-weight: bold;
      color: #ed4e53;
    }
    .circle {
      position: absolute;
      left: -30px;
      top: 660px;
      width: 50px;
      height: 50px;
      border-radius: 60px;
      border: 6px solid #fff;
      z-index: 2;
    }
    .slide-container {
      display: inline-block;
      position: relative;
      width: 100%;
      .last-arrow-container {
        cursor: pointer;
        position: absolute;
        left: 80px;
        top: 440px;
        width: 100px;
        height: 100px;
        z-index: 99;
        .last-arrow {
          @include last-arrow();
          position: relative;
          left: 30px;
          top: 32px;
        }
      }

      .next-arrow-container {
        cursor: pointer;
        width: 100px;
        height: 100px;
        position: absolute;
        right: 100px;
        top: 440px;
        z-index: 99;
        .next-arrow {
          @include next-arrow();
          position: relative;
          top: 60px;
          left: 30px;
        }
      }

      .indicators {
        @include indicators(30px, 75%, #ed4e53);
        li {
          background-color: rgba(0, 0, 0, 0.4)
        }
      }

    }
    .main-container {
      position: absolute;
      top: 78px;
      padding: 110px 40px;
      width: 100%;
      background: #f04b4f;
      height: 800px;
      box-sizing: border-box;
      transform: translateX(-210px);
      z-index: 1;
    }
    .main-content {
      text-align: left;
      color: #ffffff;
      width: 400px;
      display: inline-block;
      position: relative;
      transform: translateX(-30px);
      .title {
        font-size: 42px;
        width: 260px;
        font-weight: lighter;
        margin-bottom: 80px;
      }
      .context {
        width: 300px;
        color: black;
        font-size: 22px;
        font-weight: 500;
        margin-bottom: 40px;
      }
      .hand-pick, .advance-technology {
        font-size: 14px;
        font-weight: lighter;
        line-height: 22px;
        .headline {
          font-size: 20px;
          margin-bottom: 16px;
        }
        .describe {
          width: 160px;
        }

      }
      .img-container {
        position: absolute;
        left: 440px;
        top: 0px;
        &:after, &:before {
          display: block;
          content: '';
          width: 2px;
          height: 16px;
          background: #fff;
          position: absolute;
          right: -20px;
          top: -30px;
        }
        &:before {
          transform: rotateZ(90deg);
          right: -32px;
          top: -10px;
        }
      }
      &:before {
        content: "";
        display: block;
        width: 40px;
        height: 10px;
        background: #ffffff;
        position: absolute;
        left: -80px;

      }
    }
    .next-content {
      width: 300px;
      height: 640px;
      background: #3b1314;
      position: absolute;
      right: 0px;
      top: 170px;
      z-index: 0;
    }
  }

  .five {
    background: #10a5b5;
    height: 960px;
    padding-bottom: 80px;
    position: relative;
    .refer {
      height: 90px;
      background: white;
      margin-bottom: 100px;
      position: relative;
      overflow: hidden;
      span {
        position: absolute;
        font-size: 130px;
        font-weight: bold;
        color: #21a5b4;
        right: -6px;
        top: -28px;
      }
    }
    .btn-arrow {
      position: absolute;
      left: 24px;
      top: 140px;
      width: 40px;
      height: 40px;
      box-sizing: border-box;
      border: 2px solid #fff;
    }
    .slide-container {
      position: relative;
      display: inline-block;
      width: 970px;
      .next-arrow-container {
        cursor: pointer;
        width: 100px;
        height: 100px;
        position: absolute;
        right: -100px;
        top: 300px;
        .next-arrow {
          @include next-arrow();
          position: relative;
          right: -30px;
          top: 60px;
        }
      }

      .last-arrow-container {
        cursor: pointer;
        width: 100px;
        height: 100px;
        position: absolute;
        left: -100px;
        top: 300px;
        .last-arrow {
          position: relative;
          left: 30px;
          top: 36px;
          @include last-arrow();
        }
      }

      .indicators {
        @include indicators(-50px, 85%, #007673);
      }

    }
    .border-content {
      border: 16px solid #fff;
      /*display: inline-block;*/
      position: absolute;
      width: 940px;
      height: 740px;
      text-align: left;
      color: #fff;
      .text {
        position: absolute;
        left: 404px;
        top: 20px;
        width: 400px;
        z-index: 1;
        color: #fff;

        .headline {
          font-size: 38px;
          color: #FFF95C;
          font-weight: bolder;
        }
        .context {
          font-size: 20px;
          letter-spacing: 1px;
        }
      }
      .description-one, .description-two, .description-three {
        position: absolute;
        right: 90px;
        top: 130px;
        width: 170px;
        div:nth-child(1) {
          font-size: 22px;
          color: #FFF95C;
          position: relative;
          margin-bottom: 8px;
          &:before {
            content: "/";
            display: block;
            position: absolute;
            top: 0px;
            left: -14px;
            font-size: 18px;
          }
        }
        div:nth-child(2) {
          font-size: 14px;
          font-weight: lighter;
          line-height: 20px;
        }
      }
      .description-two {
        position: absolute;
        right: 256px;
        top: 280px;
        width: 210px;
        z-index: 1;
      }
      .description-three {
        position: absolute;
        top: 590px;
        right: 80px;
        width: 250px;
      }
      .img-container {
        position: absolute;
        top: -54px;
        left: 56px;
        border: 38px solid #21a5b4;
        border-top: 0px;
        box-sizing: border-box;
      }
      .decorate-line {
        @include decorate-line();
        position: absolute;
        bottom: -46px;
        left: -6px;
        transform: rotateZ(90deg);

      }
    }
  }

  .six {
    background: #315cff;
    height: 800px;
    position: relative;
    overflow: hidden;
    padding: 140px 0px 0px 0px;
    box-sizing: border-box;
    .title {
      color: #fff;
      position: absolute;
      left: 84px;
      top: 66px;
      font-weight: 200;
      font-size: 22px;
      &:before {
        content: '';
        display: block;
        position: absolute;
        left: -84px;
        top: 22px;
        width: 74px;
        height: 2px;
        background: #fff;
      }
    }
    .circle {
      width: 80px;
      height: 80px;
      border: 6px solid #fff;
      border-radius: 80px;
      position: absolute;
      right: -46px;
      top: 40px;
    }
    .slide-container {
      display: inline-block;
      width: 680px;
      position: relative;
      .next-arrow-container {
        cursor: pointer;
        width: 100px;
        height: 100px;
        position: absolute;
        right: -280px;
        top: 200px;
        .next-arrow {
          @include next-arrow();
          position: relative;
          top: 60px;
          left: 40px;
        }
      }
      .last-arrow-container {
        cursor: pointer;
        width: 100px;
        height: 100px;
        position: absolute;
        left: -280px;
        top: 200px;
        .last-arrow {
          @include last-arrow();
          position: relative;
          top: 40px;
          left: 20px;
        }
      }

      .indicators {
        @include indicators(145px, 110%, #0000E1);
      }

    }
    .main-container {
      position: absolute;
      top: 0px;
      left: 0px;

    }
    .border-container {
      position: relative;
      /*display: inline-block;*/
      width: 680px;
      height: 500px;
      padding: 100px 300px 0px 130px;
      box-sizing: border-box;
      color: #fff;
      text-align: left;
      position: relative;
      transform: translateX(-148px);
      &:before {
        display: block;
        content: '';
        width: 2px;
        height: 60px;
        background: #fff;
        position: absolute;
        right: -44px;
        top: -64px;
      }
      &:after {
        display: block;
        content: '/////';
        width: 2px;
        position: absolute;
        right: -50px;
        top: -8px;
        transform: rotateZ(90deg);
      }
      .text {
        width: 220px;
        height: 360px;
        line-height: 26px;
      }
      .text-bottom {
        position: absolute;
        bottom: 30px;
        font-style: italic;
        &:before {
          display: block;
          content: '';
          width: 2px;
          height: 50px;
          background: rgba(255, 255, 255, 0.4);
          position: absolute;
          left: -20px;
          top: 4px;
        }
      }
      .img-container {
        position: absolute;
        top: 200px;
        left: 430px;
        .img {
          width: 610px;
          height: 340px;
          overflow: hidden;
          img {
            height: 340px;
          }
        }
        &:after, &:before {
          display: block;
          content: '';
          width: 2px;
          height: 16px;
          background: #fff;
          position: absolute;
          left: -2px;
          top: -30px;
        }
        &:before {
          transform: rotateZ(90deg);
          left: -22px;
          top: -16px;
        }
        .decorate-line {
          @include decorate-line();
          position: absolute;
          bottom: -10px;
          right: -30px;
          transform: rotateZ(-90deg);
        }
      }
      .border {
        position: absolute;
        top: 0px;
        bottom: 0px;
        left: 0px;
        right: 0px;
        border: 16px solid #fff;
      }
      .semicolon {
        position: absolute;
        top: 10px;
        left: 30px;
      }
    }
  }

  #four-pannel-second {
    .img-container {
      div:nth-child(2) {
        position: relative;
        left: -50px;
        top: -40px;
      }
      div:nth-child(3) {
        position: relative;
        left: -80px;
        top: -60px;
        img {
          height: 42px;
          position: relative;
          left: -20%;
        }
      }
    }
  }

  #four-pannel-third {
    .img-container {

      div:nth-child(1) {

      }
      div:nth-child(2) {
        position: relative;
        left: -50px;
        top: -90px;
      }
    }
  }

  #five-pannel-second {
    .text {
      left: 40px;
      top: 380px;
      width: 290px;
    }
    .description-one {
      top: 380px;
      right: 50px;
      width: 360px;
    }
    .description-two {
      top: 470px;
      right: 10px;
      width: 400px;
    }
    .description-three {
      top: 636px;
      right: 30px;
      width: 380px;
    }
    .img-container {
      top: -104px;
      width: 416px;
      height: 510px;
      div:nth-child(2) {
        position: relative;
        left: 120px;
        top: -290px;
      }
    }
  }

  #five-pannel-third {
    .text {
      left: 40px;
      top: 380px;
      width: 560px;
    }
    .description-one {
      top: 470px;
      left: 204px;
      width: 180px;
    }
    .description-two {
      top: 470px;
      right: 264px;
      width: 210px;
    }
    .description-three {
      top: 470px;
      right: 30px;
      width: 180px;
    }
    .img-container {
      left: 10px;
    }
  }

  #five-pannel-fourth {
    .text {
      width: 300px;
      top: 60px;
      left: 460px;
    }
    .description-one {
      top: 220px;
      right: 40px;
      width: 260px;
      div:nth-child(2), div:nth-child(3), div:nth-child(4) {
        font-size: 14px;
        font-weight: lighter;
        line-height: 20px;
      }
    }
    .description-two {
      top: 520px;
      right: 140px;
      width: 280px;
    }
    .img-container {
      left: 10px;
      img {
        height: 320px;
        position: relative;
        left: -15%;
      }
      div:nth-child(1) {
        margin-bottom: 20px;
      }
    }

  }

  .arrow-white {
    @include arrow($white)
  }

  .arrow-blue {
    @include arrow($ultramarine)
  }

  .arrow-down-left {
    @include arrow($white);
    transform: rotateZ(-45deg);
    top: 4px;
    left: 0px;
  }

  .arrow-down-right {
    @include arrow($white);
    transform: rotateZ(-135deg);
    top: 4px;
    left: 0px;
  }


</style>
