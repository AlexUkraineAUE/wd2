/*
	Post Challenge Javascript
	Code to link the range input to the output element
*/

document.addEventListener("DOMContentLoaded", () => {
	const count = document.querySelector('#count');
	const output = document.querySelector('.count-output');

	output.textContent = count.value;

	count.addEventListener('input', () => {
		output.textContent = count.value;
	});
})