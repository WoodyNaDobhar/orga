<script setup lang="ts">
	import Lucide from "@/components/Base/Lucide";
	import Notification from "@/components/Base/Notification";
</script>

<template>
  <RouterView />
	<!-- BEGIN: Success Notification Content -->
	<Notification id="success-notification-content" class="flex hidden">
		<Lucide icon="CheckCircle" class="text-success" />
		<div class="ml-4 mr-4">
			<div class="font-medium">Success!</div>
			<div class="mt-1 text-slate-500" id="successMessage">
				Your action was completed sucessfully.
			</div>
		</div>
	</Notification>
	<!-- END: Success Notification Content -->
	<!-- BEGIN: Failed Notification Content -->
	<Notification id="failed-notification-content" class="flex hidden">
		<Lucide icon="XCircle" class="text-danger" />
		<div class="ml-4 mr-4">
			<div class="font-medium">Error!</div>
			<div class="mt-1 text-slate-500" id="failedMessage">Please check the form.</div>
		</div>
	</Notification>
	<!-- END: Failed Notification Content -->
</template>