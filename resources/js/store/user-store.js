import axios from 'axios'
import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
  state: () => ({
    id: null,
    token: null,
    name:null,
    surname: null,
    login: null,
    email: null,
    image: null,
    roleId: null
  }),
  // could also be defined as
  // state: () => ({ count: 0 })
  actions: {
    async setUserDetails(res) {
        console.log('sdsd', res)
        this.$state.id = res.data.user.id
        this.$state.token = res.data.token
        this.$state.name = res.data.user.name
        this.$state.surname = res.data.user.surname
        this.$state.login = res.data.user.login
        this.$state.email = res.data.user.email
        this.$state.roleId = res.data.user.role_id
        if (res.data.user.image) {
          this.$state.image = 'http://127.0.0.1:8000/images/avatars/' + res.data.user.image
        } else {
          console.log(';sdsd')
          this.$state.image = 'http://127.0.0.1:8000/images/avatars/default.png'
        }
    },

    async fetchUser() {
        let res = await axios.get('api/users/' + this.$state.id)

        this.$state.id = res.data.user.id
        this.$state.name = res.data.user.name
        this.$state.surname = res.data.user.surname
        this.$state.login = res.data.user.login
        this.$state.email = res.data.user.email
        this.$state.roleId = res.data.user.role_id

        if (res.data.user.image) {
          this.$state.image = 'http://127.0.0.1:8000/images/avatars/' + res.data.user.image
        } else {
          this.$state.image = 'http://127.0.0.1:8000/images/avatars/default.png'
        }
    },

    userImage(image) {
        return 'http://127.0.0.1:8000/images/avatars/' + image
    },

    clearUser() {
        this.$state.id = null
        this.$state.token = null
        this.$state.name = null
        this.$state.surname = null
        this.$state.login = null
        this.$state.email = null
    }
  },
  persist: true,
})
