<script setup lang="ts">
	import _ from "lodash";
	import { ref, provide, onMounted, reactive, toRefs } from "vue";
	import { useRoute } from 'vue-router';
	import fakerData from "@/utils/faker";
	import Button from "@/components/Base/Button";
	import { FormSwitch, FormInput, FormLabel } from "@/components/Base/Form";
	import Progress from "@/components/Base/Progress";
	import TinySlider, { type TinySliderElement } from "@/components/Base/TinySlider";
	import Lucide from "@/components/Base/Lucide";
	import FileIcon from "@/components/Base/FileIcon";
	import { Dialog, Menu, Tab } from "@/components/Base/Headless";
	import { Tab as HeadlessTab } from "@headlessui/vue";
	import { useStateStore } from '@/stores/state';
	import { useAuthStore } from '@/stores/auth';
	import { ArchetypeSimple, Persona } from '@/interfaces';
	import axios from 'axios';
	import Table from "@/components/Base/Table";
	import Tippy from "@/components/Base/Tippy";
	import { formatDate } from "@/utils/helper";
	import TomSelect from "@/components/Base/TomSelect";
	import { showToast } from '@/utils/toast';
	import Toastify from "toastify-js";
	import { useVuelidate } from "@vuelidate/core";
	import {
		required,
		integer,
		helpers
	} from "@vuelidate/validators";
	
	const newProductsRef = ref<TinySliderElement>();
	const newAuthorsRef = ref<TinySliderElement>();
	const state = useStateStore()
	const auth = useAuthStore()
	const user = auth.getUser
	const route = useRoute()
	const persona_id = ref(route.params.persona_id)
	const persona = ref<Persona>();
	const archetypes = ref<ArchetypeSimple[]>([]);
	const closeRecommendationRef = ref([]);
	
	onMounted(() => {
		fetchUserData()
		fetchArchetypesData()
	})
	
	provide("bind[newProductsRef]", (el: TinySliderElement) => {
		newProductsRef.value = el;
	});
	
	provide("bind[newAuthorsRef]", (el: TinySliderElement) => {
		newAuthorsRef.value = el;
	});
	
	const prevNewProducts = () => {
		newProductsRef.value?.tns.goTo("prev");
	};
	const nextNewProducts = () => {
		newProductsRef.value?.tns.goTo("next");
	};
	const prevNewAuthors = () => {
		newAuthorsRef.value?.tns.goTo("prev");
	};
	const nextNewAuthors = () => {
		newAuthorsRef.value?.tns.goTo("next");
	};
	
	const fetchUserData = async () => {
		try {
			let id = persona_id.value ? persona_id.value : user.persona.id;
			state.storeState('loading', 'Loading Persona')
			let withArray = [
				'honorific',
				'user',
				'titleIssuances',
				'socials',
				'pronoun',
				'chapter',
				'chapter.awards',
				'chapter.titles',
				'chapter.realm',
				'chapter.realm.awards',
				'chapter.realm.titles',
				'units',
				'units.awards',
				'units.titles'
			];
			let withJoin = withArray.map(item => `with[]=${item}`).join('&');
			await axios.get("/api/personas/" + id + "?" + withJoin)
				.then(response => {
					state.storeState('ready', 'ORKv4 is ready')
					persona.value = response.data.data;
					state.storeBreadcrumb(1, (persona_id.value ? response.data.data.name : user?.persona.name), '/profile')
					setHonorSelectOptions()
				});
		} catch (error: any) {
			state.storeState('error', error)
			console.error('Error fetching user data:', error);
		}
	};
	
	const fetchArchetypesData = async () => {
		try {
			await axios.get("/api/archetypes?")
				.then(response => {
					archetypes.value = response.data.data;
					archetypes.value.sort((a, b) => a.name.localeCompare(b.name))
				});
		} catch (error: any) {
			state.storeState('error', error)
			console.error('Error fetching user data:', error);
		}
	};
	
	const expandedIndex = ref();
	const toggleContents = (index: string) => {
		expandedIndex.value = expandedIndex.value === index ? null : index;
	}
	
	const awardModal = ref(false);
	const setAwardModal = (value: boolean) => {
		awardModal.value = value;
	};
	
	const sortAwardsBy = (attribute: string) => {
		switch (attribute) {
			case 'issued_at':
				var sortedAwards = Object.entries(persona.value.awards).sort(([, a], [, b]) => {
					// Find the lowest issued_at value for each award
					var lowestIssuedAtA = Math.min(...a.issuances.map(issuance => new Date(issuance.issued_at).getTime()));
					var lowestIssuedAtB = Math.min(...b.issuances.map(issuance => new Date(issuance.issued_at).getTime()));
					// Compare the lowest issued_at values
					return lowestIssuedAtA - lowestIssuedAtB;
				});
				// Reconstruct the persona.value.awards object
				persona.value.awards = Object.fromEntries(sortedAwards);
				break;
			case 'name':
				var order = Object.keys(persona.value.awards).sort()
				var sortedObj = {};
				order.forEach(key => {
					sortedObj[key] = persona.value.awards[key];
				});
				persona.value.awards = sortedObj
				break;
			case 'rank':
				persona.value.awards = Object.fromEntries(Object.entries(persona.value.awards).sort(([, a], [, b]) => {
					return (b.rank || 0) - (a.rank || 0);
				}));
				break;
			default:
				// Do nothing if an invalid attribute is provided
				break;
		}
	}
	
	const recommendModal = ref(false);
	const setRecommendModal = (value: boolean) => {
		recommendModal.value = value;
	};
	const showRank = ref(false)
	const recommendFormData = reactive({
		honor: '1',
		persona_id: 0,
		recommendable_type: null,
		recommendable_id: null,
		rank: null,
		reason: null,
	});
	const recommendFormRules = {
		honor: {
			required: helpers.withMessage('Please select an honor', required)
		},
		rank: {
			integer: helpers.withMessage('Rank must be an integer', required)
		},
		reason: {
			required: helpers.withMessage('Let the rest of us know why', required)
		},
	};
	const recommendValidate = useVuelidate(recommendFormRules, toRefs(recommendFormData));
	const honorSelectOptions = ref([{}]);
	const setHonorSelectOptions = () => {
		if (persona.value?.chapter?.realm?.ropawards && persona.value?.chapter.realm.ropawards.length > 0) {
			honorSelectOptions.value.push({
				label: `RoP Awards`,
				options: persona.value?.chapter.realm.ropawards.map(honor => ({
					value: honor.id,
					text: honor.name,
					type: 'Award',
					is_ladder: honor.is_ladder
				}))
			});
		}
		if (persona.value?.chapter?.realm?.awards && persona.value?.chapter.realm.awards.length > 0) {
			honorSelectOptions.value.push({
				label: `Realm Awards`,
				options: persona.value?.chapter.realm.awards.map(honor => ({
					value: honor.id,
					text: honor.name,
					type: 'Award',
					is_ladder: honor.is_ladder
				}))
			});
		}
		if (persona.value?.chapter?.awards && persona.value?.chapter.awards.length > 0) {
			honorSelectOptions.value.push({
				label: `Chapter Awards`,
				options: persona.value?.chapter.awards.map(honor => ({
					value: honor.id,
					text: honor.name,
					type: 'Award',
					is_ladder: honor.is_ladder
				}))
			});
		}
		(persona.value?.units || []).forEach(unit => {
			if (unit.awards && unit.awards.length > 0) {
				honorSelectOptions.value.push({
					label: `${unit.name} Awards`,
					options: unit.awards.map(honor => ({
						value: honor.id,
						text: honor.name,
						type: 'Award',
						is_ladder: honor.is_ladder
					}))
				});
			}
		});
		if (persona.value?.chapter?.realm?.roptitles && persona.value?.chapter.realm.roptitles.length > 0) {
			honorSelectOptions.value.push({
				label: `RoP Titles`,
				options: persona.value?.chapter.realm.roptitles.map(honor => ({
					value: honor.id,
					text: honor.name,
					type: 'Title',
					is_ladder: honor.is_ladder
				}))
			});
		}
		if (persona.value?.chapter?.realm?.titles && persona.value?.chapter.realm.titles.length > 0) {
			honorSelectOptions.value.push({
				label: `Realm Titles`,
				options: persona.value?.chapter.realm.titles.map(honor => ({
					value: honor.id,
					text: honor.name,
					type: 'Title',
					is_ladder: 0
				}))
			});
		}
		if (persona.value?.chapter?.titles && persona.value?.chapter.titles.length > 0) {
			honorSelectOptions.value.push({
				label: `Chapter Titles`,
				options: persona.value?.chapter.titles.map(honor => ({
					value: honor.id,
					text: honor.name,
					type: 'Title',
					is_ladder: 0
				}))
			});
		}
		(persona.value?.units || []).forEach(unit => {
			if (unit.titles && unit.titles.length > 0) {
				honorSelectOptions.value.push({
					label: `${unit.name} Titles`,
					options: unit.titles.map(honor => ({
						value: honor.id,
						text: honor.name,
						type: 'Title',
						is_ladder: 0
					}))
				});
			}
		});
	};
	const handleHonorSelectChange = (selectedValue:any) => {
		const valuesArray = selectedValue.split('|')
		if (valuesArray.length === 3) {
			const [type, value] = valuesArray
			for (const collection of honorSelectOptions.value) {
				if(collection.options){
					for (const option of collection.options) {
						if (option.type == type && option.value == value) {
							recommendFormData.persona_id = persona?.value?.id ? persona.value.id : 0
							recommendFormData.recommendable_id = option.value
							recommendFormData.recommendable_type = option.type
							if (option.is_ladder) {
								if (persona?.value?.awards.hasOwnProperty(option.text)) {
									recommendFormData.rank = persona?.value?.awards[option.text].rank + 1
									showRank.value = true
								}
							} else {
								showRank.value = false
							}
							console.log(recommendFormData)
							break;
						}
					}
				}
			}
		}
		return false;
	}
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
</script>

<template>
	<div class="flex items-center mt-8 intro-y">
		<h2 class="mr-auto text-lg font-medium">{{ persona?.honorific?.name + ' ' }}{{ persona?.name }}</h2>
	</div>
	<Tab.Group>
		<!-- BEGIN: Profile Info -->
		<div class="px-5 pt-5 mt-5 intro-y box">
			<div
				class="flex flex-col pb-5 -mx-5 border-b lg:flex-row border-slate-200/60 dark:border-darkmode-400"
			>
				<div
					class="flex items-center justify-center flex-1 px-5 lg:justify-start"
				>
					<div
						class="relative flex-none w-20 h-20 sm:w-24 sm:h-24 lg:w-32 lg:h-32 image-fit"
					>
						<img
							:alt="persona?.name"
							class="rounded-full"
							:src="persona?.image"
						/>
						<img 
							v-if="persona?.heraldry && !persona?.heraldry.includes('000000.jpg')" 
							style="width: 33%; height: 33%"
							class="absolute top-0 right-0" 
							:src="persona?.heraldry" 
						/>
					</div>
					<div class="ml-5">
						<div class="text-lg font-medium truncate sm:whitespace-normal">
							<template v-for="(peerage, index) in ['Knight', 'Nobility', 'Retainer']">
								<template v-if="persona?.titleIssuances?.filter(titleIssuance => titleIssuance.issuable.peerage === peerage).length">
									<span v-for="(title, titleIndex) in persona.titleIssuances.filter(titleIssuance => titleIssuance.issuable.peerage === peerage)" :key="titleIndex">{{ title.name }}&nbsp;</span>
								</template>
							</template>
						</div>
						<div class="text-slate-500">
							<template v-for="(peerage, index) in ['Master', 'Paragon', 'Gentry', 'None']">
								<template v-if="persona?.titleIssuances?.filter(titleIssuance => titleIssuance.issuable.peerage === peerage).length">
									<span v-for="(title, titleIndex) in persona.titleIssuances.filter(titleIssuance => titleIssuance.issuable.peerage === peerage)" :key="titleIndex">
										{{ title.name }}<span v-if="titleIndex !== persona.titleIssuances.filter(titleIssuance => titleIssuance.issuable.peerage === peerage).length - 1 || index !== ['Master', 'Paragon', 'Gentry', 'None'].length - 1">, </span>
									</span>
								</template>
							</template>
						</div>
						<div class="text-slate-500">
							({{ persona?.pronoun?.subject }}/{{ persona?.pronoun?.object }})
						</div>
						<div v-if="persona?.is_suspended" class="flex items-center truncate sm:whitespace-normal" >
							<Lucide icon="ShieldOff" class="w-4 h-4 mr-2" /> Suspended
						</div>
						<div v-if="persona?.is_active" class="flex items-center truncate sm:whitespace-normal" >
							<Lucide icon="Activity" class="w-4 h-4 mr-2" /> Active
						</div>
						<div v-if="persona?.is_waivered" class="flex items-center truncate sm:whitespace-normal" >
							<Lucide icon="PenTool" class="w-4 h-4 mr-2" /> Waivered
						</div>
						<div v-if="persona?.is_paid" class="flex items-center truncate sm:whitespace-normal" >
							<Lucide icon="DollarSign" class="w-4 h-4 mr-2" /> Dues Paid
						</div>
						<div v-if="persona?.reeve_qualified_expires_at && new Date(persona?.reeve_qualified_expires_at) > new Date()" class="flex items-center truncate sm:whitespace-normal" >
							<Lucide icon="Eye" class="w-4 h-4 mr-2" /> Reeve Qualified
						</div>
						<div v-if="persona?.corpora_qualified_expires_at && new Date(persona?.corpora_qualified_expires_at) > new Date()" class="flex items-center truncate sm:whitespace-normal" >
							<Lucide icon="FileText" class="w-4 h-4 mr-2" /> Corpora Qualified
						</div>
					</div>
				</div>
				<div
					class="flex-1 px-5 pt-5 mt-6 border-t border-l border-r lg:mt-0 border-slate-200/60 dark:border-darkmode-400 lg:border-t-0 lg:pt-0"
				>
					<div class="font-medium text-center lg:text-left lg:mt-3">
						Contact Details
					</div>
					<div
						class="flex flex-col items-center justify-center mt-4 lg:items-start"
					>
						<template v-for="(social, index) in persona?.socials">
							<div class="flex items-center truncate sm:whitespace-normal">
								<Lucide :icon="social.media" class="w-4 h-4 mr-2" />
								<a :href="social.link" target="_blank">{{ social.value }}</a>
							</div>
						</template>
					</div>
				</div>
				<div
					class="flex items-center justify-center flex-1 px-5 pt-5 mt-6 border-t lg:mt-0 lg:border-0 border-slate-200/60 dark:border-darkmode-400 lg:pt-0"
				>
					<div class="w-20 py-3 text-center rounded-md">
						<div class="text-xl font-medium text-primary">{{ persona?.credits.attendance_count }}</div>
						<div class="text-slate-500">Attendances</div>
					</div>
					<div class="w-20 py-3 text-center rounded-md">
						<div class="text-xl font-medium text-primary">{{ persona?.credits.count }}</div>
						<div class="text-slate-500">Credits</div>
					</div>
					<div class="w-20 py-3 text-center rounded-md">
						<div class="text-xl font-medium text-primary">{{ persona?.score }}</div>
						<div class="text-slate-500">Score</div>
					</div>
				</div>
			</div>
			<Tab.List
				v-if="auth.isLoggedIn && (!persona_id || user.persona_id == persona_id)"
				variant="link-tabs"
				class="flex-col justify-center text-center sm:flex-row lg:justify-start"
			>
				<Tab :fullWidth="false">
					<Tab.Button class="flex items-center py-4 cursor-pointer">
						<Lucide icon="User" class="w-4 h-4 mr-2" /> Profile
					</Tab.Button>
				</Tab>
				<Tab :fullWidth="false">
					<Tab.Button class="flex items-center py-4 cursor-pointer">
						<Lucide icon="Shield" class="w-4 h-4 mr-2" /> Account
					</Tab.Button>
				</Tab>
				<Tab :fullWidth="false">
					<Tab.Button class="flex items-center py-4 cursor-pointer">
						<Lucide icon="Settings" class="w-4 h-4 mr-2" /> Settings
					</Tab.Button>
				</Tab>
				<Tab :fullWidth="false">
					<Tab.Button class="flex items-center py-4 cursor-pointer">
						<Lucide icon="Trash2" class="w-4 h-4 mr-2" /> Crypt
					</Tab.Button>
				</Tab>
			</Tab.List>
		</div>
		<!-- END: Profile Info -->
		<Tab.Panels class="mt-5">
			<Tab.Panel>
				<div class="grid grid-cols-12 gap-6">
					<!-- BEGIN: Class Credits -->
					<Tab.Group class="col-span-12 intro-y box lg:col-span-6">
						<div
							class="flex items-center px-5 py-5 border-b sm:py-0 border-slate-200/60 dark:border-darkmode-400"
						>
							<h2 class="mr-auto text-base font-medium py-5">Level Progess</h2>
							<Menu 
								class="ml-auto sm:hidden"
							>
								<Menu.Button tag="a" class="block w-5 h-5" href="#">
									<Lucide
										icon="MoreHorizontal"
										class="w-5 h-5 text-slate-500"
									/>
								</Menu.Button>
								<Menu.Items 
									class="w-40"
								>
									<Menu.Item class="w-full" :as="HeadlessTab"> By Class </Menu.Item>
									<Menu.Item class="w-full" :as="HeadlessTab"> By Credits </Menu.Item>
								</Menu.Items>
							</Menu>
							<Tab.List
								variant="link-tabs"
								class="hidden w-auto ml-auto sm:flex"
							>
								<Tab :fullWidth="false">
									<Tab.Button class="py-5 cursor-pointer"> By Class </Tab.Button>
								</Tab>
								<Tab :fullWidth="false">
									<Tab.Button class="py-5 cursor-pointer"> By Credits </Tab.Button>
								</Tab>
							</Tab.List>
						</div>
						<div class="p-5">
							<Tab.Panels>
								<Tab.Panel>
									<div
										v-for="(archetype) in archetypes.sort((a, b) => a.name.localeCompare(b.name))"
										class="mt-5"
									>
										<div v-if="persona?.credits.archetypes[archetype.name]?.level">
											<div class="flex">
												<div class="mr-auto">{{ archetype.name }} {{ persona?.credits.archetypes[archetype.name]?.level }}</div>
												<div>{{ persona?.credits.archetypes[archetype.name]?.credits }}</div>
											</div>
											<Progress class="h-4">
												<Progress.Bar
													class="progress-bar py-2"
													role="progressbar"
													:aria-valuenow="persona?.credits.archetypes[archetype.name]?.level"
													v-bind:style="{ width: Math.min((persona?.credits.archetypes[archetype.name]?.credits/53) * 100, 100) + '%'}"
													:aria-valuemin="0"
													:aria-valuemax="53"
												>{{ Math.round((persona?.credits.archetypes[archetype.name]?.credits / 53) * 100) + '%' }}</Progress.Bar>
											</Progress>
										</div>
									</div>
<!--									<Button-->
<!--										as="a"-->
<!--										variant="secondary"-->
<!--										href=""-->
<!--										class="block w-40 mx-auto mt-5"-->
<!--									>-->
<!--										View More Details-->
<!--									</Button>-->
								</Tab.Panel>
								<Tab.Panel>
									<div
										v-for="(archetype) in archetypes.sort((a, b) => {
												return (persona?.credits.archetypes[b.name]?.credits || 0) - (persona?.credits.archetypes[a.name]?.credits || 0);
											})"
											class="mt-5"
										>
										<div v-if="persona?.credits.archetypes[archetype.name]?.level">
											<div class="flex">
												<div class="mr-auto">{{ archetype.name }} {{ persona?.credits.archetypes[archetype.name]?.level }}</div>
												<div>{{ persona?.credits.archetypes[archetype.name]?.credits }}</div>
											</div>
											<Progress class="h-4">
												<Progress.Bar
													class="progress-bar py-2"
													role="progressbar"
													:aria-valuenow="persona?.credits.archetypes[archetype.name]?.level"
													v-bind:style="{ width: Math.min((persona?.credits.archetypes[archetype.name]?.credits/53) * 100, 100) + '%'}"
													:aria-valuemin="0"
													:aria-valuemax="53"
												>{{ Math.round((persona?.credits.archetypes[archetype.name]?.credits / 53) * 100) + '%' }}</Progress.Bar>
											</Progress>
										</div>
									</div>
<!--									<Button-->
<!--										as="a"-->
<!--										variant="secondary"-->
<!--										href=""-->
<!--										class="block w-40 mx-auto mt-5"-->
<!--									>-->
<!--										View More Details-->
<!--									</Button>-->
								</Tab.Panel>
							</Tab.Panels>
						</div>
					</Tab.Group>
					<!-- END: Class Credits -->
					<!-- BEGIN: Awards -->
					<Tab.Group class="col-span-12 intro-y box lg:col-span-6">
						<div
							class="flex items-center px-5 py-5 border-b sm:py-0 border-slate-200/60 dark:border-darkmode-400"
						>
							<h2 class="mr-auto text-base font-medium py-5">Honors</h2>
							<Menu 
								class="ml-auto sm:hidden"
							>
								<Menu.Button tag="a" class="block w-5 h-5" href="#">
									<Lucide
										icon="MoreHorizontal"
										class="w-5 h-5 text-slate-500"
									/>
								</Menu.Button>
								<Menu.Items 
									class="w-40"
								>
									<Menu.Item class="w-full" :as="HeadlessTab"> Awards </Menu.Item>
								</Menu.Items>
								<Menu.Items 
									class="w-40"
								>
									<Menu.Item class="w-full" :as="HeadlessTab"> Titles </Menu.Item>
								</Menu.Items>
							</Menu>
							<Tab.List
								variant="link-tabs"
								class="hidden w-auto ml-auto sm:flex"
							>
								<Tab :fullWidth="false">
									<Tab.Button class="py-5 cursor-pointer"> Awards </Tab.Button>
								</Tab>
								<Tab :fullWidth="false">
									<Tab.Button class="py-5 cursor-pointer"> Titles </Tab.Button>
								</Tab>
							</Tab.List>
						</div>
						<div class="p-5" style="padding-top: 0px">
							<Tab.Panels>
								<Tab.Panel>
									<div class="grid grid-cols-12 gap-6 mt-5">
										<div class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap justify-between">
											<Button 
												v-if="auth.isLoggedIn" 
												variant="primary" 
												class="mr-2 shadow-md"
												@click="(event: MouseEvent) => {
													event.preventDefault();
													setRecommendModal(true);
												}"
											>
												Recommend New Award
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
																<FormLabel htmlFor="recommendation-form-honor"> Honor </FormLabel>
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
																<FormLabel htmlFor="recommendation-form-rank"> Rank </FormLabel>
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
																<FormLabel htmlFor="recommendation-form-reason"> Reason </FormLabel>
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
											<Menu>
												<Menu.Button :as="Button" class="px-2 !box">
													<span class="flex items-center justify-center w-5 h-5">
														<Lucide icon="Shuffle" class="w-4 h-4" />
													</span>
												</Menu.Button>
												<Menu.Items class="w-40">
													<Menu.Item @click="sortAwardsBy('issued_at')">
														<Lucide icon="Sunrise" class="w-4 h-4 mr-2" /> First Earned
													</Menu.Item>
													<Menu.Item @click="sortAwardsBy('name')">
														<Lucide icon="Award" class="w-4 h-4 mr-2" /> Award
													</Menu.Item>
													<Menu.Item @click="sortAwardsBy('rank')">
														<Lucide icon="ChevronsDown" class="w-4 h-4 mr-2" /> Rank
													</Menu.Item>
												</Menu.Items>
											</Menu>
										</div>
										<!-- BEGIN: Award List -->
										<div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
											<Table class="border-spacing-y-[10px] border-separate -mt-2">
												<Table.Tbody>
													<Table.Tr
														v-for="(award, name) in persona?.awards"
														:key="name"
														class="intro-x"
													>
														<Table class="border-spacing-y-[10px] border-separate -mt-2">
															<Table.Tbody>
																<Table.Tr>
																	<Table.Td
																		class="box w-40 px-1 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
																	>
																		<div class="flex">
																			<div
																				v-for="(issuance, index) in award.issuances"
																				:key="index"
																			>
																				<div 
																					:class="'w-9 h-9 image-fit zoom-in' + (index !== 0 ? ' -ml-5' : '')" 
																				>
																					<Tippy
																						v-if="issuance.image"
																						as="img"
																						:alt="issuance.name"
																						class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
																						:src="issuance.image"
																						:content="`Issued At: ` + formatDate(issuance.issued_at, 'MMMM DD, YYYY') + (issuance.revoked_at ? ` Revoked: ` + formatDate(issuance.revoked_at, 'MMMM DD, YYYY') : ``)"
																					/>
																				</div>
																			</div>
																		</div>
																	</Table.Td>
																	<Table.Td
																		class="box px-1 text-right rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
																	>
																		<a href="" class="font-medium whitespace-nowrap">
																			{{ name }}
																		</a>
																	</Table.Td>
																	<Table.Td
																		class="box px-1 rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
																	>
																		{{ award.rank }}
																	</Table.Td>
																	<Table.Td
																		:class="[
																			'box px-1 w-15 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
																			'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
																		]"
																	>
																		<div class="flex items-center justify-center">
																			<a 
																				class="flex items-center mr-3" 
																				href="#"
																				@click.prevent="toggleContents(name)"
																			>
																				<Lucide 
																					icon="Eye" 
																					class="w-4 h-4 mr-1" 
																				/>
																			</a>
																		</div>
																	</Table.Td>
																</Table.Tr>
																<Table.Tr
																	v-if="expandedIndex === name"
																>
																	<Table.Td
																		colspan="4"
																		class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
																	>
																		<!-- BEGIN: Awards Details Layout -->
																		<div class="grid grid-cols-12 gap-6 mt-5">
																			<div
																				v-for="(issuance, index) in award.issuances"
																				:key="index"
																				class="col-span-12 intro-y md:col-span-6 lg:col-span-4 xl:col-span-4"
																			>
																				<div class="box" :class="{ 'bg-danger/20': issuance.revoked_at !== null }">
																					<div class="p-5">
																						<div
																							class="h-40 overflow-hidden rounded-md 2xl:h-56 image-fit before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10"
																						>
																							<img
																								alt="Midone - HTML Admin Template"
																								class="rounded-md"
																								:src="issuance.image"
																							/>
																							<div class="absolute bottom-0 z-10 px-5 pb-6 text-white">
																								<a href="" class="block text-base font-medium">
																									{{ issuance.signator?.name }}
																									<span v-if="issuance.issuer?.full_abbreviation">{{ issuance.issuer?.full_abbreviation }}</span>
																									<span v-else>{{ issuance.issuer?.abbreviation }}</span>
																								</a>
																								<span class="mt-3 text-xs text-white/90">
																									{{ formatDate(issuance.issued_at, 'MMMM DD, YYYY') }}
																								</span>
																							</div>
																						</div>
																						<div class="mt-5 text-slate-600 dark:text-slate-500">
																							<div class="flex items-center">
																								Rank: {{ issuance.rank }}
																							</div>
																							<div class="flex items-center mt-2">
																								{{ issuance.reason }}
																							</div>
																							<div v-if="issuance.revoked_at" class="flex items-center">
																								Revoked: {{ formatDate(issuance.revoked_at, 'MMMM DD, YYYY') }}
																							</div>
																							<div v-if="issuance.revoked_at" class="flex items-center">
																								Revoked By: {{ issuance.revoker.name }}
																							</div>
																							<div v-if="issuance.revoked_at" class="flex items-center mt-2">
																								{{ issuance.revocation }}
																							</div>
																						</div>
																					</div>
																					<div
																						class="flex items-center justify-center p-5 border-t lg:justify-end border-slate-200/60 dark:border-darkmode-400"
																					>
																						<a class="flex items-center mr-auto text-primary" href="#" @click="(event: MouseEvent) => {
																							event.preventDefault();
																							setAwardModal(issuance.id);
																						}">
																							<Lucide icon="Eye" class="w-4 h-4 mr-1" />
																						</a>
																						<a v-if="issuance.can_update" class="flex items-center mr-3" href="#">
																							<Lucide icon="CheckSquare" class="w-4 h-4 mr-1" />
																						</a>
																						<a
																							v-if="issuance.can_delete"
																							class="flex items-center text-danger"
																							href="#"
																							@click="
																								(event) => {
																									event.preventDefault();
																									setDeleteConfirmationModal(true);
																								}
																							"
																						>
																							<Lucide icon="Trash2" class="w-4 h-4 mr-1" />
																						</a>
																					</div>
																				</div>
																				<!-- BEGIN: Modal Content -->
																				<Dialog 
																					size="xl"
																					:open="awardModal === issuance.id" 
																					@close="() => {
																						setAwardModal(false);
																					}"
																					class="relative z-50"
																				>
																					<Dialog.Panel>
																						<Dialog.Title>
																							<h2 class="mr-auto text-base font-medium">
																								{{ issuance.name }} {{ issuance.rank }}
																							</h2>
																							<a 
																								@click="(event: MouseEvent) => {
																									event.preventDefault();
																									setAwardModal(false);
																								}" 
																								class="absolute top-0 right-0 mt-2 mr-3" 
																								href="#"
																							>
																								<Lucide icon="X" class="w-8 h-8 text-slate-400" />
																							</a>
																						</Dialog.Title>
																						<Dialog.Description class="grid grid-cols-12 gap-4 gap-y-3">
																							<div class="col-span-12 sm:col-span-6">
																								<strong>Issued:</strong> {{ formatDate(issuance.issued_at, 'MMMM DD, YYYY') }}<br>
																								<strong>Signed By:</strong> {{ issuance.signator?.name }}<br>
																								<strong>Issued By:</strong> {{ issuance.issuer?.name }}<br>
																								<strong>Issued At:</strong> {{ issuance.whereable.label }}<br>
																								<strong>Reason:</strong> {{ issuance.reason }}
																								<span v-if="issuance.revoked_at">
																									<strong>Revoked By:</strong> {{ issuance.revoker?.name }}<br>
																									<strong>Revoked At:</strong> {{ formatDate(issuance.revoked_at, 'MMMM DD, YYYY') }}<br>
																									<strong>Reason:</strong> {{ issuance.revocation }}
																								</span>
																							</div>
																							<div class="col-span-12 sm:col-span-6">
																								<div>
																									<img
																										v-if="!issuance.image.includes('000000.jpg')"
																										:alt="issuance.name"
																										class="rounded-md"
																										:src="issuance.image"
																										style="width: 100%;"
																									/>
																								</div>
																							</div>
																						</Dialog.Description>
																					</Dialog.Panel>
																				</Dialog>
																				<!-- END: Modal Content -->
																			</div>
																		</div>
																		<!-- END: Awards Details Layout -->
																	</Table.Td>
																</Table.Tr>
															</Table.Tbody>
														</Table>
													</Table.Tr>
												</Table.Tbody>
											</Table>
										</div>
										<!-- END: Award List -->
									</div>
								</Tab.Panel>
							</Tab.Panels>
						</div>
					</Tab.Group>
					<!-- END: Awards -->
					<!-- BEGIN: Latest Uploads -->
					<div class="col-span-12 intro-y box lg:col-span-6">
						<div
							class="flex items-center px-5 py-5 border-b sm:py-3 border-slate-200/60 dark:border-darkmode-400"
						>
							<h2 class="mr-auto text-base font-medium">Latest Uploads</h2>
							<Menu class="ml-auto sm:hidden">
								<Menu.Button tag="a" class="block w-5 h-5" href="#">
									<Lucide
										icon="MoreHorizontal"
										class="w-5 h-5 text-slate-500"
									/>
								</Menu.Button>
								<Menu.Items class="w-40">
									<Menu.Item>All Files</Menu.Item>
								</Menu.Items>
							</Menu>
							<Button variant="outline-secondary" class="hidden sm:flex">
								All Files
							</Button>
						</div>
						<div class="p-5">
							<div class="flex items-center">
								<FileIcon class="w-12 file" variant="directory" />
								<div class="ml-4">
									<a class="font-medium" href=""> Documentation </a>
									<div class="text-slate-500 text-xs mt-0.5">40 KB</div>
								</div>
								<Menu class="ml-auto">
									<Menu.Button tag="a" class="block w-5 h-5" href="#">
										<Lucide
											icon="MoreHorizontal"
											class="w-5 h-5 text-slate-500"
										/>
									</Menu.Button>
									<Menu.Items class="w-40">
										<Menu.Item>
											<Lucide icon="Users" class="w-4 h-4 mr-2" /> Share File
										</Menu.Item>
										<Menu.Item>
											<Lucide icon="Trash" class="w-4 h-4 mr-2" />
											Delete
										</Menu.Item>
									</Menu.Items>
								</Menu>
							</div>
							<div class="flex items-center mt-5">
								<FileIcon class="w-12 text-xs file" variant="file" type="MP3" />
								<div class="ml-4">
									<a class="font-medium" href=""> Celine Dion - Ashes </a>
									<div class="text-slate-500 text-xs mt-0.5">40 KB</div>
								</div>
								<Menu class="ml-auto">
									<Menu.Button tag="a" class="block w-5 h-5" href="#">
										<Lucide
											icon="MoreHorizontal"
											class="w-5 h-5 text-slate-500"
										/>
									</Menu.Button>
									<Menu.Items class="w-40">
										<Menu.Item>
											<Lucide icon="Users" class="w-4 h-4 mr-2" /> Share File
										</Menu.Item>
										<Menu.Item>
											<Lucide icon="Trash" class="w-4 h-4 mr-2" />
											Delete
										</Menu.Item>
									</Menu.Items>
								</Menu>
							</div>
							<div class="flex items-center mt-5">
								<FileIcon class="w-12 file" variant="empty-directory" />
								<div class="ml-4">
									<a class="font-medium" href=""> Resources </a>
									<div class="text-slate-500 text-xs mt-0.5">0 KB</div>
								</div>
								<Menu class="ml-auto">
									<Menu.Button tag="a" class="block w-5 h-5" href="#">
										<Lucide
											icon="MoreHorizontal"
											class="w-5 h-5 text-slate-500"
										/>
									</Menu.Button>
									<Menu.Items class="w-40">
										<Menu.Item>
											<Lucide icon="Users" class="w-4 h-4 mr-2" /> Share File
										</Menu.Item>
										<Menu.Item>
											<Lucide icon="Trash" class="w-4 h-4 mr-2" />
											Delete
										</Menu.Item>
									</Menu.Items>
								</Menu>
							</div>
						</div>
					</div>
					<!-- END: Latest Uploads -->
					<!-- BEGIN: Daily Sales -->
					<div class="col-span-12 intro-y box lg:col-span-6">
						<div
							class="flex items-center px-5 py-5 border-b sm:py-3 border-slate-200/60 dark:border-darkmode-400"
						>
							<h2 class="mr-auto text-base font-medium">Daily Sales</h2>
							<Menu class="ml-auto sm:hidden">
								<Menu.Button tag="a" class="block w-5 h-5" href="#">
									<Lucide
										icon="MoreHorizontal"
										class="w-5 h-5 text-slate-500"
									/>
								</Menu.Button>
								<Menu.Items class="w-40">
									<Menu.Item>
										<Lucide icon="File" class="w-4 h-4 mr-2" /> Download Excel
									</Menu.Item>
								</Menu.Items>
							</Menu>
							<Button variant="outline-secondary" class="hidden sm:flex">
								<Lucide icon="File" class="w-4 h-4 mr-2" /> Download Excel
							</Button>
						</div>
						<div class="p-5">
							<div class="relative flex items-center">
								<div class="flex-none w-12 h-12 image-fit">
									<img
										alt="Midone Tailwind HTML Admin Template"
										class="rounded-full"
										:src="fakerData[0].photos[0]"
									/>
								</div>
								<div class="ml-4 mr-auto">
									<a href="" class="font-medium">
										{{ fakerData[0].users[0].name }}
									</a>
									<div class="mr-5 text-slate-500 sm:mr-5">
										Bootstrap 4 HTML Admin Template
									</div>
								</div>
								<div class="font-medium text-slate-600 dark:text-slate-500">
									+$19
								</div>
							</div>
							<div class="relative flex items-center mt-5">
								<div class="flex-none w-12 h-12 image-fit">
									<img
										alt="Midone Tailwind HTML Admin Template"
										class="rounded-full"
										:src="fakerData[1].photos[0]"
									/>
								</div>
								<div class="ml-4 mr-auto">
									<a href="" class="font-medium">
										{{ fakerData[1].users[0].name }}
									</a>
									<div class="mr-5 text-slate-500 sm:mr-5">
										Tailwind HTML Admin Template
									</div>
								</div>
								<div class="font-medium text-slate-600 dark:text-slate-500">
									+$25
								</div>
							</div>
							<div class="relative flex items-center mt-5">
								<div class="flex-none w-12 h-12 image-fit">
									<img
										alt="Midone Tailwind HTML Admin Template"
										class="rounded-full"
										:src="fakerData[2].photos[0]"
									/>
								</div>
								<div class="ml-4 mr-auto">
									<a href="" class="font-medium">
										{{ fakerData[2].users[0].name }}
									</a>
									<div class="mr-5 text-slate-500 sm:mr-5">
										Vuejs HTML Admin Template
									</div>
								</div>
								<div class="font-medium text-slate-600 dark:text-slate-500">
									+$21
								</div>
							</div>
						</div>
					</div>
					<!-- END: Daily Sales -->
					<!-- BEGIN: Latest Tasks -->
					<Tab.Group class="col-span-12 intro-y box lg:col-span-6">
						<div
							class="flex items-center px-5 py-5 border-b sm:py-0 border-slate-200/60 dark:border-darkmode-400"
						>
							<h2 class="mr-auto text-base font-medium">Latest Tasks</h2>
							<Menu class="ml-auto sm:hidden">
								<Menu.Button tag="a" class="block w-5 h-5" href="#">
									<Lucide
										icon="MoreHorizontal"
										class="w-5 h-5 text-slate-500"
									/>
								</Menu.Button>
								<Menu.Items class="w-40">
									<Menu.Item class="w-full" :as="HeadlessTab"> New </Menu.Item>
									<Menu.Item class="w-full" :as="HeadlessTab">
										Last Week
									</Menu.Item>
								</Menu.Items>
							</Menu>
							<Tab.List
								variant="link-tabs"
								class="hidden w-auto ml-auto sm:flex"
							>
								<Tab :fullWidth="false">
									<Tab.Button class="py-5 cursor-pointer"> New </Tab.Button>
								</Tab>
								<Tab :fullWidth="false">
									<Tab.Button class="py-5 cursor-pointer">
										Last Week
									</Tab.Button>
								</Tab>
							</Tab.List>
						</div>
						<div class="p-5">
							<Tab.Panels>
								<Tab.Panel>
									<div class="flex items-center">
										<div
											class="pl-4 border-l-2 border-primary dark:border-primary"
										>
											<a href="" class="font-medium"> Create New Campaign </a>
											<div class="text-slate-500">10:00 AM</div>
										</div>
										<FormSwitch class="ml-auto">
											<FormSwitch.Input type="checkbox" />
										</FormSwitch>
									</div>
									<div class="flex items-center mt-5">
										<div
											class="pl-4 border-l-2 border-primary dark:border-primary"
										>
											<a href="" class="font-medium"> Meeting With Client </a>
											<div class="text-slate-500">02:00 PM</div>
										</div>
										<FormSwitch class="ml-auto">
											<FormSwitch.Input type="checkbox" />
										</FormSwitch>
									</div>
									<div class="flex items-center mt-5">
										<div
											class="pl-4 border-l-2 border-primary dark:border-primary"
										>
											<a href="" class="font-medium"> Create New Repository </a>
											<div class="text-slate-500">04:00 PM</div>
										</div>
										<FormSwitch class="ml-auto">
											<FormSwitch.Input type="checkbox" />
										</FormSwitch>
									</div>
								</Tab.Panel>
							</Tab.Panels>
						</div>
					</Tab.Group>
					<!-- END: Latest Tasks -->
					<!-- BEGIN: New Products -->
					<div class="col-span-12 intro-y box">
						<div
							class="flex items-center px-5 py-3 border-b border-slate-200/60 dark:border-darkmode-400"
						>
							<h2 class="mr-auto text-base font-medium">New Products</h2>
							<Button
								variant="outline-secondary"
								class="px-2 mr-2"
								@click="prevNewProducts"
							>
								<Lucide icon="ChevronLeft" class="w-4 h-4" />
							</Button>
							<Button
								variant="outline-secondary"
								class="px-2"
								@click="nextNewProducts"
							>
								<Lucide icon="ChevronRight" class="w-4 h-4" />
							</Button>
						</div>
						<div id="new-products" class="py-5 tiny-slider">
							<TinySlider refKey="newProductsRef">
								<div
									v-for="(faker, index) in _.take(fakerData, 5)"
									:key="index"
									class="px-5"
								>
									<div class="flex flex-col items-center pb-5 lg:flex-row">
										<div
											class="flex flex-col items-center pr-5 sm:flex-row lg:border-r border-slate-200/60 dark:border-darkmode-400"
										>
											<div class="sm:mr-5">
												<div class="w-20 h-20 image-fit">
													<img
														alt="Midone Tailwind HTML Admin Template"
														class="rounded-full"
														:src="faker.images[0]"
													/>
												</div>
											</div>
											<div
												class="mt-3 mr-auto text-center sm:text-left sm:mt-0"
											>
												<a href="" class="text-lg font-medium">
													{{ faker.products[0].name }}
												</a>
												<div class="mt-1 text-slate-500 sm:mt-0">
													{{ faker.news[0].shortContent }}
												</div>
											</div>
										</div>
										<div
											class="flex items-center justify-center flex-1 w-full px-5 pt-4 mt-6 border-t lg:w-auto lg:mt-0 lg:pt-0 lg:border-t-0 border-slate-200/60 dark:border-darkmode-400"
										>
											<div class="w-20 py-3 text-center rounded-md">
												<div class="text-xl font-medium text-primary">
													{{ faker.totals[0] }}
												</div>
												<div class="text-slate-500">Orders</div>
											</div>
											<div class="w-20 py-3 text-center rounded-md">
												<div class="text-xl font-medium text-primary">
													{{ faker.totals[1] }}k
												</div>
												<div class="text-slate-500">Purchases</div>
											</div>
											<div class="w-20 py-3 text-center rounded-md">
												<div class="text-xl font-medium text-primary">
													{{ faker.totals[0] }}
												</div>
												<div class="text-slate-500">Reviews</div>
											</div>
										</div>
									</div>
									<div
										class="flex flex-col items-center pt-5 border-t sm:flex-row border-slate-200/60 dark:border-darkmode-400"
									>
										<div
											class="flex items-center justify-center w-full pb-5 border-b sm:w-auto sm:justify-start sm:border-b-0 border-slate-200/60 dark:border-darkmode-400 sm:pb-0"
										>
											<div
												class="px-3 py-2 mr-3 font-medium rounded text-primary bg-primary/10 dark:bg-darkmode-400 dark:text-slate-300"
											>
												{{ faker.dates[0] }}
											</div>
											<div class="text-slate-500">Date of Release</div>
										</div>
										<div class="flex mt-5 sm:ml-auto sm:mt-0">
											<Button variant="secondary" class="w-20 ml-auto">
												Preview
											</Button>
											<Button variant="secondary" class="w-20 ml-2">
												Details
											</Button>
										</div>
									</div>
								</div>
							</TinySlider>
						</div>
					</div>
					<!-- END: New Products -->
					<!-- BEGIN: New Authors -->
					<div class="col-span-12 intro-y box">
						<div
							class="flex items-center px-5 py-3 border-b border-slate-200/60 dark:border-darkmode-400"
						>
							<h2 class="mr-auto text-base font-medium">New Authors</h2>
							<Button
								variant="outline-secondary"
								class="px-2 mr-2"
								@click="prevNewAuthors"
							>
								<Lucide icon="ChevronLeft" class="w-4 h-4" />
							</Button>
							<Button
								variant="outline-secondary"
								class="px-2"
								@click="nextNewAuthors"
							>
								<Lucide icon="ChevronRight" class="w-4 h-4" />
							</Button>
						</div>
						<div id="new-authors" class="py-5 tiny-slider">
							<TinySlider refKey="newAuthorsRef">
								<div
									v-for="(faker, index) in _.take(fakerData, 5)"
									:key="index"
									class="px-5"
								>
									<div class="flex flex-col items-center pb-5 lg:flex-row">
										<div
											class="flex flex-col items-center flex-1 pr-5 sm:flex-row lg:border-r border-slate-200/60 dark:border-darkmode-400"
										>
											<div class="sm:mr-5">
												<div class="w-20 h-20 image-fit">
													<img
														alt="Midone Tailwind HTML Admin Template"
														class="rounded-full"
														:src="faker.photos[0]"
													/>
												</div>
											</div>
											<div
												class="mt-3 mr-auto text-center sm:text-left sm:mt-0"
											>
												<a href="" class="text-lg font-medium">
													{{ faker.users[0].name }}
												</a>
												<div class="mt-1 text-slate-500 sm:mt-0">
													{{ faker.jobs[0] }}
												</div>
											</div>
										</div>
										<div
											class="flex flex-col items-center justify-center flex-1 w-full px-5 pt-4 mt-6 border-t lg:w-auto lg:mt-0 lg:pt-0 lg:items-start lg:border-t-0 border-slate-200/60 dark:border-darkmode-400"
										>
											<div class="flex items-center">
												<a
													href=""
													class="flex items-center justify-center w-8 h-8 mr-2 border rounded-full text-slate-400"
												>
													<Lucide
														icon="Facebook"
														class="w-3 h-3 fill-current"
													/>
												</a>
												{{ faker.users[0].email }}
											</div>
											<div class="flex items-center mt-2">
												<a
													href=""
													class="flex items-center justify-center w-8 h-8 mr-2 border rounded-full text-slate-400"
												>
													<Lucide icon="Twitter" class="w-3 h-3 fill-current" />
												</a>
												{{ faker.users[0].name }}
											</div>
										</div>
									</div>
									<div
										class="flex flex-col items-center pt-5 border-t sm:flex-row border-slate-200/60 dark:border-darkmode-400"
									>
										<div
											class="flex items-center justify-center w-full pb-5 border-b sm:w-auto sm:justify-start sm:border-b-0 border-slate-200/60 dark:border-darkmode-400 sm:pb-0"
										>
											<div
												class="px-3 py-2 mr-3 font-medium rounded text-primary bg-primary/10 dark:bg-darkmode-400 dark:text-slate-300"
											>
												{{ faker.dates[0] }}
											</div>
											<div class="text-slate-500">Joined Date</div>
										</div>
										<div class="flex mt-5 sm:ml-auto sm:mt-0">
											<Button variant="secondary" class="w-20 ml-auto">
												Message
											</Button>
											<Button variant="secondary" class="w-20 ml-2">
												Profile
											</Button>
										</div>
									</div>
								</div>
							</TinySlider>
						</div>
					</div>
					<!-- END: New Authors -->
				</div>
			</Tab.Panel>
		</Tab.Panels>
		<Tab.Panels>
			<Tab.Panel>
				Account
			</Tab.Panel>
		</Tab.Panels>
		<Tab.Panels>
			<Tab.Panel>
				Settings
			</Tab.Panel>
		</Tab.Panels>
		<Tab.Panels>
			<Tab.Panel>
				Crypt
			</Tab.Panel>
		</Tab.Panels>
	</Tab.Group>
</template>
