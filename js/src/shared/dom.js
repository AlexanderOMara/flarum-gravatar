function matchesPolly(selector) {
	return Array.prototype.indexOf.call(
		(this.ownerDocument || this.document).querySelectorAll(selector),
		this
	) > -1;
}

export function matches(element, selector) {
	return (
		element.matches ||
		element.matchesSelector ||
		element.webkitMatchesSelector ||
		element.mozMatchesSelector ||
		element.msMatchesSelector ||
		element.oMatchesSelector ||
		matchesPolly
	)
		.call(element, selector);
}

export function copyElement(element) {
	const div = document.createElement('div');
	div.innerHTML = element.outerHTML;
	return div.firstChild;
}
