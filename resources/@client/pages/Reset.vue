<script setup lang="ts">
	import { ref, onMounted, reactive, toRefs } from 'vue';
	import { useRoute, useRouter } from 'vue-router';
	import axios from 'axios';
	import ThemeSwitcher from "@/components/ThemeSwitcher";
	import logoUrl from "@/assets/images/logo.png";
	import { FormInput, FormCheck, FormSelect } from "@/components/Base/Form";
	import Button from "@/components/Base/Button";
	import {
		required,
		minLength,
		maxLength,
		integer,
		email,
		sameAs
	} from "@vuelidate/validators";
	import { useVuelidate } from "@vuelidate/core";
	import PasswordMeter from 'vue-simple-password-meter';
	import { useStateStore } from '@/stores/state';
	import { useAuthStore } from '@/stores/auth';
    import GoogleReCaptchaV3 from '@/components/Base/googlerecaptchav3/GoogleReCaptchaV3.vue';
	import { showToast } from '@/utils/toast';

	const route = useRoute()
	const router = useRouter()
	const resetCode = ref(route.params.password_token)
	const deviceName = ref(navigator.userAgent)
	const state = useStateStore()
	const auth = useAuthStore()
	var gRecaptchaResponse = ref()

	const formData = reactive({
		email: "",
		password_token: resetCode.value,
		device_name: deviceName,
		password: "",
		password_confirm: "",
		is_agreed: 0
	});
	
	const rules = {
		email: {
			required,
			email,
			minLength: minLength(5),
			maxLength: maxLength(191),
		},
		password_token: {
			required,
		},
		device_name: {
			required,
		},
		password: {
			required,
			minLength: minLength(6),
		},
		password_confirm: {
			required,
			minLength: minLength(6),
			maxLength: maxLength(191),
		},
		is_agreed: {
			sameAs: sameAs(true)
		},
	};
	
	const validate = useVuelidate(rules, toRefs(formData));
	
	const onSubmit = () => {
		validate.value.$touch();
		if (validate.value.$invalid) {
			showToast(false, "Please check the form.")
		} else {
			try {
				axios.post('/api/reset', formData)
					.then(response => {
						state.storeState('success', response.data.message);
						const token = response.data.data.token;
						const user = response.data.data;
						auth.storeLoggedInUser(token, user);
						router.push('/');
					})
					.catch(error => {
						state.storeState('error', error.response.data.message);
						console.log('Error sending registration:', error);
						showToast(false, error.response.data.message)
					})
			} catch (error: any) {
				state.storeState('error', error);
				console.log('Error sending registration:', error);
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
								Reset Password
							</h2>
							<div class="mt-8 intro-x">
								<FormInput
									id="password_token"
									v-model.trim="validate.password_token.$model"
									type="hidden"
									name="password_token"
								/>
								<template v-if="validate.password_token.$error">
									<div
										v-for="(error, index) in validate.password_token.$errors"
										:key="index"
										class="mt-2 text-danger"
									>
										No reset token detected
									</div>
								</template>
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
								<password-meter :password="validate.password.$model" />
								<template v-if="validate.password.$error">
									<div
										v-for="(error, index) in validate.password.$errors"
										:key="index"
										class="mt-2 text-danger"
									>
										{{ error.$message }}
									</div>
								</template>
								<FormInput
									id="password_confirm"
									v-model.trim="validate.password_confirm.$model"
									type="password"
									name="password_confirm"
									class="block px-4 py-3 mt-4 intro-x login__input min-w-full xl:min-w-[350px]"
									:class="{
										'border-danger': validate.password_confirm.$error,
									}"
									placeholder="Confirm Password"
								/>
								<template v-if="validate.password_confirm.$error">
									<div
										v-for="(error, index) in validate.password_confirm.$errors"
										:key="index"
										class="mt-2 text-danger"
									>
										{{ error.$message }}
									</div>
								</template>
							</div>
							<div
								class="flex items-center mt-4 text-xs intro-x text-slate-600 dark:text-slate-500 sm:text-sm"
							>
								<FormCheck.Input
									id="is_agreed"
									v-model.trim="validate.is_agreed.$model"
									type="checkbox"
									name="is_agreed"
									class="mr-2 border"
									:class="{
										'border-danger': validate.is_agreed.$error,
									}"
								/>
								<template v-if="validate.is_agreed.$error">
									<div
										v-for="(error, index) in validate.is_agreed.$errors"
										:key="index"
										class="mt-2 text-danger"
									>
										You must agree to use the service
									</div>
								</template>
								<label class="cursor-pointer select-none" htmlFor="remember-me">
									I agree to the
								</label>
								<a class="ml-1 text-primary dark:text-slate-200" href="/legal" target="_blank">
									Privacy Policy & Terms of Use
								</a>
								.
							</div>
							<div class="flex items-center mt-4 text-xs intro-x text-slate-600 dark:text-slate-500 sm:text-sm">
								<Button
									variant="primary"
									type="submit" 
									class="w-full px-4 py-3 align-top xl:w-32 xl:mr-3"
								>
									Update Password
								</Button>
								<div style="display: inline">
									<google-re-captcha-v3
										v-model="gRecaptchaResponse"
										ref="captcha"
										id="reset_id"
										inline
										action="reset"
										style="display: inline;"
									></google-re-captcha-v3>
								</div>
							</div>
							<div
								class="mt-10 text-center intro-x xl:mt-24 text-slate-600 dark:text-slate-500 xl:text-left"
							>
								By using this service, you agree to our
								<a class="text-primary dark:text-slate-200" href="/legal#terms" target="_blank">
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


