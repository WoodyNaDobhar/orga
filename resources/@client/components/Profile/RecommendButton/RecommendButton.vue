<script setup lang="ts">
	import Button from "@/components/Base/Button";
	import { ref, reactive } from "vue";
	import { showToast } from '@/utils/toast';
	import axios from 'axios';
	import { useStateStore } from '@/stores/state';
	import { useAuthStore } from '@/stores/auth';
	import { Dialog } from "@/components/Base/Headless";
	import { 
		HonorSelectOption,
		Persona,
		RecommendFormData
	} from '@/interfaces';
	import {
		required,
		helpers
	} from "@vuelidate/validators";
	import { useVuelidate } from "@vuelidate/core";
	import TomSelect from "@/components/Base/TomSelect";
	import { FormInput, FormLabel } from "@/components/Base/Form";
	import Lucide from "@/components/Base/Lucide";
	import Tippy from "@/components/Base/Tippy";
	import { RecommendationRules } from "@/rules";
	import { RecommendationTips } from "@/tips";
	
	const auth = useAuthStore()
	const state = useStateStore()
	const props = defineProps<{
		persona?: Persona
	}>()
	
	const recommendFormData = reactive<RecommendFormData>({
		honor: '1',
		persona_id: null,
		recommendable_type: null,
		recommendable_id: null,
		rank: null,
		reason: null,
	});
	
	const recommendValidate = useVuelidate(RecommendationRules, recommendFormData);
	const recommendModal = ref(false);
	const setRecommendModal = (value: boolean) => {
		if(value){
			setHonorSelectOptions()
			recommendFormData.honor = '1'
			recommendFormData.persona_id = 0
			recommendFormData.recommendable_type = null
			recommendFormData.recommendable_id = null
			recommendFormData.rank = null
			recommendFormData.reason = null
			showRank.value = false
		}
		recommendModal.value = value;
	}
	const showRank = ref(false)
	const handleHonorSelectChange = (selectedValue:any) => {
		const valuesArray = selectedValue.split('|')
		if (valuesArray.length === 3) {
			const [type, value] = valuesArray
			for (const collection of honorSelectOptions.value) {
				if(collection.options){
					for (const option of collection.options) {
						if (option.type == type && option.value == value) {
							recommendFormData.persona_id = props.persona?.id ? props.persona.id : 0
							recommendFormData.recommendable_id = option.value
							recommendFormData.recommendable_type = option.type
							if (option.is_ladder) {
								if (props.persona?.awards.hasOwnProperty(option.text)) {
									recommendFormData.rank = (props.persona?.awards[option.text]?.rank ?? null) + 1;
									showRank.value = true
								}
							} else {
								showRank.value = false
							}
							break;
						}
					}
				}
			}
		}
		return false;
	}
	
	const honorSelectOptions = ref<HonorSelectOption[]>([]);
	const setHonorSelectOptions = () => {
		if (props.persona?.chapter?.realm?.ropawards && props.persona?.chapter.realm.ropawards.length > 0) {
			honorSelectOptions.value.push({
				label: `RoP Awards`,
				options: props.persona?.chapter.realm.ropawards.map(honor => ({
					value: honor.id,
					text: honor.name,
					type: 'Award',
					is_ladder: honor.is_ladder
				}))
			});
		}
		if (props.persona?.chapter?.realm?.awards && props.persona?.chapter.realm.awards.length > 0) {
			honorSelectOptions.value.push({
				label: `Realm Awards`,
				options: props.persona?.chapter.realm.awards.map(honor => ({
					value: honor.id,
					text: honor.name,
					type: 'Award',
					is_ladder: honor.is_ladder
				}))
			});
		}
		if (props.persona?.chapter?.awards && props.persona?.chapter.awards.length > 0) {
			honorSelectOptions.value.push({
				label: `Chapter Awards`,
				options: props.persona?.chapter.awards.map(honor => ({
					value: honor.id,
					text: honor.name,
					type: 'Award',
					is_ladder: honor.is_ladder
				}))
			});
		}
		(props.persona?.memberships || []).forEach(membership => {
			if (membership.unit.awards && membership.unit.awards.length > 0) {
				honorSelectOptions.value.push({
					label: `${membership.unit.name} Awards`,
					options: membership.unit.awards.map(honor => ({
						value: honor.id,
						text: honor.name,
						type: 'Award',
						is_ladder: honor.is_ladder
					}))
				});
			}
		});
		if (props.persona?.chapter?.realm?.roptitles && props.persona?.chapter.realm.roptitles.length > 0) {
			honorSelectOptions.value.push({
				label: `RoP Titles`,
				options: props.persona?.chapter.realm.roptitles.map(honor => ({
					value: honor.id,
					text: honor.name,
					type: 'Title',
					is_ladder: 0
				}))
			});
		}
		if (props.persona?.chapter?.realm?.titles && props.persona?.chapter.realm.titles.length > 0) {
			honorSelectOptions.value.push({
				label: `Realm Titles`,
				options: props.persona?.chapter.realm.titles.map(honor => ({
					value: honor.id,
					text: honor.name,
					type: 'Title',
					is_ladder: 0
				}))
			});
		}
		if (props.persona?.chapter?.titles && props.persona?.chapter.titles.length > 0) {
			honorSelectOptions.value.push({
				label: `Chapter Titles`,
				options: props.persona?.chapter.titles.map(honor => ({
					value: honor.id,
					text: honor.name,
					type: 'Title',
					is_ladder: 0
				}))
			});
		}
		(props.persona?.memberships || []).forEach(membership => {
			if (membership.unit.titles && membership.unit.titles.length > 0) {
				honorSelectOptions.value.push({
					label: `${membership.unit.name} Titles`,
					options: membership.unit.titles.map(honor => ({
						value: honor.id,
						text: honor.name,
						type: 'Title',
						is_ladder: 0
					}))
				});
			}
		});
	};
	
	const sendRecommendation = async () => {
		recommendValidate.value.$touch();
		if (recommendValidate.value.$invalid) {
			showToast(false, "Please check the form.")
		} else {
			try {
				await axios.post('/api/recommendations', recommendFormData)
					.then(response => {
						console.log('Recommendation sent:', response.data);
						setRecommendModal(false);
						showToast(true, response.data.message)
					})
					.catch(error => {
						state.storeState('error', error.response.data.message)
						console.log('Error posting recommendation:', error)
						showToast(false, error.response.data.message) 
					});
			} catch (error: any) {
				state.storeState('error', error)
				console.log('Error posting recommendation:', error)
				showToast(false, error)
			}
		}
	}
	
	const closeRecommendationRef = ref<HTMLElement | null>(null);

</script>

<template>
											<Button 
												v-if="auth.isLoggedIn" 
												variant="primary" 
												class="mr-2 shadow-md"
												@click="(event: MouseEvent) => {
													event.preventDefault();
													setRecommendModal(true);
												}"
											>
												Recommend New Honor
											</Button>
											<!-- BEGIN: Recommend Modal Content -->
											<Dialog 
												:open="recommendModal" 
												@close="() => {
													setRecommendModal(false);
												}" 
												:initialFocus="closeRecommendationRef"
											>
												<Dialog.Panel>
													<form class="validate-form" @submit.prevent="sendRecommendation">
														<Dialog.Title>
															<h2 class="mr-auto text-base font-medium">
																Recommend Honor
															</h2>
															<a 
																@click="(event: MouseEvent) => {
																	event.preventDefault();
																	setRecommendModal(false);
																}" 
																class="absolute top-0 right-0 mt-2 mr-3" 
																href="#"
															>
																<Lucide icon="X" class="w-8 h-8 text-slate-400" ref="{closeRecommendationRef}" />
															</a>
														</Dialog.Title>
														<Dialog.Description class="grid grid-cols-12 gap-4 gap-y-3">
															<div class="col-span-12 sm:col-span-12">
																<FormLabel htmlFor="recommendation-form-honor"> 
																	Honor 
																	<Tippy
																		:content="RecommendationTips.honor"
																		class="inline-block"
																	>
																		<Lucide icon="HelpCircle" class="w-4 h-4" />
																	</Tippy>
																</FormLabel>
																<TomSelect 
																	id="recommendation-form-honor"
																	v-model.trim="recommendValidate.honor.$model"
																	:options="{
																		placeholder: 'Select an Honor',
																	}"
																	class="w-full"
																	@update:modelValue="handleHonorSelectChange"
																>
																	<optgroup v-for="(type) in honorSelectOptions" :label="type.label">
																		<option v-for="(option) in type.options" :value="option.type + `|` + option.value + `|` + option.is_ladder">{{ option.text }}</option>
																	</optgroup>
																</TomSelect>
																<template v-if="recommendValidate.honor.$error">
																	<div
																		v-for="(error, index) in recommendValidate.honor.$errors"
																		:key="index"
																		class="mt-2 text-danger"
																	>
																		{{ error.$message }}
																	</div>
																</template>
															</div>
															<div v-if="showRank" class="col-span-12 sm:col-span-12">
																<FormLabel htmlFor="recommendation-form-rank">
																	Rank 
																	<Tippy
																		:content="RecommendationTips.rank"
																		class="inline-block"
																	>
																		<Lucide icon="HelpCircle" class="w-4 h-4" />
																	</Tippy>
																</FormLabel>
																<FormInput id="recommendation-form-rank" v-model.trim="recommendValidate.rank.$model" type="text" placeholder="5" />
																<template v-if="recommendValidate.rank.$error">
																	<div
																		v-for="(error, index) in recommendValidate.rank.$errors"
																		:key="index"
																		class="mt-2 text-danger"
																	>
																		{{ error.$message }}
																	</div>
																</template>
															</div>
															<div class="col-span-12 sm:col-span-12">
																<FormLabel htmlFor="recommendation-form-reason">
																	Reason 
																	<Tippy
																		:content="RecommendationTips.reason"
																		class="inline-block"
																	>
																		<Lucide icon="HelpCircle" class="w-4 h-4" />
																	</Tippy>
																</FormLabel>
																<FormInput id="recommendation-form-reason" v-model.trim="recommendValidate.reason.$model" type="text" placeholder="That awesome thing they did" />
																<template v-if="recommendValidate.reason.$error">
																	<div
																		v-for="(error, index) in recommendValidate.reason.$errors"
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
																	setRecommendModal(false);
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
											<!-- END: Recommend Modal Content -->
</template>