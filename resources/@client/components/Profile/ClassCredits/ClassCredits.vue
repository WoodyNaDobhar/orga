<script setup lang="ts">
	import { ref, VNodeRef } from "vue";
	import { Menu, Tab } from "@/components/Base/Headless";
	import { Tab as HeadlessTab } from "@headlessui/vue";
	import { ArchetypeSimple, Persona } from "@/interfaces";
	import Progress from "@/components/Base/Progress";
	import Lucide from "@/components/Base/Lucide";
	import { Layout } from 'grid-layout-plus'
	
	const props = defineProps<{
		archetypes: ArchetypeSimple[] | undefined,
		persona: Persona | undefined,
		layout: Layout | undefined
	}>()
	const content = ref<VNodeRef|null>(null);
</script>

<template>
					<Tab.Group class="col-span-12 intro-y box lg:col-span-6" style="height: 100%; overflow-y: scroll;">
						<div
							:ref="content"
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
										v-for="(archetype) in archetypes?.sort((a, b) => a.name.localeCompare(b.name))"
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
										v-for="(archetype) in archetypes?.sort((a, b) => {
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
								</Tab.Panel>
							</Tab.Panels>
						</div>
					</Tab.Group>
</template>
