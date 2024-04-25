<script setup lang="ts">
	import { ref, onMounted } from "vue";
	import { Tab, Menu, Dialog } from "@/components/Base/Headless";
	import { Tab as HeadlessTab } from "@headlessui/vue";
	import Button from "@/components/Base/Button";
	import { 
		Member,
		Persona,
	} from '@/interfaces';
	import { formatDate } from "@/utils/helper";
	import Lucide from "@/components/Base/Lucide";
	import { useStateStore } from '@/stores/state';
	import axios from 'axios';
	import Loader from "@/components/Base/Loader";
	
	const state = useStateStore()
	const props = defineProps<{
		persona_id: number
	}>()
	const persona = ref<Persona>()
	const isLoading = ref<boolean>(false)
	
	onMounted(() => {
		fetchPersonaData()
	})
	
	const fetchPersonaData = async () => {
		try {
			isLoading.value = true
			let withArray = [
				'memberships',
				'memberships.unit',
				'memberships.unit.awards',
				'memberships.unit.titles',
			];
			let withJoin = withArray.map(item => `with[]=${item}`).join('&');
			await axios.get("/api/personas/" + props.persona_id + "?" + withJoin)
				.then(response => {
					isLoading.value = false
					persona.value = response.data.data;
				});
		} catch (error: any) {
			isLoading.value = false
			state.storeState('error', error)
			console.error('Error fetching user data:', error);
		}
	};
	
	const companyModal = ref<number | boolean>(false);
	const setCompanyModal = (value: number | boolean) => {
		companyModal.value = value;
	};
	
	const householdModal = ref<number | boolean>(false);
	const setHouseholdModal = (value: number | boolean) => {
		householdModal.value = value;
	};
	
	const sortUnitsBy = (attribute: string) => {
		if(persona.value) {
			const targetMemberships = persona.value.memberships as Member[];
			switch (attribute) {
				case 'joined_at':
					targetMemberships.sort((a, b) => {
							const dateA = a.joined_at ? new Date(a.joined_at).getTime() : 0;
							const dateB = b.joined_at ? new Date(b.joined_at).getTime() : 0;
						return dateA - dateB;
					})
					break;
				case 'name':
					targetMemberships.sort((a, b) => {
						const nameA = (a.unit.name || '').toUpperCase();
						const nameB = (b.unit.name || '').toUpperCase();
						if (!nameA && nameB) {
							return -1;
						}
						if (nameA && !nameB) {
							return 1;
						}
						if (nameA < nameB) {
							return -1;
						}
						if (nameA > nameB) {
							return 1;
						}
						return 0;
					})
					break;
				default:
					// Do nothing if an invalid attribute is provided
					break;
			}
		}
	}
	
	const deleteConfirmationModal = ref(false)
	const setDeleteConfirmationModal = (value: boolean) => {
		deleteConfirmationModal.value = value
	};
</script>

<template>
					<Tab.Group class="col-span-12 intro-y box lg:col-span-6" style="height: 100%; overflow-y: scroll;">
						<Loader 
							:active="isLoading"
							message="Loading Unit Data"
						/>
						<div
							class="flex items-center px-5 py-5 border-b sm:py-0 border-slate-200/60 dark:border-darkmode-400"
						>
							<h2 class="mr-auto text-base font-medium py-5">Unit Memberships</h2>
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
									<Menu.Item class="w-full" :as="HeadlessTab"> Fighting Companies </Menu.Item>
									<Menu.Item class="w-full" :as="HeadlessTab"> Households </Menu.Item>
								</Menu.Items>
							</Menu>
							<Tab.List
								variant="link-tabs"
								class="hidden w-auto ml-auto sm:flex"
							>
								<Tab :fullWidth="false">
									<Tab.Button class="py-5 cursor-pointer"> Fighting Companies </Tab.Button>
								</Tab>
								<Tab :fullWidth="false">
									<Tab.Button class="py-5 cursor-pointer"> Households </Tab.Button>
								</Tab>
							</Tab.List>
						</div>
						<div class="p-5" style="padding-top: 0px">
							<Tab.Panels>
								<!-- BEGIN: Fighting Companies Panel -->
								<Tab.Panel>
									<div class="grid grid-cols-12 gap-6 mt-5">
										<div class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap justify-between">
											<span class="relative">&nbsp;</span>
											<Menu>
												<Menu.Button :as="Button" class="px-2 !box">
													<span class="flex items-center justify-center w-5 h-5">
														<Lucide icon="Shuffle" class="w-4 h-4" />
													</span>
												</Menu.Button>
												<Menu.Items class="w-40">
													<Menu.Item @click="sortUnitsBy('joined_at')">
														<Lucide icon="Sunrise" class="w-4 h-4 mr-2" /> First Earned
													</Menu.Item>
													<Menu.Item @click="sortUnitsBy('name')">
														<Lucide icon="Award" class="w-4 h-4 mr-2" /> Fighting Company
													</Menu.Item>
												</Menu.Items>
											</Menu>
										</div>
										<!-- BEGIN: Fighting Companies List -->
										<div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
											<!-- BEGIN: Fighting Companies Details Layout -->
											<div class="grid grid-cols-12 gap-6 mt-5">
												<div
													v-for="(membership, index) in persona?.memberships?.filter(membership => membership.unit.type === 'Company')"
													:key="index"
													class="col-span-12 intro-y md:col-span-6 lg:col-span-4 xl:col-span-4"
												>
													<div class="box" :class="{ 'bg-danger/20': membership.left_at !== null }">
														<div class="p-5">
															<div
																class="h-40 overflow-hidden rounded-md 2xl:h-56 image-fit before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10"
															>
																<img
																	:alt="membership.unit.name"
																	class="rounded-md"
																	:src="membership.unit.heraldry"
																/>
																<div class="absolute bottom-0 z-10 px-5 pb-6 text-white">
																	<a href="" class="block text-base font-medium">
																		{{ membership.unit.name }}
																	</a>
																	<span v-if="membership.joined_at" class="mt-3 text-xs text-white/90">
																		{{ formatDate(membership.joined_at, 'MMMM DD, YYYY') }}
																	</span>
																</div>
															</div>
															<div class="mt-5 text-slate-600 dark:text-slate-500">
																<div class="flex items-center">
																	Head: {{ membership.is_head }}
																</div>
																<div class="flex items-center">
																	Full Member: {{ membership.is_voting }}
																</div>
																<div v-if="membership.left_at" class="flex items-center">
																	Left: {{ formatDate(membership.left_at, 'MMMM DD, YYYY') }}
																</div>
																<div class="flex items-center mt-2">
																	{{ membership.notes }}
																</div>
															</div>
														</div>
														<div
															class="flex items-center justify-center p-5 border-t lg:justify-end border-slate-200/60 dark:border-darkmode-400"
														>
															<a class="flex items-center mr-auto text-primary" href="#" @click="(event: MouseEvent) => {
																event.preventDefault();
																setCompanyModal(membership.unit.id);
															}">
																<Lucide icon="Eye" class="w-4 h-4 mr-1" />
															</a>
															<a v-if="membership.unit.can_update" class="flex items-center mr-3" href="#">
																<Lucide icon="CheckSquare" class="w-4 h-4 mr-1" />
															</a>
															<a
																v-if="membership.unit.can_delete"
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
														:open="companyModal === membership.unit.id" 
														@close="() => {
															setCompanyModal(false);
														}"
														class="relative z-50"
													>
														<Dialog.Panel>
															<Dialog.Title>
																<h2 class="mr-auto text-base font-medium">
																	{{ membership.unit.name }}
																</h2>
																<a 
																	@click="(event: MouseEvent) => {
																		event.preventDefault();
																		setCompanyModal(false);
																	}" 
																	class="absolute top-0 right-0 mt-2 mr-3" 
																	href="#"
																>
																	<Lucide icon="X" class="w-8 h-8 text-slate-400" />
																</a>
															</Dialog.Title>
															<Dialog.Description class="grid grid-cols-12 gap-4 gap-y-3">
																<div class="col-span-12 sm:col-span-6">
																	<span v-if="membership.joined_at"><strong>Joined:</strong> {{ formatDate(membership.joined_at, 'MMMM DD, YYYY') }}<br></span>
																	<strong>Notes:</strong> {{ membership.notes }}
																</div>
																<div class="col-span-12 sm:col-span-6">
																	<div>
																		<img
																			v-if="!membership.unit.heraldry.includes('000000.jpg')"
																			:alt="membership.unit.name"
																			class="rounded-md"
																			:src="membership.unit.heraldry"
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
											<!-- END: Fighting Companies Details Layout -->
										</div>
										<!-- END: Fighting Companies List -->
									</div>
								</Tab.Panel>
								<!-- END: Fighting Companies Panel -->
								<!-- BEGIN: Households Panel -->
								<Tab.Panel>
									<div class="grid grid-cols-12 gap-6 mt-5">
										<div class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap justify-between">
											<span class="relative">&nbsp;</span>
											<Menu>
												<Menu.Button :as="Button" class="px-2 !box">
													<span class="flex items-center justify-center w-5 h-5">
														<Lucide icon="Shuffle" class="w-4 h-4" />
													</span>
												</Menu.Button>
												<Menu.Items class="w-40">
													<Menu.Item @click="sortUnitsBy('joined_at')">
														<Lucide icon="Sunrise" class="w-4 h-4 mr-2" /> First Earned
													</Menu.Item>
													<Menu.Item @click="sortUnitsBy('name')">
														<Lucide icon="Award" class="w-4 h-4 mr-2" /> Household
													</Menu.Item>
												</Menu.Items>
											</Menu>
										</div>
										<!-- BEGIN: Households List -->
										<div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
											<!-- BEGIN: Households Details Layout -->
											<div class="grid grid-cols-12 gap-6 mt-5">
												<div
													v-for="(membership, index) in persona?.memberships?.filter(membership => membership.unit.type === 'Household')"
													:key="index"
													class="col-span-12 intro-y md:col-span-6 lg:col-span-4 xl:col-span-4"
												>
													<div class="box" :class="{ 'bg-danger/20': membership.left_at !== null }">
														<div class="p-5">
															<div
																class="h-40 overflow-hidden rounded-md 2xl:h-56 image-fit before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10"
															>
																<img
																	:alt="membership.unit.name"
																	class="rounded-md"
																	:src="membership.unit.heraldry"
																/>
																<div class="absolute bottom-0 z-10 px-5 pb-6 text-white">
																	<a href="" class="block text-base font-medium">
																		{{ membership.unit.name }}
																	</a>
																	<span v-if="membership.joined_at" class="mt-3 text-xs text-white/90">
																		{{ formatDate(membership.joined_at, 'MMMM DD, YYYY') }}
																	</span>
																</div>
															</div>
															<div class="mt-5 text-slate-600 dark:text-slate-500">
																<div class="flex items-center">
																	Head: {{ membership.is_head }}
																</div>
																<div class="flex items-center">
																	Full Member: {{ membership.is_voting }}
																</div>
																<div v-if="membership.left_at" class="flex items-center">
																	Left: {{ formatDate(membership.left_at, 'MMMM DD, YYYY') }}
																</div>
																<div class="flex items-center mt-2">
																	{{ membership.notes }}
																</div>
															</div>
														</div>
														<div
															class="flex items-center justify-center p-5 border-t lg:justify-end border-slate-200/60 dark:border-darkmode-400"
														>
															<a class="flex items-center mr-auto text-primary" href="#" @click="(event: MouseEvent) => {
																event.preventDefault();
																setHouseholdModal(membership.unit.id);
															}">
																<Lucide icon="Eye" class="w-4 h-4 mr-1" />
															</a>
															<a v-if="membership.unit.can_update" class="flex items-center mr-3" href="#">
																<Lucide icon="CheckSquare" class="w-4 h-4 mr-1" />
															</a>
															<a
																v-if="membership.unit.can_delete"
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
														:open="householdModal === membership.unit.id" 
														@close="() => {
															setHouseholdModal(false);
														}"
														class="relative z-50"
													>
														<Dialog.Panel>
															<Dialog.Title>
																<h2 class="mr-auto text-base font-medium">
																	{{ membership.unit.name }}
																</h2>
																<a 
																	@click="(event: MouseEvent) => {
																		event.preventDefault();
																		setHouseholdModal(false);
																	}" 
																	class="absolute top-0 right-0 mt-2 mr-3" 
																	href="#"
																>
																	<Lucide icon="X" class="w-8 h-8 text-slate-400" />
																</a>
															</Dialog.Title>
															<Dialog.Description class="grid grid-cols-12 gap-4 gap-y-3">
																<div class="col-span-12 sm:col-span-6">
																	<span v-if="membership.joined_at"><strong>Joined:</strong> {{ formatDate(membership.joined_at, 'MMMM DD, YYYY') }}<br></span>
																	<strong>Notes:</strong> {{ membership.notes }}
																</div>
																<div class="col-span-12 sm:col-span-6">
																	<div>
																		<img
																			v-if="!membership.unit.heraldry.includes('000000.jpg')"
																			:alt="membership.unit.name"
																			class="rounded-md"
																			:src="membership.unit.heraldry"
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
											<!-- END: Households Details Layout -->
										</div>
										<!-- END: Households List -->
									</div>
								</Tab.Panel>
								<!-- END: Households Panel -->
							</Tab.Panels>
						</div>
					</Tab.Group>
</template>
