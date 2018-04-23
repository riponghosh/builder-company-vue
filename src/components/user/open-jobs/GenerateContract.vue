<template>
  <div v-if="true" class="generate">
    <p class="title">Generate Contract</p>
    <el-form :model="form" label-position="top">
      <el-row :gutter="80">
        <el-col :span="8">
          <el-form-item label="Project Name" prop="name">
            <el-input v-model="form.name"></el-input>
          </el-form-item>
          <el-form-item label="Price" prop="price">
            <el-input v-model="form.price"></el-input>
          </el-form-item>
          <el-form-item label="Deadline" prop="deadline">
            <el-date-picker v-model="form.deadline" type="date"></el-date-picker>
          </el-form-item>
        </el-col>
        <el-col :span="12" :offset="4">
          <el-form-item label="Review Times" prop="reviewTimes">
            <el-input-number v-model="form.reviewTimes" :min="1" :max="5"></el-input-number>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row>
        <p style="color: #888; margin-bottom: 80px;">Please note: We provide default version of design contract and NDA, please carefully read through. If you have other requirements that not included or different in the contract, please communicate with designer and upload your own version of the contract. Our website will not take the legal responsibility for the dispute between employess and employers. </p>
      </el-row>
      <el-row class="btn-container">
        <el-button type="primary" @click="submit">Generate Contract</el-button>
      </el-row>
    </el-form>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        form: {
          name: this.$store.state.openJob.job.project_name,
          price: this.$store.state.openJob.job.budget,
          deadline: '',
          reviewTimes: null,
        },
      };
    },
    computed: {
      id() {
        return this.$route.params.id
      },
      data() {
        return this.$store.state.openJob
      },
    },
    methods: {
      async submit() {
        const id = this.$route.params.id
        const data = await this.$http.post(`/open-jobs/${id}/generate-contract`, {
          price: this.form.price,
          deadline: this.form.deadline,
          review_count: this.form.reviewTimes,
        })
        window.location.reload()
      },
    },
  }
</script>

<style lang="scss" scoped>
  @import "../../../assets/styles/base.scss";

  .generate {
    padding: 40px;
    background-color: #ddd;
    p.title {
      font-size: 1.25rem;
      font-weight: 500;
    }
    .btn-container {
      text-align: center;
      .el-button {
        background-color: $black;
        color: $white;
      }
    }
  }

  .el-form {
    /deep/ {
      .el-form-item__label {
        padding: 0;
        color: $black;
        line-height: 30px;
      }
      .el-date-editor, .el-select {
        width: 100%;
      }
      .el-button {
        border-radius: 0;
        border: 0;
      }
    }
  }
</style>
