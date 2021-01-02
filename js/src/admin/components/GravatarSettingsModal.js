import SettingsModal from 'flarum/components/SettingsModal';

import {ID} from '../../config';

export class GravatarSettingsModal extends SettingsModal {
	className() {
		return 'GravatarSettingsModal Modal--small';
	}

	title() {
		return 'Gravatar Settings';
	}

	form() {
		const self = this;
		const setting = (key, type = String) => function() {
			return type(self.setting(`${ID}.${key}`).apply(this, arguments));
		};
		return [
			<div className="Form-group">
				<label>Default (<code>mp</code>, <code>identicon</code>, <code>retro</code>, [URL], ...)</label>
				<code><input className="FormControl" bidi={setting('default')}/></code>
			</div>
			,
			<div className="Form-group">
				<label className="checkbox">
					<input type="checkbox" bidi={setting('default_force', Number)}/>
					Force Default Gravatar Icons
				</label>
			</div>
			,
			<div className="Form-group">
				<label>Rating (<code>g</code>, <code>pg</code>, <code>r</code>, <code>x</code>)</label>
				<code><input className="FormControl" bidi={setting('rating')}/></code>
			</div>
			,
			<div className="Form-group">
				<label className="checkbox">
					<input type="checkbox" bidi={setting('disable_local', Number)}/>
					Disable Local Avatars
				</label>
			</div>
			,
			<div className="Form-group">
				<label className="checkbox">
					<input type="checkbox" bidi={setting('link_new_tab', Number)}/>
					Gravatar Link New Tab
				</label>
			</div>
		];
	}
}
