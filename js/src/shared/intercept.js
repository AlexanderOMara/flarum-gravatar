import {matches, copyElement} from './dom';
import {data} from './util';

const gravatarAvatarRegex = /^[^/]*\/\/[^/]*gravatar\.com\/avatar\//;
const gravatarLink = 'https://gravatar.com/';
const gravatarText = 'Gravatar';
const uploadIcon = 'fa-external-link-alt';

function updateAvatarEditors() {
	const {disableLocal} = data();
	const editors = document.querySelectorAll('.AvatarEditor');
	for (let i = editors.length; i--;) {
		const editor = editors[i];
		const avatar = editor.querySelector('.Avatar');
		const upload = editor.querySelector('.item-upload');
		const remove = editor.querySelector('.item-remove');
		const gravatarAvatar = avatar && gravatarAvatarRegex.test(avatar.src);

		// Add Gravatar menu item if not already added.
		if (upload && !editor.querySelector('.item-gravatar')) {
			const item = copyElement(upload);
			item.className = item.className.replace(
				'item-upload',
				'item-gravatar'
			);
			const button = item.querySelector('button');
			if (button) {
				button.setAttribute('title', gravatarText);
				const label = button.querySelector('.Button-label');
				if (label) {
					label.textContent = gravatarText;
				}
				const icon = button.querySelector('.Button-icon');
				icon.className = icon.className.replace(
					/(^|\s)fa-\S+(\s|$)/,
					`$1${uploadIcon}$2`
				);
				if (icon.className.indexOf(uploadIcon) < 0) {
					icon.className += ` ${uploadIcon}`;
				}
			}
			upload.parentElement.appendChild(item);
		}

		// Only show remove for local avatars.
		if (remove) {
			remove.style.display = gravatarAvatar ? 'none' : '';
		}

		// Only show upload if local avatars not disabled.
		if (upload) {
			upload.style.display = disableLocal ? 'none' : '';
		}
	}
}

function clickHandler(e) {
	const {target} = e;

	// If click on Gravatar menu item, open link.
	if (matches(target, '.AvatarEditor .item-gravatar *')) {
		if (data().linkNewTab) {
			window.open(gravatarLink, '_blank');
		}
		else {
			location.href = gravatarLink;
		}
	}

	// If click to open menu, update the editors.
	else if (
		matches(target, '.AvatarEditor .Dropdown-toggle') ||
		matches(target, '.AvatarEditor .Dropdown-toggle *')
	) {
		updateAvatarEditors();
	}
}

export function intercept() {
	window.addEventListener('click', clickHandler, true);
}
