<script setup lang="ts">
	import Button from "@/components/Base/Button";
	import { ref, reactive, toRefs, onMounted } from "vue";
	import { showToast } from '@/utils/toast';
	import axios from 'axios';
	import { useStateStore } from '@/stores/state';
	import { useAuthStore } from '@/stores/auth';
	import { Dialog } from "@/components/Base/Headless";
	import { 
		Persona,
		Due,
		DueSuperSimple,
		DueFormData
	} from '@/interfaces';
	import {
		FormInput,
		FormLabel,
		InputGroup
	} from "@/components/Base/Form";
	import { useVuelidate } from "@vuelidate/core";
	import Lucide from "@/components/Base/Lucide";
	import Tippy from "@/components/Base/Tippy";
	import { DueRules } from "@/rules";
	import { DueTips, TransactionTips } from "@/tips";
	import { debounce } from "lodash";
	import Litepicker from "@/components/Base/Litepicker";
	import Multiselect from "vue-multiselect";
	import "vue-multiselect/dist/vue-multiselect.css";
	import { formatDate } from "@/utils/helper";
	
	const auth = useAuthStore()
	const state = useStateStore()
	const props = defineProps<{
		persona: Persona | undefined
		due?: Due | undefined
		label?: string | undefined
	}>()
	interface DuesEmit {
		(e: "added", value: Due): void;
		(e: "updated", value: Due): void;
	}
	const emit = defineEmits<DuesEmit>();
	
	const dueFormData = reactive<DueFormData>({
		id: props.due ? props.due.id : 0,
		persona_id: props.persona ? props.persona.id : 0,
		recipient_type: props.due ? props.due.transaction.splits[0].account.accountable_type : 'Chapter',
		recipient_id: props.due ? props.due.transaction.splits[0].account.accountable_id : (props.persona ? props.persona.chapter_id : null),
		dues_on: props.due ? formatDate(props.due.dues_on, "MMMM DD, YYYY") : '',
		amount: props.due ? props.due.amount : null,
		type: props.due ? (props.due.transaction.splits.find(split => split.account.type === 'Asset')?.account.name || 'Cash') : 'Cash',
		memo: props.due ? props.due.memo : null
	});
	
	const dueValidate = useVuelidate(DueRules, toRefs(dueFormData));

	const dueModal = ref(false);
	const setDueModal = (value: boolean) => {
		dueModal.value = value
	}

	const personaOptions = ref([{
		model: 'Persona',
		options: props.persona ? [props.persona] : [{}]
	}]);
	const personaLoading = ref(false)
	const personaModel = ref(props.persona ? props.persona : null)
	const personaSearch = debounce(async (query: string) => {
		if(query != ''){
			try {
				await axios.post('api/search', { search: query })
				.then(response => {
					const personas = response.data.data['Personas']
					personaOptions.value[0].options = personas.map((persona: any) => ({
						model: 'Persona',
						name: (persona.chapter?.full_abbreviation ? persona.chapter.full_abbreviation + ': ' : '') + persona.name,
						id: persona.id
					}));
				})
				.catch(error => {
					console.log('Error searching personas:', error)
					showToast(false, error.response.data.message) 
				});
			} catch (error: any) {
				console.log('Error searching personas:', error)
				showToast(false, error)
			}
		}
	}, 300);
	const handlePayerSelectChange = (value:any) => {
		dueFormData.persona_id = value.id
	}

	const recipientOptions = ref([
		{
			model: 'Chapters',
			options: props.persona ? [props.persona.chapter] : [{}]
		},
		{
			model: 'Realms',
			options: props.persona && props.persona.chapter ? [props.persona.chapter.realm] : [{}]
		}
	])
	const recipientLoading = ref(false)
	const recipientModel = ref(props.persona ? props.persona.chapter : null)
	const recipientSearch = debounce(async (query: string) => {
		if(query != ''){
			try {
				await axios.post('api/search', { search: query })
				.then(response => {
					const chapters = response.data.data['Chapters']
					const realms = response.data.data['Realms']
					recipientOptions.value.forEach((recipientOption) => {
						const modelData = response.data.data[recipientOption.model];
						recipientOption.options = modelData.map((entry: any) => ({
							model: recipientOption.model.slice(0, -1),
							name: entry.name,
							id: entry.id
						}));
					});
					console.log(recipientOptions)
				})
				.catch(error => {
					console.log('Error searching personas:', error)
					showToast(false, error.response.data.message) 
				});
			} catch (error: any) {
				console.log('Error searching personas:', error)
				showToast(false, error)
			}
		}
	}, 300);
	const handleRecipientSelectChange = (value:any) => {
		dueFormData.recipient_type = value.model
		dueFormData.recipient_id = value.id
	}

	const assetTypeSelectOptions = ['Assets','Cash','Checking'];

	onMounted(() => {
		if (props.due) {
			console.log(props.due)
			dueFormData.recipient_type = props.due.transaction.splits[0].account.accountable_type
			dueFormData.recipient_id = props.due.transaction.splits[0].account.accountable_id
			console.log(dueFormData)
		}
	});
	
	const sendDue = async () => {
		dueValidate.value.$touch()
		if (dueValidate.value.$invalid) {
			showToast(false, "Please check the form.")
		} else {
			try {
				let request;
				if (dueFormData.id !== 0) {
					request = axios.put(`/api/dues/${dueFormData.id}`, dueFormData)
					.then(response => {
						emit("updated", response.data.data)
						showToast(true, response.data.message)
						setDueModal(false)
					})
				} else {
					request = axios.post(`/api/dues`, dueFormData)
					.then(response => {
						emit("added", response.data.data)
						showToast(true, response.data.message)
						setDueModal(false)
					})
				}
				request
					.catch(error => {
						state.storeState('error', error.response.data.message)
						console.log('Error posting due:', error)
						showToast(false, error.response.data.message) 
					});
			} catch (error: any) {
				state.storeState('error', error)
				console.log('Error posting due:', error)
				showToast(false, error)
			}
		}
	}
	
	const closeDueRef = ref<HTMLElement | null>(null);
</script>

<template>
	<Button 
		v-if="auth.isLoggedIn && !due" 
		variant="primary" 
		class="mr-2 shadow-md"
		@click="(event: MouseEvent) => {
			event.preventDefault();
			setDueModal(true);
		}"
	>
		Record New Dues Payment
	</Button>
	<a 
		v-if="auth.isLoggedIn && due"
		class="flex items-center mr-3" 
		href="#"
		@click="(event: MouseEvent) => {
			event.preventDefault();
			setDueModal(true);
		}"
	>
		<Lucide icon="CheckSquare" class="w-4 h-4 mr-1" /> {{ label }}
	</a>
	<!-- BEGIN: Due Modal Content -->
	<Dialog 
		:open="dueModal" 
		@close="() => {
			setDueModal(false);
		}" 
		:initialFocus="closeDueRef"
	>
		<Dialog.Panel>
			<form class="validate-form" @submit.prevent="sendDue">
				<Dialog.Title>
					<h2 class="mr-auto text-base font-medium">
						Dues Payment
					</h2>
					<a 
						@click="(event: MouseEvent) => {
							event.preventDefault();
							setDueModal(false);
						}" 
						class="absolute top-0 right-0 mt-2 mr-3" 
						href="#"
					>
						<Lucide icon="X" class="w-8 h-8 text-slate-400" ref="{closeDueRef}" />
					</a>
				</Dialog.Title>
				<Dialog.Description class="grid grid-cols-12 gap-4 gap-y-3">
					<div class="col-span-12">
						<div v-if="dueFormData.persona_id !== auth.getUser.persona.id" class="col-span-12 sm:col-span-12 mt-2">
							<FormLabel htmlFor="due-form-persona_id"> 
								Payed By
								<Tippy
									:content="DueTips.persona_id"
									class="inline-block"
								>
									<Lucide icon="HelpCircle" class="w-4 h-4" />
								</Tippy>
							</FormLabel>
							<FormInput
								id="persona_id"
								v-model.trim="dueValidate.persona_id.$model"
								type="hidden"
								name="persona_id"
							/>
							<Multiselect 
								id="due-form-persona"
								v-model.trim="personaModel"
								:options="personaOptions"
								group-values="options" 
								group-label="model"
								placeholder="Search Personas"
								label="name"
								track-by="id"
								:searchable="true"
								:loading="personaLoading"
								:internal-search="false"
								@select="handlePayerSelectChange"
								@search-change="personaSearch"
							/>
							<template v-if="dueValidate.persona_id.$error">
								<div
									v-for="(error, index) in dueValidate.persona_id.$errors"
									:key="index"
									class="mt-2 text-danger"
								>
									{{ error.$message }}
								</div>
							</template>
						</div>
						<div class="col-span-12 sm:col-span-12 mt-2">
							<FormLabel htmlFor="due-form-persona_id"> 
								Payed To
								<Tippy
									:content="DueTips.persona_id"
									class="inline-block"
								>
									<Lucide icon="HelpCircle" class="w-4 h-4" />
								</Tippy>
							</FormLabel>
							<FormInput
								id="recipient_type"
								v-model.trim="dueValidate.recipient_type.$model"
								type="hidden"
								name="recipient_type"
							/>
							<FormInput
								id="recipient_id"
								v-model.trim="dueValidate.recipient_id.$model"
								type="hidden"
								name="recipient_id"
							/>
							<Multiselect 
								id="due-form-recipient"
								v-model.trim="recipientModel"
								:options="recipientOptions"
								group-values="options" 
								group-label="model"
								placeholder="Search Recipients"
								label="name"
								track-by="id"
								:searchable="true"
								:loading="recipientLoading"
								:internal-search="false"
								@select="handleRecipientSelectChange"
								@search-change="recipientSearch"
							/>
							<template v-if="dueValidate.recipient_id.$error">
								<div
									v-for="(error, index) in dueValidate.recipient_id.$errors"
									:key="index"
									class="mt-2 text-danger"
								>
									{{ error.$message }}
								</div>
							</template>
						</div>
						<div class="col-span-12 sm:col-span-12 mt-2">
							<FormLabel htmlFor="due-form-dues_on">
								Paid On
								<Tippy
									:content="DueTips.dues_on"
									class="inline-block"
								>
									<Lucide icon="HelpCircle" class="w-4 h-4" />
								</Tippy>
							</FormLabel>
							<Litepicker 
								id="due-form-dues_on" 
								v-model.trim="dueValidate.dues_on.$model"
								:options="{
									format: 'MMMM DD, YYYY',
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
							<template v-if="dueValidate.dues_on.$error">
								<div
									v-for="(error, index) in dueValidate.dues_on.$errors"
									:key="index"
									class="mt-2 text-danger"
								>
									{{ error.$message }}
								</div>
							</template>
						</div>
						<div class="col-span-12 sm:col-span-12 mt-2">
							<FormLabel htmlFor="due-form-type">
								Payment Type
								<Tippy
									:content="DueTips.type"
									class="inline-block"
								>
									<Lucide icon="HelpCircle" class="w-4 h-4" />
								</Tippy>
							</FormLabel>
							<Multiselect 
								id="due-form-type"
								v-model.trim="dueValidate.type.$model"
								:options="assetTypeSelectOptions"
								placeholder="Select Type"
							/>
							<template v-if="dueValidate.type.$error">
								<div
									v-for="(error, index) in dueValidate.type.$errors"
									:key="index"
									class="mt-2 text-danger"
								>
									{{ error.$message }}
								</div>
							</template>
						</div>
						<div class="col-span-12 sm:col-span-12 mt-2">
							<FormLabel htmlFor="due-form-amount">
								Amount
								<Tippy
									:content="DueTips.amount"
									class="inline-block"
								>
									<Lucide icon="HelpCircle" class="w-4 h-4" />
								</Tippy>
							</FormLabel>
							<InputGroup>
								<InputGroup.Text id="input-group-amount"> $ </InputGroup.Text>
								<FormInput id="due-form-amount" v-model.trim="dueValidate.amount.$model" type="text" aria-describedby="input-group-amount" />
							</InputGroup>
							<template v-if="dueValidate.amount.$error">
								<div
									v-for="(error, index) in dueValidate.amount.$errors"
									:key="index"
									class="mt-2 text-danger"
								>
									{{ error.$message }}
								</div>
							</template>
						</div>
						<div class="col-span-12 sm:col-span-12 mt-2">
							<FormLabel htmlFor="due-form-transaction-memo">
								Transaction Memo
								<Tippy
									:content="DueTips.memo"
									class="inline-block"
								>
									<Lucide icon="HelpCircle" class="w-4 h-4" />
								</Tippy>
							</FormLabel>
							<FormInput id="due-form-transaction-memo" v-model.trim="dueValidate.memo.$model" type="text" />
							<template v-if="dueValidate.memo.$error">
								<div
									v-for="(error, index) in dueValidate.memo.$errors"
									:key="index"
									class="mt-2 text-danger"
								>
									{{ error.$message }}
								</div>
							</template>
						</div>
					</div>
				</Dialog.Description>
				<Dialog.Footer>
					<Button 
						type="button" 
						variant="outline-secondary" 
						@click="() => {
							setDueModal(false);
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
	<!-- END: Due Modal Content -->
</template>