import Toastify from 'toastify-js';

const showToast = (success:boolean, message:string) => {
	const toastEl = document
		.querySelectorAll("#" + (success ? 'success' : 'failed') + "-notification-content")[0]
		.cloneNode(true) as HTMLElement;
	toastEl.classList.remove("hidden");
	const messageElement = success ? toastEl.querySelector('#successMessage') : toastEl.querySelector('#failedMessage');
	if (messageElement) {
		messageElement.innerHTML = message ?? (success ? "Your action was completed sucessfully." : "Please check the form.");
	}
	Toastify({
		node: toastEl,
		duration: 10000,
		newWindow: true,
		close: true,
		gravity: "top",
		position: "right",
		stopOnFocus: true,
	}).showToast();
}

export {
  showToast,
};