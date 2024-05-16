<script setup lang="ts">
	import Button from "@/components/Base/Button";
	import { ref, reactive, toRefs, Ref, computed } from "vue";
	import { showToast } from '@/utils/toast';
	import axios from 'axios';
	import { useStateStore } from '@/stores/state';
	import { useAuthStore } from '@/stores/auth';
	import { Dialog } from "@/components/Base/Headless";
	import { 
		IssuanceSuperSimple,
		Persona,
		TitleSimple,
		Issuance
	} from '@/interfaces';
	import {
		FormInput,
		FormLabel,
	} from "@/components/Base/Form";
	import { useVuelidate } from "@vuelidate/core";
	import Lucide from "@/components/Base/Lucide";
	import Tippy from "@/components/Base/Tippy";
	import { IssuanceRules } from "@/rules";
	import { IssuanceTips } from "@/tips";
	import { debounce } from "lodash";
	import Dropzone from "@/components/Base/Dropzone";
	import Litepicker from "@/components/Base/Litepicker";
	import Multiselect from "vue-multiselect";
	import "vue-multiselect/dist/vue-multiselect.css";
	import { formatDate } from "@/utils/helper";
	
	const auth = useAuthStore()
	const state = useStateStore()
	const props = defineProps<{
		persona: Persona | undefined
		retainer?: Issuance | undefined;
	}>()
	interface RetainersIssuanceEmit {
		(e: "added", value: Issuance): void;
		(e: "updated", value: Issuance): void;
	}
	const emit = defineEmits<RetainersIssuanceEmit>();
	
	const issuanceFormData = reactive<IssuanceSuperSimple>({
		id: props.retainer ? props.retainer.id : 0,
		issuable_type: 'Title',
		issuable_id: props.retainer ? props.retainer.issuable_id : 0,
		whereable_type: props.retainer ? props.retainer.whereable_type : null,
		whereable_id: props.retainer ? props.retainer.whereable_id : null,
		issuer_type: 'Persona',
		issuer_id: props.persona?.id || 0,
		recipient_type: 'Persona',
		recipient_id: props.retainer ? props.retainer.recipient_id : 0,
		signator_id: props.retainer ? props.retainer.signator_id : null,
		custom_name: props.retainer ? props.retainer.custom_name : null,
		rank: props.retainer ? props.retainer.rank : null,
		parent_id: props.retainer ? props.retainer.parent_id : null,
		issued_on: props.retainer ? formatDate(props.retainer.issued_on, "YYYY-MM-DD") : '',
		reason: props.retainer ? props.retainer.reason : null,
		image: props.retainer ? props.retainer.image : '',
		revoked_by: props.retainer ? props.retainer.revoked_by : null,
		revoked_on: props.retainer ? props.retainer.revoked_on : null,
		revocation: props.retainer ? props.retainer.revocation : null
	});
	
	const issueValidate = useVuelidate(IssuanceRules, toRefs(issuanceFormData));

	const issuanceModal = ref(false);
	const setIssueModal = (value: boolean) => {
		issuanceModal.value = value
	}

	const recipientOptions = ref([{
		model: 'Persona',
		options: props.retainer ? [props.retainer.recipient] : [{}]
	}]);
	const recipientLoading = ref(false)
	const recipientModel = ref(props.retainer ? props.retainer.recipient : null)
	const recipientSearch = debounce(async (query: string) => {
		if(query != ''){
			try {
				await axios.post('api/search', { search: query })
				.then(response => {
					const personas = response.data.data['Personas']
					recipientOptions.value[0].options = personas.map((persona: any) => ({
						model: 'Persona',
						name: (persona.chapter?.full_abbreviation ? persona.chapter.full_abbreviation + ': ' : '') + persona.name,
						id: persona.id
					}));
				})
				.catch(error => {
					console.log('Error searching recipients:', error)
					showToast(false, error.response.data.message) 
				});
			} catch (error: any) {
				console.log('Error searching recipients:', error)
				showToast(false, error)
			}
		}
	}, 300);
	const handleRecipientSelectChange = (value:any) => {
		issuanceFormData.recipient_id = value.id
	}
	
	const parentModel = ref(props.retainer ? props.retainer.parent : null)
	const parentTitleSelectOptions = computed(() => {
		const filteredTitles: Issuance[] = [];
		if (props.persona?.titleIssuances && props.persona.titleIssuances.length > 0) {
			filteredTitles.push(
				...props.persona.titleIssuances.filter(title =>
					['Knight', 'Squire', 'Nobility', 'Paragon'].includes((title.issuable as TitleSimple).peerage)
				)
			);
		}
		return filteredTitles;
	});
	const handleParentTitleSelectChange = (value:any) => {
		issuanceFormData.parent_id = value.id
	}
	
	const titleSelectOptions = computed(() => {
		let filteredTitles: TitleSimple[] = [];
		const parentIssuance = props.retainer?.parent ? props.retainer?.parent : props.persona?.titleIssuances?.find(issuance => issuance.id == issuanceFormData.parent_id)
		if (parentIssuance && props.persona?.roptitles && props.persona.roptitles.length > 0) {
			const mapLabels = parentIssuance.issuable.peerage !== 'Paragon' ? ['Page','At-Arms|Man-at-Arms|Woman-at-Arms|Comrade-at-Arms|Sword-at-Arms|Shieldmaiden|Shield Brother'] : ['Apprentice'];
			filteredTitles = props.persona.roptitles.filter(title => mapLabels.includes((title as TitleSimple).name))
		}
		return filteredTitles
	});
	
	const issuableModel = ref(props.retainer ? props.retainer.issuable : null)
	const customNameOptions: Ref<string[]> = ref([])
	const handleTitleSelectChange = (value:any) => {
		issuanceFormData.issuable_id = value.id
		customNameOptions.value = value.name.split("|").map((option:string) => option.trim()) || []
	}
	const addCustomName = (newTag: string) => {
		if (!customNameOptions.value.includes(newTag)) {
			customNameOptions.value.push(newTag);
		}
		issuanceFormData.custom_name = newTag
	};

	const whereableOptions = ref([
		{
			model: 'Events',
			options: props.retainer && props.retainer.whereable_type === 'Event' ? [props.retainer.whereable] : [{}]
		},
		{
			model: 'Locations',
			options: props.retainer && props.retainer.whereable_type === 'Location' ? [props.retainer.whereable] : [{}]
		},
		{
			model: 'Meetups',
			options: props.retainer && props.retainer.whereable_type === 'Meetup' ? [props.retainer.whereable] : [{}]
		}
	]);
	const whereableLoading = ref(false)
	const whereableModel = ref(props.retainer ? props.retainer.whereable : null)
	const whereableSearch = debounce(async (query: string) => {
		try {
			await axios.post('api/search', { search: query })
			.then(response => {
				whereableOptions.value.forEach((whereableOption) => {
					const modelData = response.data.data[whereableOption.model];
					whereableOption.options = modelData.map((entry: any) => ({
						model: whereableOption.model.slice(0, -1),
						name: entry.name,
						id: entry.id
					}));
				});
			})
			.catch(error => {
				console.log('Error searching whereables:', error)
				showToast(false, error.response.data.message) 
			});
		} catch (error: any) {
			console.log('Error searching whereables:', error)
			showToast(false, error)
		}
	}, 300);
	const handleWhereableSelectChange = (value:any) => {
		issuanceFormData.whereable_id = value.id
		issuanceFormData.whereable_type = value.model
	}

	const updateImage = (file: any) => {
		let response = file.xhr ? JSON.parse(file.xhr.response) : null
		if (response && response.success) {
			issuanceFormData.image = response.data
			showToast(true, 'Image uploaded.')
		}else{
			//TODO: add error to issueValidate.image.$error
			state.storeState('error', response.data.message)
			showToast(false, 'Error uploading image: ' + response.data.message)
			console.error('Error uploading image:', response.data.message);
		}
	};
	
	const sendIssuance = async () => {
		issueValidate.value.$touch()
		if (issueValidate.value.$invalid) {
			showToast(false, "Please check the form.")
		} else {
			try {
				let request;
				if (issuanceFormData.id !== 0) {
					request = axios.put(`/api/issuances/${issuanceFormData.id}`, issuanceFormData)
					.then(response => {
						emit("updated", response.data.data)
						showToast(true, response.data.message)
						setIssueModal(false)
					})
				} else {
					request = axios.post(`/api/issuances`, issuanceFormData)
					.then(response => {
						emit("added", response.data.data)
						showToast(true, response.data.message)
						setIssueModal(false)
					})
				}
				request
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
	}
	
	const closeIssuanceRef = ref<HTMLElement | null>(null);

</script>

<template>
	<Button 
		v-if="auth.isLoggedIn && !retainer" 
		variant="primary" 
		class="mr-2 shadow-md"
		@click="(event: MouseEvent) => {
			event.preventDefault();
			setIssueModal(true);
		}"
	>
		Issue New Retainer Title
	</Button>
	<a 
		v-if="auth.isLoggedIn && retainer"
		class="flex items-center mr-3" 
		href="#"
		@click="(event: MouseEvent) => {
			event.preventDefault();
			setIssueModal(true);
		}"
	>
		<Lucide icon="CheckSquare" class="w-4 h-4 mr-1" />
	</a>
	<!-- BEGIN: Issue Modal Content -->
	<Dialog 
		size="xl"
		:open="issuanceModal" 
		@close="() => {
			setIssueModal(false);
		}" 
		:initialFocus="closeIssuanceRef"
	>
		<Dialog.Panel>
			<form class="validate-form" @submit.prevent="sendIssuance">
				<Dialog.Title>
					<h2 class="mr-auto text-base font-medium">
						Issue New Retainer Title
					</h2>
					<a 
						@click="(event: MouseEvent) => {
							event.preventDefault();
							setIssueModal(false);
						}" 
						class="absolute top-0 right-0 mt-2 mr-3" 
						href="#"
					>
						<Lucide icon="X" class="w-8 h-8 text-slate-400" ref="{closeIssuanceRef}" />
					</a>
				</Dialog.Title>
				<Dialog.Description class="grid grid-cols-12 gap-4 gap-y-3">
					<div class="col-span-12 sm:col-span-6">
						<div class="col-span-12 sm:col-span-12 mt-2">
							<FormLabel htmlFor="issuance-form-parent_id">
								Issuing Authority Title 
								<Tippy
									:content="IssuanceTips.parent"
									class="inline-block"
								>
									<Lucide icon="HelpCircle" class="w-4 h-4" />
								</Tippy>
							</FormLabel>
							<FormInput
								id="parent_id"
								v-model.trim="issueValidate.parent_id.$model"
								type="hidden"
								name="parent_id"
							/>
							<Multiselect 
								id="issuance-form-parent"
								v-model.trim="parentModel"
								:options="parentTitleSelectOptions"
								placeholder="Select Title"
								label="name"
								track-by="id"
								@select="handleParentTitleSelectChange"
							/>
							<template v-if="issueValidate.parent_id.$error">
								<div
									v-for="(error, index) in issueValidate.parent_id.$errors"
									:key="index"
									class="mt-2 text-danger"
								>
									{{ error.$message }}
								</div>
							</template>
						</div>
						<div class="col-span-12 sm:col-span-12 mt-2">
							<FormLabel htmlFor="issuance-form-recipient_id"> 
								Recipient
								<Tippy
									:content="IssuanceTips.recipient"
									class="inline-block"
								>
									<Lucide icon="HelpCircle" class="w-4 h-4" />
								</Tippy>
							</FormLabel>
							<FormInput
								id="recipient_id"
								v-model.trim="issueValidate.recipient_id.$model"
								type="hidden"
								name="recipient_id"
							/>
							<Multiselect 
								id="issuance-form-recipient"
								v-model.trim="recipientModel"
								:options="recipientOptions"
								group-values="options" 
								group-label="model"
								placeholder="Search Personas"
								label="name"
								track-by="id"
								:searchable="true"
								:loading="recipientLoading"
								:internal-search="false"
								@select="handleRecipientSelectChange"
								@search-change="recipientSearch"
							/>
							<template v-if="issueValidate.recipient_id.$error">
								<div
									v-for="(error, index) in issueValidate.recipient_id.$errors"
									:key="index"
									class="mt-2 text-danger"
								>
									{{ error.$message }}
								</div>
							</template>
						</div>
						<div class="col-span-12 sm:col-span-12 mt-2">
							<FormLabel htmlFor="issuance-form-issuable_id"> 
								Title 
								<Tippy
									:content="IssuanceTips.issuable_id"
									class="inline-block"
								>
									<Lucide icon="HelpCircle" class="w-4 h-4" />
								</Tippy>
							</FormLabel>
							<FormInput
								id="issuable_id"
								v-model.trim="issueValidate.issuable_id.$model"
								type="hidden"
								name="issuable_id"
							/>
							<Multiselect 
								id="issuance-form-issuable"
								v-model.trim="issuableModel"
								:options="titleSelectOptions"
								placeholder="Select Title"
								label="name"
								track-by="id"
								:searchable="true"
								:loading="recipientLoading"
								:internal-search="false"
								@select="handleTitleSelectChange"
							/>
							<template v-if="issueValidate.issuable_id.$error">
								<div
									v-for="(error, index) in issueValidate.issuable_id.$errors"
									:key="index"
									class="mt-2 text-danger"
								>
									{{ error.$message }}
								</div>
							</template>
						</div>
						<div class="col-span-12 sm:col-span-12 mt-2">
							<FormLabel htmlFor="issuance-form-custom_name">
								Custom Name 
								<Tippy
									:content="IssuanceTips.custom_name"
									class="inline-block"
								>
									<Lucide icon="HelpCircle" class="w-4 h-4" />
								</Tippy>
							</FormLabel>
							<Multiselect 
								id="issuance-form-custom_name"
								v-model.trim="issueValidate.custom_name.$model"
								:options="customNameOptions"
								:taggable="true"
								@tag="addCustomName"
								placeholder="Pick or add a name"
								tag-placeholder="Use this name" 
							/>
							<template v-if="issueValidate.custom_name.$error">
								<div
									v-for="(error, index) in issueValidate.custom_name.$errors"
									:key="index"
									class="mt-2 text-danger"
								>
									{{ error.$message }}
								</div>
							</template>
						</div>
						<div class="col-span-12 sm:col-span-12 mt-2">
							<FormLabel htmlFor="issuance-form-reason">
								Reason 
								<Tippy
									:content="IssuanceTips.reason"
									class="inline-block"
								>
									<Lucide icon="HelpCircle" class="w-4 h-4" />
								</Tippy>
							</FormLabel>
							<FormInput id="issuance-form-reason" v-model.trim="issueValidate.reason.$model" type="text" placeholder="That awesome thing they did" />
							<template v-if="issueValidate.reason.$error">
								<div
									v-for="(error, index) in issueValidate.reason.$errors"
									:key="index"
									class="mt-2 text-danger"
								>
									{{ error.$message }}
								</div>
							</template>
						</div>
					</div>
					<div class="col-span-12 sm:col-span-6">
						<div class="col-span-12 sm:col-span-12 mt-2">
							<FormLabel htmlFor="issuance-form-whereable_id"> 
								Issued At 
								<Tippy
									:content="IssuanceTips.whereable_id"
									class="inline-block"
								>
									<Lucide icon="HelpCircle" class="w-4 h-4" />
								</Tippy>
							</FormLabel>
							<FormInput
								id="whereable_type"
								v-model.trim="issueValidate.whereable_type.$model"
								type="hidden"
								name="whereable_type"
							/>
							<FormInput
								id="whereable_id"
								v-model.trim="issueValidate.whereable_id.$model"
								type="hidden"
								name="whereable_id"
							/>
							<Multiselect 
								id="issuance-form-whereable"
								v-model.trim="whereableModel"
								:options="whereableOptions"
								group-values="options" 
								group-label="model"
								placeholder="Event, Meetup, or Location"
								label="name"
								track-by="id"
								:searchable="true"
								:loading="whereableLoading"
								:internal-search="false"
								@search-change="whereableSearch"
								@select="handleWhereableSelectChange"
							/>
							<template v-if="issueValidate.whereable_id.$error">
								<div
									v-for="(error, index) in issueValidate.whereable_id.$errors"
									:key="index"
									class="mt-2 text-danger"
								>
									{{ error.$message }}
								</div>
							</template>
						</div>
						<div class="col-span-12 sm:col-span-12 mt-2">
							<FormLabel htmlFor="issuance-form-issued_on">
								Issued On
								<Tippy
									:content="IssuanceTips.issued_on"
									class="inline-block"
								>
									<Lucide icon="HelpCircle" class="w-4 h-4" />
								</Tippy>
							</FormLabel>
							<Litepicker 
								id="issuance-form-issued_on" 
								v-model.trim="issueValidate.issued_on.$model"
								:options="{
									format: 'YYYY-MM-DD',
									autoApply: false,
									showWeekNumbers: true,
									dropdowns: {
										minYear: 1983,
										maxYear: new Date().getFullYear() + 1,
										months: true,
										years: true,
									},
								}" 
							/>
							<template v-if="issueValidate.issued_on.$error">
								<div
									v-for="(error, index) in issueValidate.issued_on.$errors"
									:key="index"
									class="mt-2 text-danger"
								>
									{{ error.$message }}
								</div>
							</template>
						</div>
						<div v-if="props.retainer" class="col-span-12 sm:col-span-12 mt-2">
							<FormLabel htmlFor="issuance-form-image"> 
								Image
								<Tippy
									:content="IssuanceTips.image"
									class="inline-block"
								>
									<Lucide icon="HelpCircle" class="w-4 h-4" />
								</Tippy>
							</FormLabel>
							<Dropzone 
								refKey="dropzoneImageRef" 
								:options="{
									url: 'http://orga.localhost/api/image',
									thumbnailWidth: 150,
									maxFilesize: 1,
									maxFiles: 1,
									params: () => ({
										context: 'issuance',
										target: props.retainer?.id
									}),
									headers: { 
										Authorization: `Bearer ${auth.token}`
									}
								}"
								@completed="updateImage"
								class="dropzone"
							>
								<div class="text-lg font-medium">
									drop or click
								</div>
							</Dropzone>
							<template v-if="issueValidate.image.$error">
								<div
									v-for="(error, index) in issueValidate.image.$errors"
									:key="index"
									class="mt-2 text-danger"
								>
									{{ error.$message }}
								</div>
							</template>
						</div>
						<div v-else class="col-span-12 sm:col-span-12 mt-2">
							<FormLabel htmlFor="issuance-form-image"> 
								Image
								<Tippy
									:content="IssuanceTips.image"
									class="inline-block"
								>
									<Lucide icon="HelpCircle" class="w-4 h-4" />
								</Tippy>
							</FormLabel>
							<div>Save and edit to upload an image of the belt, favor, or other physrep.</div>
						</div>
					</div>
				</Dialog.Description>
				<Dialog.Footer>
					<Button 
						type="button" 
						variant="outline-secondary" 
						@click="() => {
							setIssueModal(false);
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
	<!-- END: Issue Modal Content -->
</template>