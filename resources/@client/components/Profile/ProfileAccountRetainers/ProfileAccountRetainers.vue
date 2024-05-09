<script setup lang="ts">
	import { Persona, PersonaSimple, PersonaSuperSimple, PronounSuperSimple } from "@/interfaces";
	import _ from "lodash";
	import { ref, onMounted, reactive, toRefs } from "vue";
	import Lucide from "@/components/Base/Lucide";
	import { useStateStore } from '@/stores/state';
	import axios from 'axios';
	import { useVuelidate } from "@vuelidate/core";
	import { PersonaRules } from "@/rules";
	import { showToast } from "@/utils/toast";
	import Loader from "@/components/Base/Loader";
	import { Dialog } from "@/components/Base/Headless";
	import { formatDate } from "@/utils/helper";

	const state = useStateStore()
	const props = defineProps<{
		persona: Persona | undefined
	}>()
	const pronouns = ref<PronounSuperSimple[]>([]);
	const isLoading = ref<boolean>(false)
	const loadingMessage = ref<string>('')
	
	const personaFormData = reactive<PersonaSuperSimple>({
		id: props.persona?.id || 0,
		chapter_id: props.persona?.chapter_id || 0,
		name: props.persona?.name || '',
		mundane: props.persona?.mundane || '',
		slug: props.persona?.slug || '',
		pronoun_id: props.persona?.pronoun_id || 0,
		honorific_id: props.persona?.honorific_id || 0,
		heraldry: props.persona?.heraldry || '',
		image: props.persona?.image || '',
		is_active: props.persona?.is_active || 1,
		reeve_qualified_expires_at: props.persona?.reeve_qualified_expires_at || '',
		corpora_qualified_expires_at: props.persona?.corpora_qualified_expires_at || '',
		joined_chapter_at: props.persona?.joined_chapter_at || ''
	});
	
	const validate = useVuelidate(PersonaRules, toRefs(personaFormData));
	
	onMounted(async () => {
		try {
			await axios.get('/api/pronouns')
				.then(response => {
					pronouns.value = response.data.data
				})
				.catch(error => {
					state.storeState('error', error)
					showToast(false, 'Error fetching pronouns: ' + error)
					console.log('Error fetching pronouns:', error);
				})
		} catch (error) {
			state.storeState('error', 'Error fetching pronouns: ' + error)
			showToast(false, 'Error fetching pronouns: ' + error)
			console.error('Error fetching pronouns:', error);
		}
	});

	const saveAccount = async () => {
		isLoading.value = true
		loadingMessage.value = 'Saving...'
		validate.value.$touch();
		if (validate.value.$invalid) {
			showToast(false, "Please check the form.")
		} else {
			try {
				await axios.put('/api/personas/' + props.persona?.id, personaFormData)
					.then(response => {
						isLoading.value = false
						loadingMessage.value = ''
						showToast(true, response.data.message)
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
	
	const retainerModal = ref<number | boolean>(false)
	const setRetainerModal = (value: number | boolean) => {
		retainerModal.value = value;
	}
	
	const deleteConfirmationModal = ref(false)
	const setDeleteConfirmationModal = (value: boolean) => {
		deleteConfirmationModal.value = value
	};
</script>
<template>
	<div class="col-span-12 lg:col-span-8 2xl:col-span-9">
		<div class="intro-y box lg:mt-5">
			<div
				class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400"
			>
				<h2 class="mr-auto text-base font-medium">Retainers</h2>
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
						<div class="w-60 grid grid-cols-12 gap-6 mt-5">
							<div
								v-for="(retainer, index) in persona?.retainers"
								:key="index"
								class="w-60 col-span-12 intro-y md:col-span-6 lg:col-span-4 xl:col-span-4"
							>
								<div class="box" :class="{ 'bg-danger/20': retainer.revoked_at }">
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
													{{ formatDate(retainer.issued_at, 'MMMM DD, YYYY') }}
												</span>
											</div>
										</div>
										<div class="mt-5 text-slate-600 dark:text-slate-500">
											<div v-if="retainer.reason" class="flex items-center mt-2">
												Guardian: {{ retainer.reason }}
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
										<a class="flex items-center mr-3" href="#">
											<Lucide icon="CheckSquare" class="w-4 h-4 mr-1" />
										</a>
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
												Edit Content
											</div>
											<div class="col-span-12 sm:col-span-6">
												More editing?
											</div>
										</Dialog.Description>
									</Dialog.Panel>
								</Dialog>
								<!-- END: Modal Content -->
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