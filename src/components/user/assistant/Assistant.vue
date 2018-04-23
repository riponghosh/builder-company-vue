<template>
  <div class="pd">
    <div><el-button class="btn-black mb_30">Email US</el-button></div>
    <div class="fz_20 lineHeight_30 ">Share Creators Guidence:</div>
    <div class="fz_20 lineHeight_30 mt_20">About deadline:</div>
    <div v-for="item in text.content1" class="lineHeight_30">{{item}}</div>
    <div class="fz_20 lineHeight_30 mt_40">Abotu Design Feedback</div>
    <div v-for="item in text.content2" class="lineHeight_30">{{item}}</div>
    <div class="fz_20 lineHeight_30 mt_40">End the Design In the Middle</div>
    <div class="fz_20 lineHeight_30 ">1: Employers end the contract:</div>
    <div class="lineHeight_30">{{text.content3[0]}}</div>
    <div class="fz_20 lineHeight_30 ">2: Designers end the contract:</div>
    <div class="lineHeight_30">{{text.content3[1]}}</div>
  </div>
</template>

<script>
  export default {
    components: {},
    mounted() {
    },
    data() {
      return {
        text: {
          title: ["About Deadline:", 'About Design Feedback','End The Design In the Middle'],
          content1: [
            '1: Designers must keep the deadline described in the contract. Designers need to have agreement with the employer about 3 review times.',
            '2: Be sure to change the deadline: If both sides agree to change the deadline, both need to resign the contract with the changed new deadline.',
            '3: Missed deadline for 1 day, designers will be charged a fine for 10% of the total design fee. The fine will return to employers. ',
            '4: Missed deadline for 2 days, designers will be charged a fine for 30% of the total design fee. The fine will return to employers. ',
            '5: Missed deadline for 3 days, designers will be charged a fine for 50% of the total design fee. The fine will return to employers. ',
            '6: Missed deadline for 4 days, designers will be charged a fine for 75% of the total design fee. The fine will return to employers. ',
            '7: Missed deadline for 5 days or more, designers will be charged a fine for 75% of the total design fee. The fine will return to employers. ',
            '8: Our platform will charge the original amount of commission fee, no matter the percentage of the fine.',
            '9: Designer cannot finish work on time, will heavily influence their rating, which is the key to search and filter good designers.'
          ],
          content2: [
              '1: After deadline described in the contract for 10 days, if employers didn’t give any feedback, designers will automatically receive the total design fee described in the contract.',
              '2: During the 3 review, if designers invited the employers to review more than 3 days, and employers didn’t provide any feedback, designers will automatically receive the payment according to the review times. For the first review, designers will receive 30% of the total design fee.   For the second review, designers will receive 60% of the total design fee. And for the third review, designers will receive 90% of the design fee.  ',
              '3: If after the first review, employers didn’t respond to the second and third review. After 10 days of the deadline described in the deadline, the designers will receive the total design fee described in the contract.',
          ],
          content3: [
              'If the employers are not satisfied with the design, employers have the right to end the contract. Employers must pay for the the design that had done. Stop the design after the first review, employers must pay for 30% of the design fee. After the second review, employers must pay for 60% of the design fee. After the third review, employers must pay for 90% of the design fee. After the designers submitted the final file, employers must pay for 100% of the design fee. Our platform will charge the original amount of commission fee when contract end in the middle. ',
            ' Designer for some reason, can not complete the design, designers must refund all the design costs to make up for the employer’s losses.'
          ],
        }
      }
    },
    methods: {}
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";
  .btn-black{
    background: black;
    width: 200px;
    color: #fff;
  }
  .lineHeight_30{
    line-height: 30px;
  }
  .lineHeight_40{
    line-height: 40px;
  }
  .pd{
    padding: 40px 80px;
  }
</style>
