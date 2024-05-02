<script setup lang="ts">
	import { ref } from "vue";
	import { Tab, Menu, Dialog } from "@/components/Base/Headless";
	import { Tab as HeadlessTab } from "@headlessui/vue";
	import Button from "@/components/Base/Button";
	import { 
		Persona,
		Recommendation,
	} from '@/interfaces';
	import { formatDate } from "@/utils/helper";
	import Lucide from "@/components/Base/Lucide";
	import Table from "@/components/Base/Table";
	import Loader from "@/components/Base/Loader";
	
	const props = defineProps<{
		persona: Persona | undefined
	}>()
	const isLoading = ref<boolean>(false)
	const thisWindow = window
	
	const deleteConfirmationModal = ref(false)
	const setDeleteConfirmationModal = (value: boolean) => {
		deleteConfirmationModal.value = value
	};
	
	const recommendationModal = ref<number | boolean>(false);
	const setRecommendationModal = (value: number | boolean) => {
		recommendationModal.value = value;
	};
	
	const sortRecommendationsBy = (attribute: string) => {
		if(props.persona) {
			const targetRecommendations = props.persona.recommendations as Recommendation[];
			switch (attribute) {
				case 'created_at':
					targetRecommendations.sort((a, b) => {
							const dateA = a.created_at ? new Date(a.created_at).getTime() : 0;
							const dateB = b.created_at ? new Date(b.created_at).getTime() : 0;
						return dateA - dateB;
					})
					break;
				case 'name':
					targetRecommendations.sort((a, b) => {
						const nameA = (a.recommendable.name || '').toUpperCase();
						const nameB = (b.recommendable.name || '').toUpperCase();
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
				case 'rank':
					targetRecommendations.sort((a, b) => {
						const rankA = a.rank ? a.rank : 0;
						const rankB = b.rank ? b.rank : 0;
						return rankB - rankA;
					});
					break;
				default:
					// Do nothing if an invalid attribute is provided
					break;
			}
		}
	}
</script>

<template>
					<Tab.Group class="col-span-12 intro-y box lg:col-span-6" style="height: 100%; overflow: scroll;">
						<Loader 
							:active="isLoading"
							message="Loading Recommendation Data"
						/>
						<div
							class="flex items-center px-5 py-5 border-b sm:py-0 border-slate-200/60 dark:border-darkmode-400"
						>
							<h2 class="mr-auto text-base font-medium py-5">Recommendations</h2>
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
								<!-- Begin: Awards Panel -->
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
													<Menu.Item @click="sortRecommendationsBy('created_at')">
														<Lucide icon="Sunrise" class="w-4 h-4 mr-2" /> Created
													</Menu.Item>
													<Menu.Item @click="sortRecommendationsBy('name')">
														<Lucide icon="Award" class="w-4 h-4 mr-2" /> Award
													</Menu.Item>
													<Menu.Item @click="sortRecommendationsBy('rank')">
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
														v-for="(recommendation, index) in persona?.recommendations?.filter(recommendation => recommendation.recommendable_type === 'Award')"
														:key="index"
														class="intro-x"
													>
														<Table.Td
															class="py-3 px-5 border-b dark:border-darkmode-300 box text-left rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
														>
															<a href="" class="font-medium whitespace-nowrap">
																{{ recommendation.recommendable.name }} {{ recommendation.rank }}
															</a>
														</Table.Td>
														<Table.Td
															v-if="thisWindow.innerWidth > 1804"
															class="box px-1 rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600 lg:visible"
														>
															<div style="overflow: hidden; height: 18px">
																{{ recommendation.reason }}
															</div>
														</Table.Td>
														<Table.Td
															:class="[
																'box px-1 w-15 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
																'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
															]"
														>
															<div class="flex items-center justify-center px-3">
																<a class="flex items-center mr-auto text-primary" href="#" @click="(event: MouseEvent) => {
																	event.preventDefault();
																	setRecommendationModal(recommendation.id);
																}">
																	<Lucide icon="Eye" class="w-4 h-4 mr-1" />
																</a>
																<a v-if="recommendation.can_update" class="flex items-center mr-3" href="#">
																	<Lucide icon="CheckSquare" class="w-4 h-4 mr-1" />
																</a>
																<a
																	v-if="recommendation.can_delete"
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
															<!-- BEGIN: Modal Content -->
															<Dialog 
																size="sm"
																:open="recommendationModal === recommendation.id" 
																@close="() => {
																	setRecommendationModal(false);
																}"
																class="relative z-50"
															>
																<Dialog.Panel>
																	<Dialog.Title>
																		<h2 class="mr-auto text-base font-medium">
																			{{ recommendation.recommendable.name }} {{ recommendation.rank }}
																		</h2>
																		<a 
																			@click="(event: MouseEvent) => {
																				event.preventDefault();
																				setRecommendationModal(false);
																			}" 
																			class="absolute top-0 right-0 mt-2 mr-3" 
																			href="#"
																		>
																			<Lucide icon="X" class="w-8 h-8 text-slate-400" />
																		</a>
																	</Dialog.Title>
																	<Dialog.Description>
																		<div>
																			<strong>Created:</strong> {{ formatDate(recommendation.created_at, 'MMMM DD, YYYY') }}<br>
																			<strong>Reason:</strong> {{ recommendation.reason }}
																		</div>
																	</Dialog.Description>
																</Dialog.Panel>
															</Dialog>
															<!-- END: Modal Content -->
														</Table.Td>
													</Table.Tr>	
												</Table.Tbody>
											</Table>
										</div>
										<!-- END: Award List -->
									</div>
								</Tab.Panel>
								<!-- END: Awards Panel -->
								<!-- BEGIN: Titles Panel -->
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
													<Menu.Item @click="sortRecommendationsBy('created_at')">
														<Lucide icon="Sunrise" class="w-4 h-4 mr-2" /> Created
													</Menu.Item>
													<Menu.Item @click="sortRecommendationsBy('name')">
														<Lucide icon="Award" class="w-4 h-4 mr-2" /> Award
													</Menu.Item>
													<Menu.Item @click="sortRecommendationsBy('rank')">
														<Lucide icon="ChevronsDown" class="w-4 h-4 mr-2" /> Rank
													</Menu.Item>
												</Menu.Items>
											</Menu>
										</div>
										<!-- BEGIN: Title List -->
										<div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
											<Table class="border-spacing-y-[10px] border-separate -mt-2">
												<Table.Tbody>
													<Table.Tr
														v-for="(recommendation, index) in persona?.recommendations?.filter(recommendation => recommendation.recommendable_type === 'Title')"
														:key="index"
														class="intro-x"
													>
														<Table.Td
															class="py-3 px-5 border-b dark:border-darkmode-300 box text-left rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
														>
															<a href="" class="font-medium whitespace-nowrap">
																{{ recommendation.recommendable.name }} {{ recommendation.rank }}
															</a>
														</Table.Td>
														<Table.Td
															class="box px-1 rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
														>
															<div style="overflow: hidden; height: 18px">
																{{ recommendation.reason }}
															</div>
														</Table.Td>
														<Table.Td
															:class="[
																'box px-1 w-15 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
																'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
															]"
														>
															<div class="flex items-center justify-center px-3">
																<a class="flex items-center mr-auto text-primary" href="#" @click="(event: MouseEvent) => {
																	event.preventDefault();
																	setRecommendationModal(recommendation.id);
																}">
																	<Lucide icon="Eye" class="w-4 h-4 mr-1" />
																</a>
																<a v-if="recommendation.can_update" class="flex items-center mr-3" href="#">
																	<Lucide icon="CheckSquare" class="w-4 h-4 mr-1" />
																</a>
																<a
																	v-if="recommendation.can_delete"
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
															<!-- BEGIN: Modal Content -->
															<Dialog 
																size="sm"
																:open="recommendationModal === recommendation.id" 
																@close="() => {
																	setRecommendationModal(false);
																}"
																class="relative z-50"
															>
																<Dialog.Panel>
																	<Dialog.Title>
																		<h2 class="mr-auto text-base font-medium">
																			{{ recommendation.recommendable.name }} {{ recommendation.rank }}
																		</h2>
																		<a 
																			@click="(event: MouseEvent) => {
																				event.preventDefault();
																				setRecommendationModal(false);
																			}" 
																			class="absolute top-0 right-0 mt-2 mr-3" 
																			href="#"
																		>
																			<Lucide icon="X" class="w-8 h-8 text-slate-400" />
																		</a>
																	</Dialog.Title>
																	<Dialog.Description>
																		<div>
																			<strong>Created:</strong> {{ formatDate(recommendation.created_at, 'MMMM DD, YYYY') }}<br>
																			<strong>Reason:</strong> {{ recommendation.reason }}
																		</div>
																	</Dialog.Description>
																</Dialog.Panel>
															</Dialog>
															<!-- END: Modal Content -->
														</Table.Td>
													</Table.Tr>	
												</Table.Tbody>
											</Table>
										</div>
										<!-- END: Title List -->
									</div>
								</Tab.Panel>
							</Tab.Panels>
						</div>
					</Tab.Group>
</template>
