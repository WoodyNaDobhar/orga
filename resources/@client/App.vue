<script setup lang="ts">
	import { useRouter } from 'vue-router';
	import Lucide from "@/components/Base/Lucide";
	import Notification from "@/components/Base/Notification";
	import { useAuthStore } from '@/stores/auth';
	import { useStateStore } from './stores/state';
	import { ref, onMounted } from 'vue';
	import 'vue-loading-overlay/dist/css/index.css';
	import axios from 'axios';
	
	const router = useRouter()
	const auth = useAuthStore()
	const state = useStateStore()
	const deviceName = ref(navigator.userAgent)
	
	onMounted(() => {
		state.storeState('ready', '')
	})
	
	const checkLoginStatus = () => {
		try {
			if(auth.isLoggedIn){
				auth.check({user_id: auth.getUser.id, device_name: deviceName})
					.then(result => {
						if(!result){
							auth.removeLoggedInUser()
							router.push('/login');
						}
					}).catch(error => {
						console.error(error);
						state.storeState('error', error)
					})
			}
		} catch (error:any) {
			console.error('Error checking token: ', error)
			state.storeState('error', error)
		}
	};

	setInterval(checkLoginStatus, 3 * 60 * 1000);

	checkLoginStatus();
	
	axios.interceptors.request.use(
		(config) => {
			const bearerToken = auth.getToken;
			if (bearerToken) {
				config.headers.Authorization = `Bearer ${bearerToken}`;
			}
			return config;
		}
	);
</script>

<template>
	<RouterView />
	<!-- BEGIN: Success Notification Content -->
	<Notification id="success-notification-content" class="flex hidden">
		<Lucide icon="CheckCircle" class="text-success" />
		<div class="ml-4 mr-4">
			<div class="font-medium">Success!</div>
			<div class="mt-1 text-slate-500" id="successMessage">
				Your action was completed sucessfully.
			</div>
		</div>
	</Notification>
	<!-- END: Success Notification Content -->
	<!-- BEGIN: Failed Notification Content -->
	<Notification id="failed-notification-content" class="flex hidden">
		<Lucide icon="XCircle" class="text-danger" />
		<div class="ml-4 mr-4">
			<div class="font-medium">Error!</div>
			<div class="mt-1 text-slate-500" id="failedMessage">Please check the form.</div>
		</div>
	</Notification>
	<!-- END: Failed Notification Content -->
</template>