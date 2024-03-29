import { defineStore } from "pinia";
import axios from 'axios'

export const useAuthStore = defineStore("auth", {
	state: () => ({
		token: localStorage.getItem('token') || null,
		user: localStorage.getItem('user') || null
	}),
	getters: {
        getUser: state => {
			return state.user ? state.user : null
        },
		getToken: state => {
			return state.token ? state.token : null
		},
		isLoggedIn: state => {
			return state.token ? true : false
		},
		pageInfo: state => {
			return {
				STORE_LOGIN: process.env.API_URL + 'api/login',
				LOGOUT: process.env.API_URL + 'api/logout'
			}
		}
	},
	actions: {
		async login (request) {
			try {
				await axios.post(this.pageInfo.STORE_LOGIN, request)
					.then(response => {
						this.user = response.data.data
					})
			} catch (error) {
				throw error.response.data
			}
		},
		async logout() {
			if (!this.user) {
				return true
			}
			// GET THE DATA TO SEND
			try {
				await axios.post(this.pageInfo.LOGOUT)
				this.user = ''
				return true
			} catch (error) {
				throw error.response.data
			}
		},
		storeLoggedInUser(token, user) {
            const _this = this;
		    localStorage.setItem('token', token);
		    localStorage.setItem('user', JSON.stringify(user));
		    _this.token = token;
		    _this.user = JSON.stringify(user);
        }
	},
});