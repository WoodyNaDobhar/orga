import { defineStore } from 'pinia'

export const useStateStore = defineStore('state', {
	state: () => {
		return {
			status: '',
			message: ''
		}
	},
	getters: {
        getState: state => {
			return state.status ? state.status : null
        },
        getMessage: state => {
			return state.message ? state.message : null
        },
	},
	actions: {
		storeState(status, message) {
            const _this = this;
		    localStorage.setItem('status', status);
		    localStorage.setItem('message', message);
		    _this.status = status;
		    _this.message = message;
        }
	},
})