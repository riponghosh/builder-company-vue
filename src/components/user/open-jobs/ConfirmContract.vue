<template>
  <div v-if="true">
    <textarea>
      Client: Name & Email
      Project: Project Name & Type
      Date: 00/00/00
      Designer: Your Name & Email

      This agreement (the “Agreement”) is made on “Date” by and between the “Client” and the “Designer.” In consideration of the mutual agreement made herein, both parties agree as follows:

      Work: The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.The Designer agrees to produce project materials (the “Work”) at the request of the client for fees agrees upon in advance and delivery of the Work by an agreed-upon deadline. Designer agrees that he will be the sole author of the Work, which will be original work and free of plagiarism. Designer will cooperate with Client in editing and otherwise reviewing the Work prior to completion and launch.

      Confidentiality: Designer acknowledges that he may receive or have access to information which relates to the Client’s past, present, or future products, vendor lists, creative works, marketing strategies, pending projects/proposals, and other proprietary information. Designer agrees to protect the confidentiality of the Client’s proprietary information and all physical forms thereof, whether disclosed to Designer before this Agreement is signed or afterward. Unless strict confidentiality is requested by Client in advance of the establishment of this contract, Designer can display materials and final work created for Client on the Designer’s website (http://[yourwebsite]).

      Compensation: Client agrees to pay Designer 50% of the total project cost before any services are provided, and the remaining 50% is to be paid before any workable files are delivered. If the parameters of the Work change, or if it involves more time than estimated, Designer will inform Client and they can renegotiate the Work’s cost. Designer is responsible for the payment of all federal, state, and/or local taxes with respect to the services he performs for the client as an independent contractor. The Client will not treat Designer as an employee for any purpose.

      Client Approval: Upon acceptance of the Work, Client accepts responsibility for any further processes in which this work is used (e.g. film outpost, printing, etc.) Designer is not responsible for errors occurring in this work or projects related to this work after acceptance of the Work by the Client.

      Cancellation: Both parties understand that Client or Designer may terminate the service at any time if, for any reason, the relationship is deemed unsatisfactory by either party. Upon written or verbal cancellation, Client is responsible for payment for all expenses incurred and any work done towards the completion of the project based on the percentage of the project completed that is determined by Designer. Should Client cancel the project following its completion, Client is responsible for full payment as per the agreed upon estimate plus all expenses incurred. In the event of cancellation, Designer retains ownership of all copyrights and original work created.

      Acceptance of Terms: Client promises to pay for the services rendered by Designer for the Work as agreed upon. By signing below, Client agrees they have read, understood, and are considered legally bonded to these terms.

      Client signature & date:
    </textarea>
    <div style="text-align: center;">
      <el-button @click="submit">Confirm</el-button>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {}
    },
    methods: {
      async submit() {
        if (this.$store.getters.isArtist) {
          await this.$http.post(`/open-jobs/${this.id}/sign-contract`, {})
          window.location.reload()
          return
        }
        const amount = this.$store.state.openJob.job.budget
        this.$checkout.open({
          name: 'Pay',
          currency: 'USD',
          amount: amount * 100,
          token: (token) => {
            this.$http.post('/user/charge', {
                  amount: amount,
                  source: token.id,
                })
                .then(() => {
                  return this.$http.post(`/open-jobs/${this.id}/sign-contract`, {})
                })
                .then(() => {
                  window.location.reload()
                })
          }
        })
      },
    },
    computed: {
      id() {
        return this.$route.params.id
      },
      data() {
        return this.$store.state.openJob
      },
    },
  }
</script>

<style lang="scss" scoped>
  textarea {
    padding: 20px;
    width: 100%;
    height: 500px;
    box-sizing: border-box;
    line-height: 20px;
  }

  .el-button {
    margin: 20px;
  }
</style>
