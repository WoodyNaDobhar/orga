<script setup lang="ts">
	import { Tab, Menu, Dialog } from "@/components/Base/Headless";
	import { Tab as HeadlessTab } from "@headlessui/vue";
	import { ref } from "vue";
	import { 
		AwardInfo,
		AwardsReport,
		Issuance,
		Persona 
	} from "@/interfaces";
	import { formatDate } from "@/utils/helper";
	import Tippy from "@/components/Base/Tippy";
	import Button from "@/components/Base/Button";
	import Lucide from "@/components/Base/Lucide";
	import Table from "@/components/Base/Table";
	import RecommendButton from "@/components/Profile/RecommendButton";
	
	const props = defineProps<{
		persona: Persona | undefined
	}>()
	
	const sortHonorsBy = (target: string, attribute: string) => {
		if(props.persona) {
			switch (target) {
				case 'awards':
					const targetAwards = props.persona.awards as AwardsReport;
					switch (attribute) {
						case 'issued_on':
							var sortedAwards = Object.entries(targetAwards).sort(([, a], [, b]) => {
								// Find the lowest issued_on value for each award
								var lowestIssuedAtA = Math.min(...a.issuances.map((issuance: Issuance) => new Date(issuance.issued_on).getTime()));
								var lowestIssuedAtB = Math.min(...b.issuances.map((issuance: Issuance) => new Date(issuance.issued_on).getTime()));
								// Compare the lowest issued_on values
								return lowestIssuedAtA - lowestIssuedAtB;
							});
							props.persona.awards = Object.fromEntries(sortedAwards) as AwardsReport
							break;
						case 'name':
							var order = Object.keys(targetAwards).sort()
							const sortedObj: { [key: string]: AwardInfo } = {};
							order.forEach(key => {
								sortedObj[key] = targetAwards[key];
							});
							props.persona.awards = sortedObj
							break;
						case 'rank':
							props.persona.awards = Object.fromEntries(Object.entries(targetAwards).sort(([, a], [, b]) => {
								return (b.rank || 0) - (a.rank || 0);
							}));
							break;
						default:
							break;
					}
					break;
				case 'titles':
					const targetTitles = props.persona?.titleIssuances as Issuance[];
					switch (attribute) {
						case 'issued_on':
							targetTitles.sort((a, b) => {
								const dateA = new Date(a.issued_on).getTime();
								const dateB = new Date(b.issued_on).getTime();
								return dateA - dateB;
							})
							break;
						case 'name':
							targetTitles.sort((a, b) => {
								const nameA = (a.name || '').toUpperCase();
								const nameB = (b.name || '').toUpperCase();
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
							targetTitles.sort((a, b) => {
								const rankA = (a.issuable && 'rank' in a.issuable) ? (a.issuable.rank || 0) : 0;
								const rankB = (b.issuable && 'rank' in b.issuable) ? (b.issuable.rank || 0) : 0;
								return rankB - rankA;
							});
							break;
						default:
							// Do nothing if an invalid attribute is provided
							break;
					}
				default:
					// Do nothing if an invalid target is provided
					break;
			}
		}
	}
	
	const expandedIndex = ref()
	const toggleContents = (index: string) => {
		expandedIndex.value = expandedIndex.value === index ? null : index;
	}
	
	const awardModal = ref<number | boolean>(false)
	const setAwardModal = (value: number | boolean) => {
		awardModal.value = value
	}
	
	const titleModal = ref<number | boolean>(false)
	const setTitleModal = (value: number | boolean) => {
		titleModal.value = value;
	}
	
	const deleteConfirmationModal = ref(false)
	const setDeleteConfirmationModal = (value: boolean) => {
		deleteConfirmationModal.value = value
	};
</script>

<template>
					<Tab.Group class="col-span-12 intro-y box lg:col-span-6" style="height: 100%; overflow: scroll;">
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
											<RecommendButton :persona="persona" />
											<Menu>
												<Menu.Button :as="Button" class="px-2 !box">
													<span class="flex items-center justify-center w-5 h-5">
														<Lucide icon="Shuffle" class="w-4 h-4" />
													</span>
												</Menu.Button>
												<Menu.Items class="w-40">
													<Menu.Item @click="sortHonorsBy('awards', 'issued_on')">
														<Lucide icon="Sunrise" class="w-4 h-4 mr-2" /> First Earned
													</Menu.Item>
													<Menu.Item @click="sortHonorsBy('awards', 'name')">
														<Lucide icon="Award" class="w-4 h-4 mr-2" /> Award
													</Menu.Item>
													<Menu.Item @click="sortHonorsBy('awards', 'rank')">
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
																		<div class="flex max-sm:hidden">
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
																						class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0pxx_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
																						:src="issuance.image"
																						:content="`Issued At: ` + formatDate(issuance.issued_on, 'MMMM DD, YYYY') + (issuance.revoked_on ? ` Revoked: ` + formatDate(issuance.revoked_on, 'MMMM DD, YYYY') : ``)"
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
																				@click.prevent="toggleContents(name.toString())"
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
																				<div class="box" :class="{ 'bg-danger/20': issuance.revoked_on !== null }">
																					<div class="p-5">
																						<div
																							class="h-40 overflow-hidden rounded-md 2xl:h-56 image-fit before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10"
																						>
																							<img
																								:alt="issuance.name"
																								class="rounded-md"
																								:src="issuance.image"
																							/>
																							<div class="absolute bottom-0 z-10 px-5 pb-6 text-white">
																								<a href="" class="block text-base font-medium">
																									{{ issuance.signator?.name }}
																									<span v-if="issuance.issuer.full_abbreviation">{{ issuance.issuer.full_abbreviation }}</span>
																									<span v-else>{{ issuance.issuer.abbreviation }}</span>
																								</a>
																								<span class="mt-3 text-xs text-white/90">
																									{{ formatDate(issuance.issued_on, 'MMMM DD, YYYY') }}
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
																							<div v-if="issuance.revoked_on" class="flex items-center">
																								Revoked: {{ formatDate(issuance.revoked_on, 'MMMM DD, YYYY') }}
																							</div>
																							<div v-if="issuance.revoked_on" class="flex items-center">
																								Revoked By: {{ issuance.revoker?.name }}
																							</div>
																							<div v-if="issuance.revoked_on" class="flex items-center mt-2">
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
																								<strong>Issued:</strong> {{ formatDate(issuance.issued_on, 'MMMM DD, YYYY') }}<br>
																								<strong>Signed By:</strong> {{ issuance.signator?.name }}<br>
																								<strong>Issued By:</strong> {{ issuance.issuer.name }}<br>
																								<strong>Issued At:</strong> {{ issuance.whereable?.name }}<br>
																								<strong>Reason:</strong> {{ issuance.reason }}
																								<span v-if="issuance.revoked_on">
																									<strong>Revoked By:</strong> {{ issuance.revoker?.name }}<br>
																									<strong>Revoked At:</strong> {{ formatDate(issuance.revoked_on, 'MMMM DD, YYYY') }}<br>
																									<strong>Reason:</strong> {{ issuance.revocation }}
																								</span>
																							</div>
																							<div class="col-span-12 sm:col-span-6">
																								<div>
																									<img
																										v-if="!issuance.image"
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
								<!-- END: Awards Panel -->
								<!-- BEGIN: Titles Panel -->
								<Tab.Panel>
									<div class="grid grid-cols-12 gap-6 mt-5">
										<div class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap justify-between">
											<RecommendButton :persona="persona" />
											<Menu>
												<Menu.Button :as="Button" class="px-2 !box">
													<span class="flex items-center justify-center w-5 h-5">
														<Lucide icon="Shuffle" class="w-4 h-4" />
													</span>
												</Menu.Button>
												<Menu.Items class="w-40">
													<Menu.Item @click="sortHonorsBy('titles', 'issued_on')">
														<Lucide icon="Sunrise" class="w-4 h-4 mr-2" /> First Earned
													</Menu.Item>
													<Menu.Item @click="sortHonorsBy('titles', 'name')">
														<Lucide icon="Award" class="w-4 h-4 mr-2" /> Title
													</Menu.Item>
													<Menu.Item @click="sortHonorsBy('titles', 'rank')">
														<Lucide icon="ChevronsDown" class="w-4 h-4 mr-2" /> Rank
													</Menu.Item>
												</Menu.Items>
											</Menu>
										</div>
										<!-- BEGIN: Titles List -->
										<div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
											<!-- BEGIN: Titles Details Layout -->
											<div class="grid grid-cols-12 gap-6 mt-5">
												<div
													v-for="(issuance, index) in persona?.titleIssuances"
													:key="index"
													class="col-span-12 intro-y md:col-span-6 lg:col-span-4 xl:col-span-4"
												>
													<div class="box" :class="{ 'bg-danger/20': issuance.revoked_on !== null }">
														<div class="p-5">
															<div
																class="h-40 overflow-hidden rounded-md 2xl:h-56 image-fit before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10"
															>
																<img
																	:alt="issuance.name"
																	class="rounded-md"
																	:src="issuance.image"
																/>
																<div class="absolute bottom-0 z-10 px-5 pb-6 text-white">
																	<a href="" class="block text-base font-medium">
																		{{ issuance.name }}
																		<span v-if="issuance.issuer.full_abbreviation">({{ issuance.issuer.full_abbreviation }})</span>
																		<span v-else-if="issuance.issuer.abbreviation">({{ issuance.issuer.abbreviation }})</span>
																		<span v-else>to {{ issuance.issuer.name }}</span>
																	</a>
																	<span class="mt-3 text-xs text-white/90">
																		{{ formatDate(issuance.issued_on, 'MMMM DD, YYYY') }}
																	</span>
																</div>
															</div>
															<div class="mt-5 text-slate-600 dark:text-slate-500">
																<div v-if="issuance.name != issuance.issuable.name" class="flex items-center mt-2">
																	{{ issuance.issuable.name }}
																</div>
																<div class="flex items-center mt-2">
																	{{ issuance.reason }}
																</div>
																<div class="flex items-center">
																	Peerage: {{ issuance.issuable.peerage }}
																</div>
																<div v-if="issuance.revoked_on" class="flex items-center">
																	Revoked: {{ formatDate(issuance.revoked_on, 'MMMM DD, YYYY') }}
																</div>
																<div v-if="issuance.revoked_on" class="flex items-center">
																	Revoked By: {{ issuance.revoker?.name }}
																</div>
																<div v-if="issuance.revoked_on" class="flex items-center mt-2">
																	{{ issuance.revocation }}
																</div>
															</div>
														</div>
														<div
															class="flex items-center justify-center p-5 border-t lg:justify-end border-slate-200/60 dark:border-darkmode-400"
														>
															<a class="flex items-center mr-auto text-primary" href="#" @click="(event: MouseEvent) => {
																event.preventDefault();
																setTitleModal(issuance.id);
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
														:open="titleModal === issuance.id" 
														@close="() => {
															setTitleModal(false);
														}"
														class="relative z-50"
													>
														<Dialog.Panel>
															<Dialog.Title>
																<h2 class="mr-auto text-base font-medium">
																	{{ issuance.name }}
																</h2>
																<a 
																	@click="(event: MouseEvent) => {
																		event.preventDefault();
																		setTitleModal(false);
																	}" 
																	class="absolute top-0 right-0 mt-2 mr-3" 
																	href="#"
																>
																	<Lucide icon="X" class="w-8 h-8 text-slate-400" />
																</a>
															</Dialog.Title>
															<Dialog.Description class="grid grid-cols-12 gap-4 gap-y-3">
																<div class="col-span-12 sm:col-span-6">
																	<strong>Issued:</strong> {{ formatDate(issuance.issued_on, 'MMMM DD, YYYY') }}<br>
																	<strong>Signed By:</strong> {{ issuance.signator?.name }}<br>
																	<strong>Issued By:</strong> {{ issuance.issuer.name }}<br>
																	<strong>Issued At:</strong> {{ issuance.whereable?.name }}<br>
																	<strong>Reason:</strong> {{ issuance.reason }}
																	<span v-if="issuance.revoked_on">
																		<strong>Revoked By:</strong> {{ issuance.revoker?.name }}<br>
																		<strong>Revoked At:</strong> {{ formatDate(issuance.revoked_on, 'MMMM DD, YYYY') }}<br>
																		<strong>Reason:</strong> {{ issuance.revocation }}
																	</span>
																</div>
																<div class="col-span-12 sm:col-span-6">
																	<div>
																		<img
																			v-if="!issuance.image"
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
											<!-- END: Titles Details Layout -->
										</div>
										<!-- END: Titles List -->
									</div>
								</Tab.Panel>
							</Tab.Panels>
						</div>
					</Tab.Group>
</template>
