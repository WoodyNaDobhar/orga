<script setup lang="ts">
	import { Issuance, Persona, PersonaSimple } from "@/interfaces";
	import _ from "lodash";
	import { ref } from "vue";
	import Lucide from "@/components/Base/Lucide";
	import { useStateStore } from '@/stores/state';
	import axios from 'axios';
	import { showToast } from "@/utils/toast";
	import Loader from "@/components/Base/Loader";
	import { Dialog } from "@/components/Base/Headless";
	import { formatDate } from "@/utils/helper";
	import IssuanceButton from "../IssuanceButton/IssuanceButton.vue";
	import Button from "@/components/Base/Button";

	const state = useStateStore()
	const props = defineProps<{
		persona: Persona | undefined
	}>()
	const isLoading = ref<boolean>(false)
	const loadingMessage = ref<string>('')

	interface RetainersPersonaEmit {
		(e: "updated", value: Persona): void;
	}
	const emit = defineEmits<RetainersPersonaEmit>();
	
	const issuanceModal = ref(false);
	const setIssueModal = (value: boolean) => {
		issuanceModal.value = value;
	}
	
	const retainerModal = ref<number | boolean>(false)
	const setRetainerModal = (value: number | boolean) => {
		retainerModal.value = value;
	}

	const addRetainer = (newRetainer: Issuance) => {
		if (props.persona) {
			if (!props.persona.retainers) {
				props.persona.retainers = [newRetainer]
			} else {
				props.persona.retainers.push(newRetainer)
			}
			emit("updated", props.persona)
		}
	}

	const updateRetainer = (retainer: Issuance) => {
		if (props.persona && props.persona.retainers) {
			const index = props.persona.retainers.findIndex(r => r.id === retainer.id);
			if (index !== -1) {
				props.persona.retainers[index] = retainer
				emit("updated", props.persona)
			}
		}
	}

	const deleteRetainer = (retainer: Issuance) => {
		try {
			axios.delete(`/api/issuances/${retainer.id}`)
				.then(response => {
					if (props.persona && props.persona.retainers) {
						const index = props.persona.retainers.findIndex(r => r.id === retainer.id)
						if (index !== -1) {
							props.persona.retainers.splice(index, 1)
						}
						showToast(true, response.data.message)
						setIssueModal(false)
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
	}
	
	const deleteButtonRef = ref(null);
	const deleteConfirmationModal = ref(false)
	const setDeleteConfirmationModal = (value: boolean) => {
		deleteConfirmationModal.value = value
	}
</script>
<template>
	<div class="col-span-12 lg:col-span-8 2xl:col-span-9">
		<div class="intro-y box lg:mt-5">
			<div
				class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400"
			>
				<h2 class="mr-auto text-base font-medium">Retainers</h2>
				<IssuanceButton :persona="persona" @added="addRetainer" />
			</div>
			<div class="p-5">
				<div class="flex flex-col xl:flex-row">
					<Loader 
						:active="isLoading"
						:message="loadingMessage"
					/>
					<!-- BEGIN: Retainers List -->
					<div class="mr-5 col-span-12 overflow-auto intro-y lg:overflow-visible">
						<!-- BEGIN: Retainers Details Layout -->
						<div class="grid grid-cols-12 gap-6 mt-5">
							<div
								v-for="(retainer, index) in persona?.retainers"
								:key="index"
								class="w-60 col-span-12 intro-y md:col-span-6 lg:col-span-4 xl:col-span-3"
							>
								<div class="box" :class="{ 'bg-danger/20': retainer.revoked_on }">
									<div class="p-5">
										<div
											class="h-40 overflow-hidden rounded-md 2xl:h-56 image-fit before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10"
										>
											<img
												:alt="retainer.recipient.name"
												class="rounded-md"
												:src="(retainer.recipient as PersonaSimple).image"
											/>
											<div class="absolute bottom-0 z-10 px-5 pb-6 text-white">
												<div class="block text-base font-medium">
													{{ retainer.name }} {{ retainer.recipient.name }}
												</div>
												<span class="mt-3 text-xs text-white/90">
													Since {{ formatDate(retainer.issued_on, 'MMMM DD, YYYY') }}
												</span>
											</div>
										</div>
										<div class="mt-5 text-slate-600 dark:text-slate-500">
											<div v-if="retainer.parent_id" class="flex items-center mt-2">
												Succession: {{ retainer.parent.name }}
											</div>
											<div v-if="retainer.reason" class="flex items-center mt-2">
												Reason: {{ retainer.reason }}
											</div>
										</div>
									</div>
									<div
										v-if="retainer.can_update" 
										class="flex items-center justify-center p-5 border-t lg:justify-end border-slate-200/60 dark:border-darkmode-400"
									>
										<a class="flex items-center mr-auto text-primary" href="#" @click="(event: MouseEvent) => {
											event.preventDefault();
											setRetainerModal(retainer.id);
										}">
											<Lucide icon="Eye" class="w-4 h-4 mr-1" />
										</a>
										<IssuanceButton :persona="persona" :retainer="retainer" @updated="updateRetainer" />
										<a
											v-if="retainer.can_delete"
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
									v-if="retainer.can_update"
									size="xl"
									:open="retainerModal === retainer.id" 
									@close="() => {
										setRetainerModal(false);
									}"
									class="relative z-50"
								>
									<Dialog.Panel>
										<Dialog.Title>
											<h2 class="mr-auto text-base font-medium">
												{{ retainer.name }} {{ retainer.recipient.name }}
											</h2>
											<a 
												@click="(event: MouseEvent) => {
													event.preventDefault();
													setRetainerModal(false);
												}" 
												class="absolute top-0 right-0 mt-2 mr-3" 
												href="#"
											>
												<Lucide icon="X" class="w-8 h-8 text-slate-400" />
											</a>
										</Dialog.Title>
										<Dialog.Description class="grid grid-cols-12 gap-4 gap-y-3">
											<div class="col-span-12 sm:col-span-6">
												<strong>Issued:</strong> {{ formatDate(retainer.issued_on, 'MMMM DD, YYYY') }}<br>
												<strong>Issued By:</strong> {{ retainer.issuer.name }}<br>
												<strong>Succession:</strong> {{ retainer.parent.name }}<br>
												<strong>Issued At:</strong> {{ retainer.whereable?.name }}<br>
												<strong>Reason:</strong> {{ retainer.reason }}
												<span v-if="retainer.revoked_on">
													<strong>Revoked By:</strong> {{ retainer.revoker?.name }}<br>
													<strong>Revoked At:</strong> {{ formatDate(retainer.revoked_on, 'MMMM DD, YYYY') }}<br>
													<strong>Reason:</strong> {{ retainer.revocation }}
												</span>
											</div>
											<div class="col-span-12 sm:col-span-6">
												<div>
													<img
														v-if="!retainer.image"
														:alt="retainer.name"
														class="rounded-md"
														:src="retainer.image"
														style="width: 100%;"
													/>
												</div>
											</div>
										</Dialog.Description>
									</Dialog.Panel>
								</Dialog>
								<!-- END: Modal Content -->
								<!-- BEGIN: Delete Confirmation Modal -->
								<Dialog
									:open="deleteConfirmationModal"
									@close="() => {
										setDeleteConfirmationModal(false);
									}"
									:initialFocus="deleteButtonRef"
								>
									<Dialog.Panel>
									<div class="p-5 text-center">
										<Lucide icon="XCircle" class="w-16 h-16 mx-auto mt-3 text-danger" />
										<div class="mt-5 text-3xl">Are you sure?</div>
										<div class="mt-2 text-slate-500">
											Do you really want to delete these records? <br />
											This process cannot be undone.
										</div>
									</div>
									<div class="px-5 pb-8 text-center">
										<Button
											variant="outline-secondary"
											type="button"
											@click="() => {
												setDeleteConfirmationModal(false);
											}"
											class="w-24 mr-1"
										>
											Cancel
										</Button>
										<Button
											variant="danger"
											type="button"
											class="w-24"
											ref="deleteButtonRef"
											@click="(event: MouseEvent) => {
												event.preventDefault()
												deleteRetainer(retainer)
											}"
										>
										Delete
										</Button>
									</div>
									</Dialog.Panel>
								</Dialog>
								<!-- END: Delete Confirmation Modal -->
							</div>
						</div>
						<!-- END: Retainers Details Layout -->
					</div>
					<!-- END: Retainers List -->
				</div>
			</div>
		</div>
	</div>
</template>