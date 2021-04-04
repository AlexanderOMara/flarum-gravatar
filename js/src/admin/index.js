import app from 'flarum/app';

import {ID} from '../config';
import {intercept} from '../shared/intercept';

app.initializers.add(ID, app => {
	intercept();

	app.extensionData.for(ID)
		.registerSetting({
			setting: `${ID}.default`,
			label: (<span>Default (<code>mp</code>, <code>identicon</code>, <code>retro</code>, [URL], ...)</span>),
			type: 'text'
		})
		.registerSetting({
			setting: `${ID}.default_force`,
			label: (<span>Force Default Gravatar Icons</span>),
			type: 'boolean'
		})
		.registerSetting({
			setting: `${ID}.rating`,
			label: (<span>Rating (<code>g</code>, <code>pg</code>, <code>r</code>, <code>x</code>)</span>),
			type: 'text'
		})
		.registerSetting({
			setting: `${ID}.disable_local`,
			label: (<span>Disable Local Avatars</span>),
			type: 'boolean'
		})
		.registerSetting({
			setting: `${ID}.link_new_tab`,
			label: (<span>Gravatar Link New Tab</span>),
			type: 'boolean'
		})
	;
});
