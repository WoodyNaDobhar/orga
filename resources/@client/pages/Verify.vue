<script setup lang="ts">
	import { ref, onMounted } from 'vue';
	import ThemeSwitcher from "@/components/ThemeSwitcher";
	import logoUrl from "@/assets/images/logo.png";
	import axios from 'axios';
	import { useStateStore } from '@/stores/state';
	import { useAuthStore } from '@/stores/auth';
	import { showToast } from '@/utils/toast';
	import { useRoute, useRouter } from "vue-router";

	const state = useStateStore()
	const auth = useAuthStore()
	const route = useRoute()
	const id = ref(route.params.id ? route.params.id : null)
	const hash = ref(route.params.hash ? route.params.hash : null)
	const router = useRouter()

	onMounted(() => {
		if(id.value && hash.value){
			try {
				axios.get('/api/email/verify/' + id.value + '/' + hash.value)
					.then(response => {
						state.storeState('success', response.data.message)
						showToast(true, response.data.message)
						const newUser = auth.getUser;
						newUser.email_verified_at = response.data.data
						auth.$patch({
							user: JSON.stringify(newUser)
						})
						router.push('/')
					})
					.catch(error => {
						state.storeState('error', error.response.data.message)
						console.log('Error sending login1:', error)
						showToast(false, error.response.data.message)
					})
			} catch (error: any) {
				state.storeState('error', error)
				console.log('Error sennding login:', error)
				showToast(false, error)
			}
		}
	});
</script>

<template>
	<div
		:class="[
			'p-3 sm:px-8 relative h-screen lg:overflow-hidden bg-primary xl:bg-white dark:bg-darkmode-800 xl:dark:bg-darkmode-600',
			'before:hidden before:xl:block before:content-[\'\'] before:w-[57%] before:-mt-[28%] before:-mb-[16%] before:-ml-[13%] before:absolute before:inset-y-0 before:left-0 before:transform before:rotate-[-4.5deg] before:bg-primary/20 before:rounded-[100%] before:dark:bg-darkmode-400',
			'after:hidden after:xl:block after:content-[\'\'] after:w-[57%] after:-mt-[20%] after:-mb-[13%] after:-ml-[13%] after:absolute after:inset-y-0 after:left-0 after:transform after:rotate-[-4.5deg] after:bg-primary after:rounded-[100%] after:dark:bg-darkmode-700',
		]"
	>
		<ThemeSwitcher />
		<div class="container relative z-10 sm:px-10">
			<div class="block grid-cols-2 gap-4 xl:grid">
				<!-- BEGIN: Verify Info -->
				<div class="flex-col hidden min-h-screen xl:flex">
					<a href="" class="flex items-center pt-5 -intro-x">
						<span class="ml-3 text-lg text-white">	 </span>
					</a>
					<div class="my-auto">
						<img
							alt="Amtgard Online Record Keeper v4"
							class="w-1/2 -mt-16 -intro-x"
							:src="logoUrl"
						/>
						<div
							class="mt-10 text-4xl font-medium leading-tight text-white -intro-x"
						>
							Amtgard<br>
							Online Record Keeper v4
						</div>
						<div
							class="mt-5 text-lg text-white -intro-x text-opacity-70 dark:text-slate-400"
						>
							Live the Dream!
						</div>
					</div>
				</div>
				<!-- END: Verify Info -->
				<!-- BEGIN: Verify Confirm -->
				<div class="flex h-screen py-5 my-10 xl:h-auto xl:py-0 xl:my-0">
					<div
						class="w-full px-5 py-8 mx-auto my-auto bg-white rounded-md shadow-md xl:ml-20 dark:bg-darkmode-600 xl:bg-transparent sm:px-8 xl:p-0 xl:shadow-none sm:w-3/4 lg:w-2/4 xl:w-auto"
					>
						<h2
							class="text-2xl font-bold text-center intro-x xl:text-3xl xl:text-left"
						>
							Verifying...
						</h2>
						<div class="mt-8 intro-x">
						</div>
						<div
							class="flex mt-4 text-xs intro-x text-slate-600 dark:text-slate-500 sm:text-sm"
						>
							When complete, you should be redirected
						</div>
					</div>
				</div>
				<!-- END: Verify Confirm -->
			</div>
		</div>
	</div>
</template>
