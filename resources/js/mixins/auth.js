let user = document.head.querySelector('meta[name="user"]')

module.exports = {
    computed: {
        user() {
            if (this.isAuthenticated) {
                return JSON.parse(user.content);
            }
        },
        isAuthenticated() {
            return !! user.content
        },
    }
}
