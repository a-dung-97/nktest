<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="6">
          <div class="clearfix">
            <h1 class="float-left display-3 mr-4">403</h1>
            <h4 class="pt-3">Rất tiếc, bạn không được truy cập :(</h4>
            <p class="text-muted">Bạn không có quyền để truy cập vào trang.</p>
            <router-link tag="button" class="btn btn-info" to="/">Trang chủ</router-link>
          </div>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
export default {
};
</script>
