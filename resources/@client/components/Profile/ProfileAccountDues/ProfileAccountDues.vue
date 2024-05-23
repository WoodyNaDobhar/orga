<script setup lang="ts">
	import { Menu } from "@/components/Base/Headless";
	import Button from "@/components/Base/Button";
	import { useStateStore } from '@/stores/state';
	import { DueSimple, Persona } from "@/interfaces";
	import { createApp, onMounted, reactive, ref, watch } from "vue";
	import { formatDate } from "@/utils/helper";
	import Loader from "@/components/Base/Loader";
	import Lucide from "@/components/Base/Lucide";
	import { TabulatorFull as Tabulator } from "tabulator-tables";
	import { createIcons, icons } from "lucide";
	import * as xlsx from "xlsx";
	import { FormInput, FormSelect } from "@/components/Base/Form";
	import "@/assets/css/vendors/tabulator.css";
	import DueButton from "../DueButton/DueButton.vue";
	import { Dialog } from "@/components/Base/Headless";
	import axios from "axios";
	import { showToast } from "@/utils/toast";
	import {DateTime} from 'luxon';
	import { update } from "lodash";

	const state = useStateStore()
	const props = defineProps<{
		persona: Persona | undefined
	}>()
	const isLoading = ref<boolean>(false)
	const loadingMessage = ref<string>('')
	window.DateTime = DateTime

	interface AccountDuesEmit {
		(e: "updated", value: Persona): void;
	}
	const emit = defineEmits<AccountDuesEmit>();
	
	const tableRef = ref<HTMLDivElement>();
	const tabulator = ref<Tabulator>();
	const tableData = reactive<DueSimple[]>([]);
	
	const dueModal = ref<number | boolean>(false)
	const thisDue = ref<DueSimple | null>(null);
	const setDueModal = (value: number | boolean) => {
		console.log(value)
		if (typeof value === 'number') {
			thisDue.value = tableData.find(due => due.id === value) || null;
		} else {
			thisDue.value = null;
		}
		dueModal.value = value;
	}

	const deleteButtonRef = ref(null);
	const deleteConfirmationModal = ref<number | boolean>(false)
	const setDeleteConfirmationModal = (value: number | boolean) => {
		if (typeof value === 'number') {
			thisDue.value = tableData.find(due => due.id === value) || null;
		} else {
			thisDue.value = null;
		}
		deleteConfirmationModal.value = value;
	}
	
	const filter = reactive({
		field: "dues_on",
		type: "like",
		value: "",
	});

	const setFilter = (value: typeof filter) => {
		Object.assign(filter, value);
	};
	
	const initTabulator = () => {
		if (tableRef.value) {
			tabulator.value = new Tabulator(tableRef.value, {
				data: tableData,
				printAsHtml: true,
				printStyled: true,
				pagination: true,
				paginationSize: 10,
				paginationSizeSelector: [10, 20, 30, 40],
				layout: "fitColumns",
				responsiveLayout: "collapse",
				placeholder: "No matching records found",
				columns: [
					{
						title: "",
						formatter: "responsiveCollapse",
						width: 40,
						minWidth: 30,
						hozAlign: "center",
						resizable: false,
						headerSort: false,
					},

					// For HTML table
					{
						title: "PAID ON",
						minWidth: 200,
						responsive: 0,
						field: "dues_on",
						vertAlign: "middle",
						print: false,
						download: false,
						formatter:"datetime", 
						formatterParams:{
							inputFormat:"iso",
							outputFormat:"DDD",
							invalidPlaceholder:"(invalid date)",
						}
					},
					{
						title: "MEMO",
						minWidth: 200,
						field: "transaction.memo",
						vertAlign: "middle",
						print: false,
						download: false,
					},
					{
						title: "INTERVALS",
						minWidth: 200,
						field: "intervals",
						hozAlign: "center",
						headerHozAlign: "center",
						vertAlign: "middle",
						print: false,
						download: false,
					},
					{
						title: "AMOUNT",
						minWidth: 200,
						field: "amount",
						hozAlign: "center",
						headerHozAlign: "center",
						vertAlign: "middle",
						print: false,
						download: false,
						formatter:"money", 
						formatterParams:{
							decimal:".",
							thousand:",",
							symbol:"$",
							precision:false,
						}
					},
					{
						title: "ACTIONS",
						minWidth: 200,
						field: "actions",
						responsive: 1,
						hozAlign: "center",
						headerHozAlign: "center",
						vertAlign: "middle",
						print: false,
						download: false,
						formatter(cell) {
							const due: DueSimple = cell.getData() as DueSimple;
							const wrap = document.createElement("div");
							wrap.classList.add("flex", "items-center", "lg:justify-center");

							const a = document.createElement("a");
							a.classList.add("flex", "items-center", "mr-3");
							a.href = "javascript:;";
							a.innerHTML = `
								<i data-lucide="eye" class="w-4 h-4 mr-1"></i> View
							`;
							a.addEventListener("click", function (event) {
								event.preventDefault();
								setDueModal(due.id);
							});

							const div = document.createElement("div");
							const instance = createApp(DueButton, {
								persona: props.persona,
								due: due,
								label: 'Edit'
							});
							instance.config.globalProperties.$emit = (event: string, ...args: any[]) => {
								console.log(args)
								if (event === 'update') {
									const due = args[0] as DueSimple;
      								updateDue(due);
								}
							};
							instance.mount(div);

							const c = document.createElement("a");
							c.classList.add("flex", "items-center", "text-danger");
							c.href = "javascript:;";
							c.innerHTML = `
								<i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
							`;
							c.addEventListener("click", function (event) {
								event.preventDefault();
								setDeleteConfirmationModal(due.id);
							});

							wrap.appendChild(a);
							wrap.appendChild(div);
							wrap.appendChild(c);

							return wrap;
						},
					},

					// For print format
					{
						title: "PAID ON",
						field: "dues_on",
						visible: false,
						print: true,
						download: true,
						formatterPrint(cell) {
							return formatDate(cell.getValue(), 'MMMM DD, YYYY');
						},
					},
					{
						title: "MEMO",
						field: "transaction.memo",
						visible: false,
						print: true,
						download: true,
					},
					{
						title: "INTERVALS",
						field: "intervals",
						visible: false,
						print: true,
						download: true,
					},
					{
						title: "AMOUNT",
						field: "amount",
						visible: false,
						print: true,
						download: true,
						formatterPrint(cell) {
							return "$" + cell.getValue();
						},
					},
				],
			});
		}

		tabulator.value?.on("renderComplete", () => {
			createIcons({
				icons,
				attrs: {
					"stroke-width": 1.5,
				},
				nameAttr: "data-lucide",
			});
		});
	};

	// Redraw table onresize
	const reInitOnResizeWindow = () => {
		window.addEventListener("resize", () => {
			if (tabulator.value) {
				tabulator.value.redraw();
				createIcons({
					icons,
					attrs: {
						"stroke-width": 1.5,
					},
					nameAttr: "data-lucide",
				});
			}
		});
	};

	// Filter function
	const onFilter = () => {
		if (tabulator.value) {
			tabulator.value.setFilter(filter.field, filter.type, filter.value);
		}
	};

	// On reset filter
	const onResetFilter = () => {
		setFilter({
			...filter,
			field: "dues_on",
			type: "like",
			value: "",
		});
		onFilter();
	};

	// Export
	const onExportCsv = () => {
		if (tabulator.value) {
			tabulator.value.download("csv", "data.csv");
		}
	};

	const onExportJson = () => {
		if (tabulator.value) {
			tabulator.value.download("json", "data.json");
		}
	};

	const onExportXlsx = () => {
		if (tabulator.value) {
			(window as any).XLSX = xlsx;
			tabulator.value.download("xlsx", "data.xlsx", {
				sheetName: "Products",
			});
		}
	};

	const onExportHtml = () => {
		if (tabulator.value) {
			tabulator.value.download("html", "data.html", {
				style: true,
			});
		}
	};

	// Print
	const onPrint = () => {
		if (tabulator.value) {
			tabulator.value.print();
		}
	};

	const addDue = (newDue: DueSimple) => {
		if (props.persona) {
			if (!props.persona.dues) {
				props.persona.dues = [newDue]
			} else {
				props.persona.dues.push(newDue)
			}
			emit("updated", props.persona)
		}
	}

	const updateDue = (due: DueSimple) => {
		if (props.persona && props.persona.dues) {
			const index = props.persona.dues.findIndex(r => r.id === due.id);
			if (index !== -1) {
				props.persona.dues[index] = due
				emit("updated", props.persona)
			}
		}
	}

	const deleteDue = (due: DueSimple) => {
		try {
			axios.delete(`/api/issuances/${due.id}`)
				.then(response => {
					if (props.persona && props.persona.dues) {
						const index = props.persona.dues.findIndex(r => r.id === due.id)
						if (index !== -1) {
							props.persona.dues.splice(index, 1)
						}
						showToast(true, response.data.message)
						setDueModal(false)
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

	onMounted(() => {
		if (props.persona?.dues) {
			tableData.splice(0, tableData.length, ...props.persona.dues);
		}
		initTabulator();
		reInitOnResizeWindow();
	});
	
	watch(() => props.persona?.dues, (newDues) => {
		if (newDues) {
			tableData.splice(0, tableData.length, ...newDues);
		}
	}, { immediate: true });
</script>
<template>
	<div class="col-span-12 lg:col-span-8 2xl:col-span-9">
		<div class="intro-y box lg:mt-5">
			<div
				class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400"
			>
				<h2 class="mr-auto text-base font-medium">Dues History</h2>
				<DueButton :persona="persona" @added="addDue" />
			</div>
			<div class="pl-5 pr-5 pb-5">
				<div class="flex flex-col">
					<Loader 
						:active="isLoading"
						:message="loadingMessage"
					/>
					<!-- BEGIN: HTML Table Data -->
					<div class="mt-5">
						<div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
							<form
								id="tabulator-html-filter-form"
								class="xl:flex sm:mr-auto"
								@submit="
									(e) => {
										e.preventDefault();
										onFilter();
									}
								"
							>
								<div class="items-center sm:flex sm:mr-4">
									<label
										class="flex-none w-12 mr-2 xl:w-auto xl:flex-initial"
									>
										Field
									</label>
									<FormSelect
										id="tabulator-html-filter-field"
										v-model="filter.field"
										class="w-full mt-2 2xl:w-full sm:mt-0 sm:w-auto"
									>
										<option value="dues_on">Paid On</option>
										<option value="transaction.memo">Memo</option>
										<option value="intervals">Intervals</option>
										<option value="amount">Amount</option>
									</FormSelect>
								</div>
								<div class="items-center mt-2 sm:flex sm:mr-4 xl:mt-0">
									<label
										class="flex-none w-12 mr-2 xl:w-auto xl:flex-initial"
									>
										Type
									</label>
									<FormSelect
										id="tabulator-html-filter-type"
										v-model="filter.type"
										class="w-full mt-2 sm:mt-0 sm:w-auto"
									>
										<option value="like">like</option>
										<option value="=">=</option>
										<option value="<">&lt;</option>
										<option value="<=">&lt;=</option>
										<option value=">">&gt;</option>
										<option value=">=">&gt;=</option>
										<option value="!=">!=</option>
									</FormSelect>
								</div>
								<div class="items-center mt-2 sm:flex sm:mr-4 xl:mt-0">
									<label
										class="flex-none w-12 mr-2 xl:w-auto xl:flex-initial"
									>
										Value
									</label>
									<FormInput
										id="tabulator-html-filter-value"
										v-model="filter.value"
										type="text"
										class="mt-2 sm:w-40 2xl:w-full sm:mt-0"
										placeholder="Search..."
									/>
								</div>
								<div class="mt-2 xl:mt-0">
									<Button
										id="tabulator-html-filter-go"
										variant="primary"
										type="button"
										class="w-full sm:w-16"
										@click="onFilter"
									>
										Go
									</Button>
									<Button
										id="tabulator-html-filter-reset"
										variant="secondary"
										type="button"
										class="w-full mt-2 sm:w-16 sm:mt-0 sm:ml-1"
										@click="onResetFilter"
									>
										Reset
									</Button>
								</div>
							</form>
							<div class="flex mt-5 sm:mt-0">
								<Button
									id="tabulator-print"
									variant="outline-secondary"
									class="w-1/2 mr-2 sm:w-auto"
									@click="onPrint"
								>
									<Lucide icon="Printer" class="w-4 h-4 mr-2" /> Print
								</Button>
								<Menu class="w-1/2 sm:w-auto">
									<Menu.Button
										:as="Button"
										variant="outline-secondary"
										class="w-full sm:w-auto"
									>
										<Lucide icon="FileText" class="w-4 h-4 mr-2" /> Export
										<Lucide
											icon="ChevronDown"
											class="w-4 h-4 ml-auto sm:ml-2"
										/>
									</Menu.Button>
									<Menu.Items class="w-40">
										<Menu.Item @click="onExportCsv">
											<Lucide icon="FileText" class="w-4 h-4 mr-2" />
											Export CSV
										</Menu.Item>
										<Menu.Item @click="onExportJson">
											<Lucide icon="FileText" class="w-4 h-4 mr-2" />
											Export JSON
										</Menu.Item>
										<Menu.Item @click="onExportXlsx">
											<Lucide icon="FileText" class="w-4 h-4 mr-2" />
											Export XLSX
										</Menu.Item>
										<Menu.Item @click="onExportHtml">
											<Lucide icon="FileText" class="w-4 h-4 mr-2" />
											Export HTML
										</Menu.Item>
									</Menu.Items>
								</Menu>
							</div>
						</div>
						<div class="overflow-x-auto scrollbar-hidden">
							<div id="tabulator" ref="tableRef" class="mt-5"></div>
						</div>
					</div>
					<!-- END: HTML Table Data -->
					<!-- BEGIN: Modal Content -->
					<Dialog 
						size="xl"
						:open="dueModal !== false"
						@close="() => {
							setDueModal(false);
						}"
						class="relative z-50"
					>
						<Dialog.Panel>
							<Dialog.Title>
								<h2 class="mr-auto text-base font-medium">
									{{ formatDate(thisDue?.dues_on ?? '', 'MMMM DD, YYYY') }}
								</h2>
								<a 
									@click="(event: MouseEvent) => {
										event.preventDefault();
										setDueModal(false);
									}" 
									class="absolute top-0 right-0 mt-2 mr-3" 
									href="#"
								>
									<Lucide icon="X" class="w-8 h-8 text-slate-400" />
								</a>
							</Dialog.Title>
							<Dialog.Description class="grid grid-cols-12 gap-4 gap-y-3">
								<div class="col-span-12 sm:col-span-6">
									<strong>Intervals:</strong> {{ thisDue?.intervals }}<br>
									<strong>Memo:</strong> {{ thisDue?.transaction.memo }}<br>
								</div>
								<div class="col-span-12 sm:col-span-6">
									<div>
										asdf
									</div>
								</div>
							</Dialog.Description>
						</Dialog.Panel>
					</Dialog>
					<!-- END: Modal Content -->
					<!-- BEGIN: Delete Confirmation Modal -->
					<Dialog
						:open="deleteConfirmationModal !== false"
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
									if(thisDue){
										deleteDue(thisDue)
									}
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
		</div>
	</div>
</template>
