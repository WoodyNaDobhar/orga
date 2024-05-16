<script setup lang="ts">
	import { Persona, SocialSimple, SocialSuperSimple } from "@/interfaces";
	import _ from "lodash";
	import { ref, reactive, toRefs } from "vue";
	import Button from "@/components/Base/Button";
	import {
		FormSelect,
		FormInput,
		FormLabel,
	} from "@/components/Base/Form";
	import Lucide from "@/components/Base/Lucide";
	import Tippy from "@/components/Base/Tippy";
	import { useStateStore } from '@/stores/state';
	import axios from 'axios';
	import { useVuelidate } from "@vuelidate/core";
	import { SocialRules } from "@/rules";
	import { SocialTips } from "@/tips";
	import { showToast } from "@/utils/toast";
	import Loader from "@/components/Base/Loader";
	import { Menu } from "@/components/Base/Headless";
	import { getSocialIcon, getSocialPlatforms, copyLink } from "@/utils/helper";

	const state = useStateStore()
	const props = defineProps<{
		persona: Persona | undefined
	}>()
	const isLoading = ref<boolean>(false)
	const loadingMessage = ref<string>('')

	interface SocialPersonaEmit {
		(e: "updated", value: Persona): void;
	}

	const emit = defineEmits<SocialPersonaEmit>();
	
	const SocialFormDataDefault = <SocialSuperSimple>{
		id: 0,
		sociable_type: "Persona",
		sociable_id: props.persona?.id || 0,
		media: "Web",
		value: ''
	}
	const SocialFormData = reactive<SocialSuperSimple>({
		id: 0,
		sociable_type: "Persona",
		sociable_id: props.persona?.id || 0,
		media: "Web",
		value: ''
	});
	
	const validate = useVuelidate(SocialRules, toRefs(SocialFormData));

	const resetForm = () => {
		Object.keys(SocialFormData).forEach(key => {
			SocialFormData[key as keyof SocialSuperSimple] = SocialFormDataDefault[key as keyof SocialSuperSimple] as never;
		});
		validate.value.$reset()
	}

	const saveSocial = async () => {
		validate.value.$touch();
		if (validate.value.$invalid) {
			showToast(false, "Please check the form.")
		} else {
			isLoading.value = true
			loadingMessage.value = 'Saving...'
			try {
				let request;
				if (SocialFormData.id !== 0) {
					request = axios.put(`/api/socials/${SocialFormData.id}`, SocialFormData)
					.then(response => {
						isLoading.value = false;
						loadingMessage.value = '';
						if (props.persona && props.persona.socials) {
                            const index = props.persona.socials.findIndex(social => social.id === response.data.data.id)
                            if (index !== -1) {
                                props.persona.socials.splice(index, 1, response.data.data)
                                emit("updated", props.persona)
                            }
							resetForm()
                        }
						showToast(true, response.data.message)
					})
				} else {
					request = axios.post(`/api/socials`, SocialFormData)
					.then(response => {
						isLoading.value = false;
						loadingMessage.value = '';
						if(props.persona){
							if (!props.persona.socials) {
								props.persona.socials = [response.data.data]
							} else {
								props.persona.socials.push(response.data.data)
							}
							emit("updated", props.persona)
							resetForm()
						}
						showToast(true, response.data.message)
					})
				}
				request
					.catch(error => {
						state.storeState('error', error)
						console.log('Error posting issuance:', error)
						showToast(false, error)
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

	const editSocial = (social: SocialSimple) => {
		SocialFormData.id = social.id;
		SocialFormData.sociable_id = social.sociable_id;
		SocialFormData.sociable_type = social.sociable_type;
		SocialFormData.media = social.media;
		SocialFormData.value = social.value;
	};

	const deleteSocial = (social: SocialSimple) => {
		try {
			axios.delete(`/api/socials/${social.id}`)
				.then(response => {
					if (props.persona && props.persona.socials) {
						const index = props.persona.socials.findIndex(r => r.id === social.id)
						if (index !== -1) {
							props.persona.socials.splice(index, 1)
							emit("updated", props.persona);
						}
						showToast(true, response.data.message)
					}
				})
				.catch(error => {
					state.storeState('error', error.response.data.message)
					console.log('Error posting issuance:', error)
					showToast(false, error.response.data.message) 
				});
		} catch (error: any) {
			state.storeState('error', error)
			console.log('Error posting issuance:', error)
			showToast(false, error)
		}
	};
</script>
<template>
	<div class="col-span-12 lg:col-span-8 2xl:col-span-9">
		<div class="intro-y box lg:mt-5">
			<div
				class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400"
			>
				<h2 class="mr-auto text-base font-medium">Social Media</h2>
			</div>
			<div class="p-5">
				<div class="flex flex-col">
					<Loader 
						:active="isLoading"
						:message="loadingMessage"
					/>
					<form class="validate-form" enctype="multipart/form-data" @submit.prevent="saveSocial">
						<div class="flex-1 mt-6 xl:mt-0">
							<div class="grid grid-cols-12 gap-x-5">
								<!-- SECTION 1 -->
								<div class="col-span-12 2xl:col-span-6">
									<div class="p-5">
										<div v-for="(social) in persona?.socials" class="flex items-center">
											<Lucide :icon="getSocialIcon(social.media)" class="w-12 h-12 mr-2" />
											<div class="ml-4">
												<a :href="social.link" target="_blank">{{ social.value }}</a>
											</div>
											<Menu class="ml-auto">
												<Menu.Button tag="a" class="block w-5 h-5" href="#">
													<Lucide
														icon="MoreHorizontal"
														class="w-5 h-5 text-slate-500"
													/>
												</Menu.Button>
												<Menu.Items class="w-40">
													<Menu.Item @click="copyLink(social.link)">
														<Lucide icon="Copy" class="w-4 h-4 mr-2" /> Copy Link
													</Menu.Item>
													<Menu.Item @click="editSocial(social)">
														<Lucide icon="CheckSquare" class="w-4 h-4 mr-2" /> Edit
													</Menu.Item>
													<Menu.Item @click="deleteSocial(social)">
														<Lucide icon="Trash" class="w-4 h-4 mr-2" /> Delete
													</Menu.Item>
												</Menu.Items>
											</Menu>
										</div>
									</div>
								</div>
								<!-- SECTION 2 -->
								<div class="col-span-12 2xl:col-span-6">
									<div class="mt-3 2xl:mt-0">
										<FormLabel htmlFor="social-media">
											Media
											<Tippy
												:content="SocialTips.media"
												class="inline-block"
											>
												<Lucide icon="HelpCircle" class="w-4 h-4" />
											</Tippy>
										</FormLabel>
										<FormSelect 
											id="social-media" 
											name="media"
											v-model.trim="validate.media.$model"
											placeholder="Select Platform"
											:class="{
												'border-danger': validate.media.$error,
											}"
										>
											<option
												v-for="platform in getSocialPlatforms"
												:key="platform"
												:value="platform"
											>
												{{ platform }}
											</option>
										</FormSelect>
										<template v-if="validate.media.$error">
											<div
												v-for="(error, index) in validate.media.$errors"
												:key="index"
												class="mt-2 text-danger"
											>
												{{ error.$message }}
											</div>
										</template>
									</div>
									<div class="mt-3">
										<FormLabel htmlFor="social-value">
											Username/Link
											<Tippy
												:content="SocialTips.value"
												class="inline-block"
											>
												<Lucide icon="HelpCircle" class="w-4 h-4" />
											</Tippy>
										</FormLabel>
										<FormInput
											id="social-value"
											name="value"
											v-model.trim="validate.value.$model"
											type="text"
											:placeholder="SocialTips.value"
											:class="{
												'border-danger': validate.value.$error,
											}"
										/>
										<template v-if="validate.value.$error">
											<div
												v-for="(error, index) in validate.value.$errors"
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
							<Button 
								type="button" 
								variant="outline-secondary" 
								@click="() => {
									resetForm()
								}" class="w-20 mr-1"
							>
								Clear
							</Button>
							<Button variant="primary" type="submit" class="w-20 mt-3">
								Save
							</Button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>