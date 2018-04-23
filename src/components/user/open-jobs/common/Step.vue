<template>
  <div>
    <!-- invite review modal -->
    <el-dialog title="Invite to review" :visible.sync="inviteVisible">
      <el-form :model="inviteForm">
        <el-form-item label="File Link" label-width="100">
          <el-input v-model="inviteForm.fileUrl" auto-complete="off"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button type="default" @click="inviteVisible = false">Cancel</el-button>
        <el-button type="primary" @click="submitInvite">Submit</el-button>
      </div>
    </el-dialog>

    <!-- confirm review modal -->
    <el-dialog title="Are you sure to confirm review?" :visible.sync="confirmVisible">
      <a :href="openJob.reviews[data.index - 1] ? openJob.reviews[data.index - 1].fileUrl : ''" target="_blank">Click to download</a>
      <div slot="footer" class="dialog-footer">
        <el-button type="default" @click="confirmVisible = false">Cancel</el-button>
        <el-button type="primary" @click="submitConfirm">Confirm</el-button>
      </div>
    </el-dialog>

    <!-- contract -->
    <div v-if="isContractStep">
      <div v-if="status === 'ACTIVE'">
        <div v-if="isArtist">
          <div v-if="['WAIT_EMPLOYER_SIGN', null].includes(contractStatus)">
            Artist wait for employer to sign.
          </div>
          <!-- <div v-if="contractStatus === 'WAIT_ARTIST_SIGN'">
            <el-button @click="confirmContractClicked">Sign Contract</el-button>
          </div> -->
        </div>
        <div v-if="isEmployer">
          <!-- <div v-if="contractStatus === null" class="btn-container">
            <el-button @click="generateContractClicked">Generate Contract</el-button>
          </div> -->
          <!-- <div v-if="contractStatus === 'WAIT_EMPLOYER_SIGN'" class="btn-container">
            <el-button @click="confirmContractClicked">Sign Contract</el-button>
          </div> -->
          <div v-if="contractStatus === 'WAIT_ARTIST_SIGN'">
            Employer wait for artist to sign.
          </div>
        </div>
      </div>
      <div v-if="status === 'DONE'">
        Sign contract done.
      </div>
    </div>

    <!-- review -->
    <div v-if="isReviewStep">
      <div v-if="isArtist">
        <div v-if="status === 'WAITING'">
        </div>
        <div v-if="status === 'ACTIVE'">
          <div v-if="contractStatus==='WAIT_ARTIST_INVITE'">
            <el-button @click="inviteVisible = true">Invite to Review</el-button>
          </div>
          <div v-if="contractStatus==='WAIT_EMPLOYER_REVIEW'">
            Wait employer confirm.
          </div>
        </div>
        <div v-if="status === 'DONE'">
          Review done.
        </div>
      </div>
      <div v-if="isEmployer">
        <div v-if="status === 'WAITING'">
        </div>
        <div v-if="status === 'ACTIVE'">
          <div v-if="contractStatus==='WAIT_ARTIST_INVITE'">
            Wait artist invite.
          </div>
          <div v-if="contractStatus==='WAIT_EMPLOYER_REVIEW'">
            <el-button @click="confirmVisible = true">Confirm Review</el-button>
          </div>
        </div>
        <div v-if="status === 'DONE'">
          Review Done.
        </div>
      </div>
    </div>

    <!-- rating -->
    <div v-if="isRatingStep">
      <div v-if="isArtist">
        <div v-if="status === 'ACTIVE'">
          <div v-if="!artistRated && $store.getters.isArtist">
            Rating
          </div>
          <div v-if="artistRated && $store.getters.isArtist">
            Rated
          </div>
          <div v-if="!employerRated">
            Wait employer rate.
          </div>
          <div v-if="employerRated">
            Employer rated.
          </div>
        </div>
      </div>
      <div v-if="isEmployer">
        <div v-if="status === 'ACTIVE'">
          <div v-if="!employerRated && $store.getters.isEmployer">
            Rating
          </div>
          <div v-if="employerRated && $store.getters.isEmployer">
            Rated
          </div>
          <div v-if="!artistRated">
            Wait artist rate.
          </div>
          <div v-if="artistRated">
            Artist rated.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  // WAIT_EMPLOYER_SIGN | WAIT_ARTIST_SIGN
  // WAIT_ARTIST_INVITE | WAIT_EMPLOYER_REVIEW
  // WAIT_RATE
  // FINISHED

  export default {
    props: ['data'],
    data() {
      return {
        confirmVisible: false,
        inviteVisible: false,
        inviteForm: {
          fileUrl: '',
        },
      }
    },
    mounted() {

    },
    computed: {
      ...mapGetters([
        'isArtist',
        'isEmployer',
        'reviewCount',
        'contractStatus',
      ]),
      id() {
        return this.$route.params.id
      },
      status() {
        return this.data.status
      },
      openJob() {
        return this.$store.state.openJob
      },
      isContractStep() {
        return this.data.index === 0
      },
      isReviewStep() {
        return this.data.index > 0 && this.data.index < 1 + this.reviewCount
      },
      isRatingStep() {
        return this.data.index === this.reviewCount + 1
        // return ['WAIT_RATE'].includes(this.contractStatus)
      },
      // haveRated() {
      //   console.log(111,this.openJob.ratings)
      //   if (!this.openJob.ratings) {
      //     return false
      //   }
      //   if (this.$store.getters.isArtist && this.openJob.ratings.find(i => i.from === 'ARTIST')) {
      //     return true
      //   }
      //   if (this.$store.getters.isEmployer && this.openJob.ratings.find(i => i.from === 'EMPLOYER')) {
      //     return true
      //   }
      //   return false
      // },
      artistRated() {
        if (this.openJob.ratings.find(i => i.from === 'ARTIST')) {
          return true
        } else {
          return false
        }
      },
      employerRated() {
        if (this.openJob.ratings.find(i => i.from === 'EMPLOYER')) {
          return true
        } else {
          return false
        }
      }
    },
    methods: {
      generateContractClicked() {
      },
      confirmContractClicked() {
      },
      async submitInvite() {
        const data = await this.$http.post(`/open-jobs/${this.id}/invite-review`, {
          file_url: this.inviteForm.fileUrl,
        })
        window.location.reload()
        this.inviteVisible = false
      },
      async submitConfirm() {
        const data = await this.$http.post(`/open-jobs/${this.id}/confirm-review`)
        window.location.reload()
        this.inviteVisible = false
      },
    },
  }
</script>

<style lang="scss" scoped>
  .btn-container {
    margin-top: 20px;
  }
</style>
