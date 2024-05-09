import { defineStore } from "pinia";
import axios from 'axios'

interface User {
	jsPermissions: string;
}

interface CustomWindow extends Window {
	Laravel: {
		jsPermissions: string;
	};
}

declare const window: CustomWindow;

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
				return undefined
			}
		}
	},
	actions: {
		async check(request:any) {
			try {
				const response = await axios.post('/api/check', request)
					.catch(error => {
						console.error(error);
						return {data: {data: true}};
					});
				return response.data.data;
			} catch (error:any) {
				console.error(error);
				return true;
			}
		},
		async login (request:any) {
			try {
				await axios.post('api/login', request)
					.then(response => {
						const token = response.data.data.token
						const user = response.data.data
						this.storeLoggedInUser(token, user)
						return response;
					})
			} catch (error:any) {
				throw error.response.data
			}
		},
		async logout() {
			try {
				await axios.get('api/logout', this.getHeaders)
					.then(response => {
						this.removeLoggedInUser()
						return response
					});
			} catch (error) {
				console.log(error)
				throw error
			}
		},
		storeLoggedInUser(token:string, user:User) {
			const _this = this;
			localStorage.setItem('token', token);
			localStorage.setItem('user', JSON.stringify(user));
			_this.token = token;
			_this.user = JSON.stringify(user);
			window.Laravel.jsPermissions = JSON.parse(user.jsPermissions)
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