<script setup lang="ts">
	import { Persona, UserSuperSimple } from "@/interfaces";
	import _ from "lodash";
	import { ref, reactive, toRefs } from "vue";
	import Button from "@/components/Base/Button";
	import {
		FormInput,
		FormLabel
	} from "@/components/Base/Form";
	import Lucide from "@/components/Base/Lucide";
	import Tippy from "@/components/Base/Tippy";
	import { useStateStore } from '@/stores/state';
	import { useAuthStore } from '@/stores/auth';
	import axios from 'axios';
	import { useVuelidate } from "@vuelidate/core";
	import { UserRules } from "@/rules";
	import { PersonaTips } from "@/tips";
	import { showToast } from "@/utils/toast";
	import Loader from "@/components/Base/Loader";
	import { useRouter } from "vue-router";
	import { Dialog } from "@/components/Base/Headless";
import { email, maxLength, minLength, required } from "@vuelidate/validators";

	const auth = useAuthStore()
	const state = useStateStore()
	const props = defineProps<{
		persona: Persona | undefined
	}>()
	const isLoading = ref<boolean>(false)
	const loadingMessage = ref<string>('')
	const router = useRouter()
	const openConfirm = ref<boolean>(false);
	const setOpenConfirm = (value: boolean) => {
		openConfirm.value = value;
	};
	const deviceName = ref(navigator.userAgent)
	
	const userFormData = reactive<UserSuperSimple>({
		id: props.persona?.user?.id || 0,
		persona_id: props.persona?.user?.persona_id || 0,
		email: props.persona?.user?.email || '',
		email_verified_at: props.persona?.user?.email_verified_at || null,
		is_restricted: props.persona?.user?.is_restricted || 0
	});
	
	const validate = useVuelidate(UserRules, toRefs(userFormData));

	const passwordFormData = reactive({
		device_name: deviceName,
		password: "",
		password_confirm: ""
	});
	
	const passRules = {
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
		}
	};
	
	const validatePass = useVuelidate(passRules, toRefs(passwordFormData));

	const saveSettings = async () => {
		validatePass.value.$touch();
		if (validatePass.value.$invalid) {
			showToast(false, "Please check the form.")
		} else {
			setOpenConfirm(false);
			isLoading.value = true
			loadingMessage.value = 'Saving...'
			try {
				await axios.post('/api/checkpass/', passwordFormData)
					.then(async response => {
						validate.value.$touch();
						if (validate.value.$invalid) {
							showToast(false, "Please check the form.")
						} else {
							try {
								userFormData.email_verified_at = null
								await axios.put('/api/users/' + props.persona?.user?.id, userFormData)
									.then(response => {
										isLoading.value = false
										loadingMessage.value = ''
										showToast(true, response.data.message)
										const newUser = auth.getUser
										newUser.email_verified_at = null
										auth.$patch({
											user: JSON.stringify(newUser)
										})
										try {
											axios.post('/api/resend')
												.then(response => {
													state.storeState('success', response.data.message)
													showToast(true, response.data.message)
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
									})
									.catch(error => {
										isLoading.value = false
										loadingMessage.value = ''
										state.storeState('error', error.response.data.message)
										console.log('Error saving persona:', error)
										showToast(false, error.response.data.message) 
									});
							} catch (error: any) {
								isLoading.value = false
								loadingMessage.value = ''
								state.storeState('error', error)
								console.log('Error saving persona:', error)
								showToast(false, error)
							}
						}
					})
					.catch(error => {
						isLoading.value = false
						loadingMessage.value = ''
						state.storeState('error', error.response.data.message)
						console.log('Error saving persona:', error)
						showToast(false, error.response.data.message) 
					});
			} catch (error: any) {
				isLoading.value = false
				loadingMessage.value = ''
				state.storeState('error', error)
				console.log('Error saving persona:', error)
				showToast(false, error)
			}
		}

		
	};
</script>
<template>
	<div class="col-span-12 lg:col-span-8 2xl:col-span-9">
		<div class="intro-y box lg:mt-5">
			<div
				class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400"
			>
				<h2 class="mr-auto text-base font-medium">User</h2>
			</div>
			<div class="p-5">
				<div class="flex flex-col xl:flex-row">
					<Loader 
						:active="isLoading"
						:message="loadingMessage"
					/>
					<form class="validate-form" style="width: 100%;" enctype="multipart/form-data" @submit.prevent="setOpenConfirm(true)">
						<div class="flex-1 mt-6 xl:mt-0">
							<div class="grid grid-cols-12 gap-x-5">
								<div class="col-span-12 2xl:col-span-6">
									<div>
										<FormLabel htmlFor="name">
											Email
											<Tippy
												:content="PersonaTips.email"
												class="inline-block"
											>
												<Lucide icon="HelpCircle" class="w-4 h-4" />
											</Tippy>
										</FormLabel>
										<FormInput
											id="email"
											name="email"
											v-model.trim="validate.email.$model"
											type="text"
											:placeholder="PersonaTips.email"
											:class="{
												'border-danger': validate.email.$error,
											}"
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
									</div>
								</div>
							</div>
							<div class="w-full mt-5 border-t border-slate-200/60 dark:border-darkmode-400"></div>
							<Button variant="primary" type="submit" class="w-20 mt-3">
								Save
							</Button>
						</div>
					</form>
					
					<!-- BEGIN: Modal Content -->
					<Dialog 
						size="sm"
						:open="openConfirm" 
						@close="() => {
							setOpenConfirm(false);
						}"
						class="relative z-50"
					>
						<Dialog.Panel>
							<form class="validate-form" @submit.prevent="saveSettings">
								<Dialog.Title>
									<h2 class="mr-auto text-base font-medium">
										Confirm Password
									</h2>
									<a 
										@click="(event: MouseEvent) => {
											event.preventDefault();
											setOpenConfirm(false);
										}" 
										class="absolute top-0 right-0 mt-2 mr-3" 
										href="#"
									>
										<Lucide icon="X" class="w-8 h-8 text-slate-400" />
									</a>
								</Dialog.Title>
								<Dialog.Description class="grid grid-cols-12 gap-4 gap-y-3">
									<div class="col-span-12 sm:col-span-12">
										<FormLabel htmlFor="password">
											Password
											<Tippy
												:content="PersonaTips.password"
												class="inline-block"
											>
												<Lucide icon="HelpCircle" class="w-4 h-4" />
											</Tippy>
										</FormLabel>
										<FormInput
											id="password"
											name="password"
											v-model.trim="validatePass.password.$model"
											type="password"
											:placeholder="PersonaTips.password"
											:class="{
												'border-danger': validatePass.password.$error,
											}"
										/>
										<template v-if="validatePass.password.$error">
											<div
												v-for="(error, index) in validatePass.password.$errors"
												:key="index"
												class="mt-2 text-danger"
											>
												{{ error.$message }}
											</div>
										</template>
									</div>
									<div class="col-span-12 sm:col-span-12">
										<FormLabel htmlFor="password_confirm">
											Confirm Password
											<Tippy
												:content="PersonaTips.password_confirm"
												class="inline-block"
											>
												<Lucide icon="HelpCircle" class="w-4 h-4" />
											</Tippy>
										</FormLabel>
										<FormInput
											id="password_confirm"
											name="password_confirm"
											v-model.trim="validatePass.password_confirm.$model"
											type="password"
											:placeholder="PersonaTips.password_confirm"
											:class="{
												'border-danger': validatePass.password_confirm.$error,
											}"
										/>
										<template v-if="validatePass.password_confirm.$error">
											<div
												v-for="(error, index) in validatePass.password_confirm.$errors"
												:key="index"
												class="mt-2 text-danger"
											>
												{{ error.$message }}
											</div>
										</template>
									</div>
								</Dialog.Description>
								<Dialog.Footer>
									<Button 
										type="button" 
										variant="outline-secondary" 
										@click="() => {
											setOpenConfirm(false);
										}" class="w-20 mr-1"
									>
										Cancel
									</Button>
									<Button variant="primary" type="submit" class="w-20">
										Send
									</Button>
								</Dialog.Footer>
							</form>
						</Dialog.Panel>
					</Dialog>
					<!-- END: Modal Content -->
				</div>
			</div>
		</div>
	</div>
</template>