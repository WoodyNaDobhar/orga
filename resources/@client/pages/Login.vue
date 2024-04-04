<script setup lang="ts">
	import { ref, reactive, toRefs } from 'vue';
	import ThemeSwitcher from "@/components/ThemeSwitcher";
	import logoUrl from "@/assets/images/logo.png";
	import { FormInput, FormCheck } from "@/components/Base/Form";
	import Button from "@/components/Base/Button";
	import {
		required,
		minLength,
		maxLength,
		email,
	} from "@vuelidate/validators";
	import { useVuelidate } from "@vuelidate/core";
	import Toastify from "toastify-js";
	import axios from 'axios';
	import { useStateStore } from '@/stores/state';
	import { useAuthStore } from '@/stores/auth';
	import { useRouter } from 'vue-router';
    import GoogleReCaptchaV3 from '@/components/Base/googlerecaptchav3/GoogleReCaptchaV3.vue';
	import { showToast } from '@/utils/toast';

	const router = useRouter()
	const deviceName = ref(navigator.userAgent)
	const state = useStateStore()
	const auth = useAuthStore()
	const gRecaptchaResponse = null
	const formData = reactive({
		email: "",
		device_name: deviceName,
		password: "",
		password_confirm: ""
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
		password: {
			required,
			minLength: minLength(6),
		}
	};
	
	const validate = useVuelidate(rules, toRefs(formData));
	
	const onSubmit = () => {
		validate.value.$touch();
		if (validate.value.$invalid) {
			showToast(false, "Please check the form.")
		} else {
			try {
				axios.post('/api/login', formData)
					.then(response => {
						state.storeState('success', response.data.message)
						const token = response.data.data.token
						const user = response.data.data
						auth.storeLoggedInUser(token, user)
						router.push('/')
					})
					.catch(error => {
						state.storeState('error', error.response.data.message)
						console.log('Error seding login1:', error)
						showToast(false, error.response.data.message)
					})
			} catch (error) {
				state.storeState('error', error)
				console.log('Error seding login:', error)
				showToast(false, error)
			}
		};
	};
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
				<!-- BEGIN: Login Info -->
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
				<!-- END: Login Info -->
				<!-- BEGIN: Login Form -->
				<div class="flex h-screen py-5 my-10 xl:h-auto xl:py-0 xl:my-0">
					<div
						class="w-full px-5 py-8 mx-auto my-auto bg-white rounded-md shadow-md xl:ml-20 dark:bg-darkmode-600 xl:bg-transparent sm:px-8 xl:p-0 xl:shadow-none sm:w-3/4 lg:w-2/4 xl:w-auto"
					>
						<form class="validate-form" @submit.prevent="onSubmit">
							<h2
								class="text-2xl font-bold text-center intro-x xl:text-3xl xl:text-left"
							>
								Sign In
							</h2>
							<div class="mt-8 intro-x">
								<FormInput
									id="device_name"
									v-model.trim="validate.device_name.$model"
									type="hidden"
									name="device_name"
								/>
								<template v-if="validate.device_name.$error">
									<div
										v-for="(error, index) in validate.device_name.$errors"
										:key="index"
										class="mt-2 text-danger"
									>
										Unable to determine device
									</div>
								</template>
								<FormInput
									id="email"
									v-model.trim="validate.email.$model"
									type="text"
									name="email"
									class="block px-4 py-3 intro-x login__input min-w-full xl:min-w-[350px]"
									:class="{
										'border-danger': validate.email.$error,
									}"
									placeholder="Email"
								/>
								<template v-if="validate.email.$error">
									<div
										v-for="(error, index) in validate.email.$errors"
										:key="index"
										class="mt-2 text-danger"
									>
										{{ error.$message }}
									</div>
								</template>
								<FormInput
									id="password"
									v-model.trim="validate.password.$model"
									type="password"
									name="password"
									class="block px-4 py-3 mt-4 intro-x login__input min-w-full xl:min-w-[350px]"
									:class="{
										'border-danger': validate.password.$error,
									}"
									placeholder="Password"
								/>
								<template v-if="validate.password.$error">
									<div
										v-for="(error, index) in validate.password.$errors"
										:key="index"
										class="mt-2 text-danger"
									>
										{{ error.$message }}
									</div>
								</template>
							</div>
							<div
								class="flex mt-4 text-xs intro-x text-slate-600 dark:text-slate-500 sm:text-sm"
							>
								<a href="/forgot">Forgot Password?</a>
							</div>
							<div class="flex items-center mt-4 text-xs intro-x text-slate-600 dark:text-slate-500 sm:text-sm">
								<Button
									variant="primary"
									type="submit"
									class="w-full px-4 py-3 align-top xl:w-32 xl:mr-3"
								>
									Login
								</Button>
								<div style="display: inline">
									<google-re-captcha-v3
										v-model="gRecaptchaResponse"
										ref="captcha"
										id="login_id"
										inline
										action="login"
										style="display: inline;"
									></google-re-captcha-v3>
								</div>
							</div>
							<div
								class="mt-10 text-center intro-x xl:mt-24 text-slate-600 dark:text-slate-500 xl:text-left"
							>
								By using this service, you agree to our
								<a class="text-primary dark:text-slate-200" href="/legal#terms">
									Terms and Conditions
								</a>
								&
								<a class="text-primary dark:text-slate-200" href="/legal#privacy">
									Privacy Policy
								</a>
							</div>
						</form>
					</div>
				</div>
				<!-- END: Login Form -->
			</div>
		</div>
	</div>
</template>
