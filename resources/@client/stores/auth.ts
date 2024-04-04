import { defineStore } from "pinia";
import axios from 'axios'

export const useAuthStore = defineStore("auth", {
	state: () => ({
		token: localStorage.getItem('token') || null,
		user: localStorage.getItem('user') || null
	}),
	getters: {
				getUser: state => {
			return state.user ? JSON.parse(state.user) : null
				},
		getToken: state => {
			return state.token ? state.token : null
		},
		isLoggedIn: state => {
			return state.token ? true : false
		},
		getHeaders: state => {
			if(state.token){
				return {
					headers: {
						Authorization: `Bearer ${state.token}`
					}
				}
			}else{
				return null
			}
		}
	},
	actions: {
		async login (request) {
			try {
				await axios.post('api/login', request)
					.then(response => {
						const token = response.data.data.token
						const user = response.data.data
						this.storeLoggedInUser(token, user)
						return response;
					})
			} catch (error) {
				throw error.response.data
			}
		},
		async logout(request) {
			try {
				await axios.post('api/logout', request, this.getHeaders)
					.then(response => {
						this.removeLoggedInUser()
						return response
					});
			} catch (error) {
				console.log(error)
				throw error
			}
		},
		storeLoggedInUser(token, user) {
			const _this = this;
			localStorage.setItem('token', token);
			localStorage.setItem('user', JSON.stringify(user));
			_this.token = token;
			_this.user = JSON.stringify(user);
		},
		removeLoggedInUser() {
			const _this = this;
			localStorage.setItem('token', '');
			localStorage.setItem('user', '');
			_this.token = null;
			_this.user = null;
		}
	},
});