<script setup lang="ts">
	import { Persona, PersonaSuperSimple, PronounSuperSimple, RealmSimple } from "@/interfaces";
	import _ from "lodash";
	import { ref, onMounted, reactive, toRefs } from "vue";
	import Lucide from "@/components/Base/Lucide";
	import { useAuthStore } from '@/stores/auth';
	import { useStateStore } from '@/stores/state';
	import axios from 'axios';
	import { useVuelidate } from "@vuelidate/core";
	import { PersonaRules } from "@/rules";
	import { showToast } from "@/utils/toast";
	import Loader from "@/components/Base/Loader";
	import { Dialog } from "@/components/Base/Headless";
	import { formatDate } from "@/utils/helper";
	import FileIcon from "@/components/Base/FileIcon";

	const auth = useAuthStore()
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
		validate.value.$touch();
		if (validate.value.$invalid) {
			showToast(false, "Please check the form.")
		} else {
			isLoading.value = true
			loadingMessage.value = 'Saving...'
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

	function isPDF(fileName: string | undefined) {
		if (!fileName) return false;
		const extension = fileName.split('.').pop()?.toLowerCase();
		return extension === 'pdf';
	}

	function isImage(fileName: string | undefined) {
		if (!fileName) return false;
		const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
		const extension = fileName.split('.').pop()?.toLowerCase();
		return extension ? imageExtensions.includes(extension) : false;
	}
	
	const waiverModal = ref<number | boolean>(false)
	const setWaiverModal = (value: number | boolean) => {
		waiverModal.value = value;
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
				<h2 class="mr-auto text-base font-medium">Waivers</h2>
			</div>
			<div class="p-5">
				<div class="flex flex-col xl:flex-row">
					<Loader 
						:active="isLoading"
						:message="loadingMessage"
					/>
					<!-- BEGIN: Waivers List -->
					<div class="mr-5 col-span-12 overflow-auto intro-y lg:overflow-visible">
						<!-- BEGIN: Waivers Details Layout -->
						<div class="w-60 grid grid-cols-12 gap-6 mt-5">
							<div
								v-for="(waiver, index) in persona?.waivers"
								:key="index"
								class="w-60 col-span-12 intro-y md:col-span-6 lg:col-span-4 xl:col-span-4"
							>
								<div class="box" :class="{ 'bg-danger/20': waiver?.expires_at && waiver.expires_at < new Date().toISOString().split('T')[0] }">
									<div class="p-5">
										<div
											class="h-40 overflow-hidden rounded-md 2xl:h-56 image-fit before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10"
										>
											<img
												v-if="isImage(waiver.file)"
												:alt="waiver.player"
												class="rounded-md"
												:src="waiver.file"
											/>
											<FileIcon
												v-else
												class="w-3/5 mx-auto"
												variant="pdf"
												type="PDF"
											/>
											<div class="absolute bottom-0 z-10 px-5 pb-6 text-white">
												<a :href="waiver.waiverable_type.toLowerCase() + 's/' + waiver.waiverable.id" class="block text-base font-medium">
													{{ waiver.waiverable.name }}
													<span>{{ waiver.player }} <span v-if="waiver.pronoun">({{ waiver.pronoun.subject }}/{{ waiver.pronoun.object }})</span></span>
												</a>
												<span class="mt-3 text-xs text-white/90">
													{{ formatDate(waiver.signed_at, 'MMMM DD, YYYY') }}
												</span>
											</div>
										</div>
										<div class="mt-5 text-slate-600 dark:text-slate-500">
											<div v-if="(waiver.waiverable as RealmSimple).waiver_duration !== undefined && waiver.expires_at" class="flex items-center mt-2">
												Expires: {{ formatDate(waiver.expires_at, 'MMMM DD, YYYY') }}
											</div>
											<div v-if="waiver.guardian" class="flex items-center mt-2">
												Guardian: {{ waiver.guardian }}
											</div>
										</div>
									</div>
									<div
										v-if="waiver.can_update" 
										class="flex items-center justify-center p-5 border-t lg:justify-end border-slate-200/60 dark:border-darkmode-400"
									>
										<a class="flex items-center mr-auto text-primary" href="#" @click="(event: MouseEvent) => {
											event.preventDefault();
											setWaiverModal(waiver.id);
										}">
											<Lucide icon="Eye" class="w-4 h-4 mr-1" />
										</a>
										<a class="flex items-center mr-3" href="#">
											<Lucide icon="CheckSquare" class="w-4 h-4 mr-1" />
										</a>
										<a
											v-if="waiver.can_delete"
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
									v-if="waiver.can_update"
									size="xl"
									:open="waiverModal === waiver.id" 
									@close="() => {
										setWaiverModal(false);
									}"
									class="relative z-50"
								>
									<Dialog.Panel>
										<Dialog.Title>
											<h2 class="mr-auto text-base font-medium">
												{{ waiver.player }} - {{ waiver.waiverable.name }}
											</h2>
											<a 
												@click="(event: MouseEvent) => {
													event.preventDefault();
													setWaiverModal(false);
												}" 
												class="absolute top-0 right-0 mt-2 mr-3" 
												href="#"
											>
												<Lucide icon="X" class="w-8 h-8 text-slate-400" />
											</a>
										</Dialog.Title>
										<Dialog.Description class="grid grid-cols-12 gap-4 gap-y-3">
											<div class="col-span-12 sm:col-span-6">
												<strong>For:</strong> {{ waiver.waiverable.name }}<br>
												<strong>Player Name:</strong> {{ waiver.player }}<br>
												<span v-if="waiver.persona">
													<strong>Persona:</strong> {{ waiver.persona.name }}<br>
												</span>
												<span v-if="waiver.pronoun">
													<strong>Pronouns:</strong> {{ waiver.pronoun.subject }}/{{ waiver.pronoun.object }}
												</span>
												<span v-if="waiver.guardian">
													<strong>Guardian:</strong> {{ waiver.guardian }}<br>
												</span>
												<span v-if="waiver.age_verified_at">
													<strong>Age Verified At:</strong> {{ formatDate(waiver.age_verified_at, 'MMMM DD, YYYY') }}<br>
													<strong>Age Verified By:</strong> {{ waiver.ageVerifiedBy?.name }}<br>
												</span>
												<span v-if="waiver.email">
													<strong>Email:</strong> {{ waiver.email }}<br>
												</span>
												<span v-if="waiver.phone">
													<strong>Phone:</strong> {{ waiver.phone }}<br>
												</span>
												<span v-if="waiver.dob">
													<strong>Date of Birth:</strong> {{ formatDate(waiver.dob, 'MMMM DD, YYYY') }}<br>
												</span>
												<span v-if="waiver.location">
													<span v-if="waiver.location.address"><strong>Address:</strong> {{waiver.location.address}}</span>
													<span v-if="waiver.location.city"><strong>City:</strong> {{waiver.location.city}}</span>
													<span v-if="waiver.location.province"><strong>State:</strong> {{waiver.location.province}}</span>
													<span v-if="waiver.location.postal_code"><strong>Postal Code:</strong> {{waiver.location.postal_code}}</span>
													<span v-if="waiver.location.country"><strong>Country:</strong> {{waiver.location.country}}</span>
												</span>
												<span v-if="waiver.emergency_name">
													<strong>Emergency Contact:</strong> {{ waiver.emergency_name }}<br>
												</span>
												<span v-if="waiver.emergency_relationship">
													<strong>Emergency Relationship:</strong> {{ waiver.emergency_relationship }}<br>
												</span>
												<span v-if="waiver.emergency_phone">
													<strong>Emergency Phone:</strong> {{ waiver.emergency_phone }}<br>
												</span>
												<strong>Signed At:</strong> {{ formatDate(waiver.signed_at, 'MMMM DD, YYYY') }}<br>
												<span v-if="waiver.expires_at">
													<strong>Expires At:</strong> {{ formatDate(waiver.expires_at, 'MMMM DD, YYYY') }}<br>
												</span>
											</div>
											<div class="col-span-12 sm:col-span-6">
												<div>
													<img
														v-if="isImage(waiver.file) && !waiver.file.includes('000000.jpg')"
														:alt="waiver.player"
														class="rounded-md"
														:src="waiver.file"
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
						<!-- END: Waivers Details Layout -->
					</div>
					<!-- END: Waivers List -->
				</div>
			</div>
		</div>
	</div>
</template>