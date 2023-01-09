document.addEventListener('DOMContentLoaded', function () {
	// Action Divider Block
	const yesButtons = document.querySelectorAll('.action-divider .action-divider-question-button-yes');
	const noButtons = document.querySelectorAll('.action-divider .action-divider-question-button-no');

	yesButtons.forEach((yesButton) => {
		yesButton.addEventListener('click', () => {
			const actionDividerBlock = yesButton.closest('.action-divider');

			actionDividerBlock.querySelector('.action-divider-question-wrapper').style.maxHeight = 0;
			actionDividerBlock.querySelector('.action-divider-step2-yes').style.maxHeight = '400px';
			actionDividerBlock.querySelector('.action-divider-step2-yes').style.display = 'block';
		});
	});

	noButtons.forEach((noButton) => {
		noButton.addEventListener('click', () => {
			const actionDividerBlock = noButton.closest('.action-divider');

			actionDividerBlock.querySelector('.action-divider-question-wrapper').style.maxHeight = 0;
			actionDividerBlock.querySelector('.action-divider-step2-no').style.maxHeight = '1000px';
			actionDividerBlock.querySelector('.action-divider-step2-no').style.display = 'block';
		});
	});
});
