<template>
  <AppHeaderDropdown right no-caret>
    <template slot="header">
      <img :src="url+name" class="img-avatar" alt="admin@bootstrapmaster.com" />
    </template>\
    <template slot="dropdown">
      <b-dropdown-header tag="div" class="text-center">
        <strong class="text-capitalize">{{ role }}</strong>
      </b-dropdown-header>
      <b-dropdown-item>
        <i class="fa fa-bell-o" /> Thông tin tài khoản
      </b-dropdown-item>
      <b-dropdown-item>
        <i class="fa fa-user" /> Đổi mật khẩu
      </b-dropdown-item>
      <b-dropdown-item @click="logout">
        <i class="fa fa-lock" /> Đăng xuất
      </b-dropdown-item>
    </template>
  </AppHeaderDropdown>
</template>

<script>
import { HeaderDropdown as AppHeaderDropdown } from "@coreui/vue";
export default {
  name: "DefaultHeaderDropdownAccnt",
  components: {
    AppHeaderDropdown
  },
  data() {
    return {
      role: User.role(),
      name: User.name(),
      url: "https://ui-avatars.com/api/?name="
    };
  },
  methods: {
    logout() {
      axios
        .post("/auth/logout")
        .then(result => {
          User.logout();
          this.$router.push("/");
        })
        .catch(err => {
          console.log(err.response.data.message);
        });
    }
  }
};
</script>
