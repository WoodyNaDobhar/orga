<script setup lang="ts">
	import { Persona } from "@/interfaces";
	import _ from "lodash";
	import { reactive, ref, toRefs } from "vue";
	import Button from "@/components/Base/Button";
	import { useAuthStore } from '@/stores/auth';
	import { useStateStore } from '@/stores/state';
	import Loader from "@/components/Base/Loader";
	import { email, maxLength, minLength, required } from "@vuelidate/validators";
	import useVuelidate from "@vuelidate/core";
	import { showToast } from "@/utils/toast";
	import axios from "axios";

	const auth = useAuthStore()
	const state = useStateStore()
	const props = defineProps<{
		persona: Persona | undefined
	}>()
	const isLoading = ref<boolean>(false)
	const loadingMessage = ref<string>('')
	const deviceName = ref(navigator.userAgent)
	
	const formData = reactive({
		email: auth.getUser.email,
		device_name: deviceName,
	});
	
	const rules = {
		email: {
			required,
			email,
			minLength: minLength(5),
			maxLength: maxLength(191),
		},
		device_name: {
			required,
		},
	};
	
	const validate = useVuelidate(rules, toRefs(formData));
	
	const sendPassword = () => {
		validate.value.$touch();
		if (validate.value.$invalid) {
			showToast(false, "Please check the form.")
		} else {
			isLoading.value = true
			loadingMessage.value = 'Sending...'
			try {
				axios.post('/api/forgot', formData)
					.then(response => {
						isLoading.value = false
						state.storeState('success', response.data.message)
						showToast(true, response.data.message)
					})
					.catch(error => {
						isLoading.value = false
						state.storeState('error', error.response.data.message)
						console.log('Error sending login1:', error)
						showToast(false, error.response.data.message)
					})
			} catch (error: any) {
				isLoading.value = false
				state.storeState('error', error)
				console.log('Error sennding login:', error)
				showToast(false, error)
			}
		};
	};
</script>
<template>
	<div class="col-span-12 lg:col-span-8 2xl:col-span-9">
		<div class="intro-y box lg:mt-5">
			<div
				class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400"
			>
				<h2 class="mr-auto text-base font-medium">Change Password</h2>
			</div>
			<div class="p-5">
				<div class="flex flex-col xl:flex-row">
					<Loader 
						:active="isLoading"
						:message="loadingMessage"
					/>
					<form class="validate-form" style="width: 100%;" enctype="multipart/form-data" @submit.prevent="sendPassword">
						<div class="flex-1 mt-6 xl:mt-0">
							<div class="grid grid-cols-12 gap-x-5">
								<div class="col-span-12 2xl:col-span-6">
									<div>
										For your security, you must click below to receive an email to reset your password.
									</div>
								</div>
							</div>
							<div class="w-full mt-5 border-t border-slate-200/60 dark:border-darkmode-400"></div>
							<Button variant="primary" class="w-75 mt-3">
								Send Password Reset Email
							</Button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>