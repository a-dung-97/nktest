import Token from "./Token";
import AppStorage from "./AppStorage";

class User {
    showLoginErrors(errors) {
        return errors;
    }
    storeAfterLogin(res) {
        const access_token = res.data.access_token;
        const username = res.data.name;
        const role = res.data.role;
        if (Token.isValid(access_token)) {
            AppStorage.store(username, access_token, role);
            window.axios.defaults.headers.common["Authorization"] = 'Bearer' + ' ' + access_token;
        }
    }
    redirectByRole() {
        return AppStorage.getRole() === 'admin' ? '/admin' : (this.role === 'teacher' ? '/teacher' : '/student');
    }
    hasToken() {
        const storedToken = AppStorage.getToken();
        if (storedToken) {
            return Token.isValid(storedToken) ? true : false;
        }
        return false;
    }
    loggedIn() {
        return this.hasToken();
    }
    logout() {
        AppStorage.clear();
    }
    name() {
        if (this.loggedIn) {
            return AppStorage.getUser()
        }
    }
    role() {
        if (this.loggedIn) {
            return AppStorage.getRole();
        }
    }
    id() {
        if (this.loggedIn()) {
            const payload = Token.payload(AppStorage.getToken())
            return payload.sub
        }
    }
    own(id) {
        return this.id() == id
    }
}
export default User = new User