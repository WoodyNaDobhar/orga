<script setup lang="ts">
	import { useRouter } from 'vue-router';
	import Lucide from "@/components/Base/Lucide";
	import Notification from "@/components/Base/Notification";
	import { useAuthStore } from '@/stores/auth';
	import { useStateStore } from './stores/state';
	import { useColorSchemeStore } from "@/stores/color-scheme";
	import { ref, computed, onMounted } from 'vue';
	import Loading from 'vue-loading-overlay';
	import 'vue-loading-overlay/dist/css/index.css';
	import { getColor } from "@/utils/colors";
	
	const router = useRouter()
	const auth = useAuthStore()
	const state = useStateStore()
	const deviceName = ref(navigator.userAgent)
	const isLoading = computed(() => state?.status === 'loading');
	const colorScheme = computed(() => useColorSchemeStore().colorScheme);
	const iconColor = colorScheme.value ? getColor("primary") : ""
	
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

	setInterval(checkLoginStatus, 5 * 60 * 1000);

	checkLoginStatus();
</script>

<template>
	<RouterView />
	<loading
		v-model:active="isLoading"
	>
		<template #default>
			<svg
				width="20%"
				viewBox="0 0 57 57"
				xmlns="http://www.w3.org/2000/svg"
				class="w-full h-full"
			>
				<g fill="none" fill-rule="evenodd">
					<g transform="translate(1 1)">
						<circle cx="5" cy="50" r="5" :fill="iconColor">
							<animate
								attributeName="cy"
								begin="0s"
								dur="2.2s"
								values="50;5;50;50"
								calcMode="linear"
								repeatCount="indefinite"
							/>
							<animate
								attributeName="cx"
								begin="0s"
								dur="2.2s"
								values="5;27;49;5"
								calcMode="linear"
								repeatCount="indefinite"
							/>
						</circle>
						<circle cx="27" cy="5" r="5" :fill="iconColor">
							<animate
								attributeName="cy"
								begin="0s"
								dur="2.2s"
								from="5"
								to="5"
								values="5;50;50;5"
								calcMode="linear"
								repeatCount="indefinite"
							/>
							<animate
								attributeName="cx"
								begin="0s"
								dur="2.2s"
								from="27"
								to="27"
								values="27;49;5;27"
								calcMode="linear"
								repeatCount="indefinite"
							/>
						</circle>
						<circle cx="49" cy="50" r="5" :fill="iconColor">
							<animate
								attributeName="cy"
								begin="0s"
								dur="2.2s"
								values="50;50;5;50"
								calcMode="linear"
								repeatCount="indefinite"
							/>
							<animate
								attributeName="cx"
								from="49"
								to="49"
								begin="0s"
								dur="2.2s"
								values="49;5;27;49"
								calcMode="linear"
								repeatCount="indefinite"
							/>
						</circle>
					</g>
				</g>
			</svg>
		</template>
		<template #after>
			<h2 class="mr-5 text-lg font-medium truncate" style="text-align: center; margin-top: 25px;">{{ state?.message }}</h2>
		</template>
	</loading>
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