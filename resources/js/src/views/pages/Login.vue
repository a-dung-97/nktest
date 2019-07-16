<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="6">
          <b-card-group>
            <b-card no-body class="p-4">
              <b-card-body>
                <b-alert fade v-if="error" show variant="danger">Tài khoản hoặc mật khẩu không</b-alert>
                <b-form>
                  <h1 class="text-center">THPT NGUYỄN KHUYẾN</h1>
                  <p class="text-muted text-center">Đăng nhập để sử dụng hệ thống</p>
                  <b-input-group class="mb-3">
                    <b-input-group-prepend>
                      <b-input-group-text>
                        <i class="icon-user"></i>
                      </b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input
                      id="email"
                      name="email"
                      v-model="$v.form.email.$model"
                      :state="$v.form.email.$dirty ? !$v.form.email.$error : null"
                      aria-describedby="email-feedback"
                      placeholder="Nhập email"
                    />
                    <b-form-invalid-feedback id="email-feedback">Bạn cần nhập một địa chỉ email</b-form-invalid-feedback>
                  </b-input-group>
                  <b-input-group class="mb-4">
                    <b-input-group-prepend>
                      <b-input-group-text>
                        <i class="icon-lock"></i>
                      </b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input
                      id="password"
                      name="password"
                      type="password"
                      v-model="$v.form.password.$model"
                      :state="$v.form.password.$dirty ? !$v.form.password.$error : null"
                      aria-describedby="password-feedback"
                      placeholder="Nhập mật khẩu"
                    />
                    <b-form-invalid-feedback id="password-feedback">Bạn chưa nhập mật khẩu</b-form-invalid-feedback>
                  </b-input-group>
                  <button
                    type="submit"
                    class="btn btn-primary d-block mx-auto"
                    @click.prevent="submit"
                  >Đăng nhập</button>
                </b-form>
              </b-card-body>
            </b-card>
          </b-card-group>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, minLength, email } from "vuelidate/lib/validators";
import { setTimeout } from "timers";
export default {
  name: "Login",
  mixins: [validationMixin],
  data() {
    return {
      form: {
        email: "",
        password: ""
      },
      error: false
    };
  },
  validations: {
    form: {
      email: {
        required,
        email
      },
      password: {
        required
      }
    }
  },
  methods: {
    submit() {
      this.$v.form.$touch();
      if (this.$v.form.$anyError) {
        return;
      }
      axios
        .post("/auth/login", this.form)
        .then(res => {
          User.storeAfterLogin(res);
          this.redirectAfterLogin();
        })
        .catch(err => {
          console.log(err.response.data);
          this.form.email = "";
          this.form.password = "";
          this.error = true;
        });
    },
    redirectAfterLogin() {
      switch (User.role()) {
        case "admin":
          this.$router.push("/admin");
          break;
        case "teacher":
          this.$router.push("/teacher");
          break;
        default:
          this.$router.push("/student");
          break;
      }
    }
  },
  watch: {
    error: function(value) {
      if (value == true) setTimeout(() => (this.error = false), 2000);
    }
  }
};
</script>
