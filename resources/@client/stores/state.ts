import { defineStore } from 'pinia';

interface Breadcrumb {
	depth: number;
	crumbs: {
		label: string;
		link: string;
	}[];
}

export const useStateStore = defineStore('state', {
	state: () => {
		return {
			status: localStorage.getItem('status') || '',
			message: localStorage.getItem('message') || '',
			breadcrumb: JSON.parse(localStorage.getItem('breadcrumb') || '{"depth": 0, "crumbs": [{"label": "ORKv4 Dashboard", "link": "/"}]}') as Breadcrumb
		};
	},
	actions: {
		storeState(status: string, message: string) {
			localStorage.setItem('status', status);
			localStorage.setItem('message', message);
			this.status = status;
			this.message = message;
		},
		storeBreadcrumb(depth: number, label: string, link: string) {
			const newCrumb = {
				label: label,
				link: link
			};
			if (depth > this.breadcrumb.depth) {
				this.breadcrumb.depth = depth;
				this.breadcrumb.crumbs.push(newCrumb);
			} 
			else if (depth === this.breadcrumb.depth) {
				this.breadcrumb.crumbs[this.breadcrumb.crumbs.length - 1] = newCrumb;
			} 
			else {
				this.breadcrumb.crumbs.splice(depth + 1);
				this.breadcrumb.depth = depth;
			}
		}
	}
});
