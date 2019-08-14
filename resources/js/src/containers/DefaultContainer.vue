<template>
    <div class="app">
        <AppHeader fixed>
            <SidebarToggler class="d-lg-none" display="md" mobile />
            <div class="navbar-brand ml-2 font-weight-bold" style="color:black">NK TEST</div>

            <SidebarToggler
                :disabled="!defaultOpen"
                class="d-md-down-none"
                display="lg"
                :defaultOpen="defaultOpen"
            />
            <b-navbar-nav class="d-md-down-none">
                <b-nav-text
                    v-if="isAdmin"
                    @click="updateSchoolYear"
                    class="font-weight-bold text-muted school-year"
                >Năm học {{ schoolYear }}</b-nav-text>
                <b-nav-text v-else class="font-weight-bold text-muted">Năm học {{ schoolYear }}</b-nav-text>
                <!-- <b-nav-item class="px-3" to="/dashboard">Dashboard</b-nav-item>
        <b-nav-item class="px-3" to="/users" exact>Users</b-nav-item>
                <b-nav-item class="px-3">Settings</b-nav-item>-->
            </b-navbar-nav>
            <b-navbar-nav class="ml-auto">
                <!-- <b-nav-item class="d-md-down-none">
          <i class="icon-bell"></i>
          <b-badge pill variant="danger">5</b-badge>
        </b-nav-item>
        <b-nav-item class="d-md-down-none">
          <i class="icon-list"></i>
        </b-nav-item>
        <b-nav-item class="d-md-down-none">
          <i class="icon-location-pin"></i>
                </b-nav-item>-->
                <b-nav-text class="pr-2 font-weight-bold">{{ username }}</b-nav-text>
                <DefaultHeaderDropdownAccnt class="mr-2" />
            </b-navbar-nav>
            <!-- <AsideToggler class="d-none d-lg-block" /> -->
            <!--<AsideToggler class="d-lg-none" mobile />-->
        </AppHeader>

        <div class="app-body">
            <AppSidebar fixed>
                <SidebarHeader />
                <SidebarForm />
                <SidebarNav :navItems="nav"></SidebarNav>
                <SidebarFooter />
                <SidebarMinimizer />
            </AppSidebar>
            <main class="main">
                <Breadcrumb :list="list" />
                <transition
                    name="router-transition"
                    enter-active-class="animated fadeInLeft fast"
                    leave-active-class="animated fadeOutDown faster"
                    mode="out-in"
                >
                    <router-view @sidebar="toggleSidebar"></router-view>
                </transition>
            </main>
        </div>
        <TheFooter>
            <!--footer-->
            <div>
                <a href="http://nktest.test">NK TEST</a>
                <span class="ml-1">&copy; 2019 THPT Nguyễn Khuyến - TP. Nam Định.</span>
            </div>
            <div class="ml-auto">
                <span class="mr-1">Powered by</span>
                <a href="http://nktest.test">Anh Dũng</a>
            </div>
        </TheFooter>
    </div>
</template>

<script>
import navAdmin from "../nav/admin";
import navTeacher from "../nav/teacher";
import navStudent from "../nav/student";
import {
    Header as AppHeader,
    SidebarToggler,
    Sidebar as AppSidebar,
    SidebarFooter,
    SidebarForm,
    SidebarHeader,
    SidebarMinimizer,
    SidebarNav,
    Aside as AppAside,
    AsideToggler,
    Footer as TheFooter,
    Breadcrumb
} from "@coreui/vue";
import DefaultAside from "./DefaultAside";
import DefaultHeaderDropdownAccnt from "./DefaultHeaderDropdownAccnt";

export default {
    name: "DefaultContainer",
    components: {
        AsideToggler,
        AppHeader,
        AppSidebar,
        AppAside,
        TheFooter,
        Breadcrumb,
        DefaultAside,
        DefaultHeaderDropdownAccnt,
        SidebarForm,
        SidebarFooter,
        SidebarToggler,
        SidebarHeader,
        SidebarNav,
        SidebarMinimizer
    },
    data() {
        return {
            nav: [],
            username: User.name(),
            defaultOpen: true,
            schoolYear: "",
            isAdmin: User.isAdmin()
        };
    },
    created() {
        switch (User.role()) {
            case "admin":
                this.nav = navAdmin.items;
                break;
            case "teacher":
                this.nav = navTeacher.items;
                break;
            default:
                this.nav = navStudent.items;
                break;
        }
        this.getCurrentSchoolYear();
    },
    computed: {
        name() {
            return this.$route.name;
        },
        list() {
            return this.$route.matched.filter(
                route => route.name || route.meta.label
            );
        }
    },
    methods: {
        async getCurrentSchoolYear() {
            try {
                let schoolYear = await axios.get("/schoolyear").then();
                this.schoolYear = schoolYear.data;
            } catch (error) {
                console.log(error);
            }
        },
        async setCurrentSchoolYear() {
            try {
                let schoolYear = await axios.post("/schoolyear").then();
                this.schoolYear = schoolYear.data;
                this.$swal.fire(
                    "Đã chuyển thành công!",
                    "Hệ thống đã được chuyển sang năm học mới.",
                    "success"
                );
            } catch (error) {
                console.log(error);
            }
        },
        updateSchoolYear() {
            this.$swal({
                title: "Chuyển sang năm học mới?",
                text: "Hệ thống sẽ được chuyển sang năm học mới",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "OK!"
            }).then(result => {
                if (result.value) {
                    this.setCurrentSchoolYear();
                }
            });
        },
        test(e) {
            console.log(e);
        },
        toggleSidebar() {
            setTimeout(() => {
                document.body.classList.toggle("sidebar-lg-show");
                this.defaultOpen = !this.defaultOpen;
            }, 0);
        }
    }
};
</script>
<style scoped>
.school-year {
    cursor: pointer;
    font-size: 1rem !important;
}
.school-year:hover {
    color: #0074d9 !important;
}
</style>
