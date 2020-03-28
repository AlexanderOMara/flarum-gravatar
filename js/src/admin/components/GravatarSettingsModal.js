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
		const setting = key => this.setting(`${ID}.${key}`);
		return [
			<div className="Form-group">
				<label>Default (<code>mp</code>, <code>identicon</code>, <code>retro</code>, [URL], ...)</label>
				<code><input className="FormControl" bidi={setting('default')}/></code>
			</div>
			,
			<div className="Form-group">
				<label className="checkbox">
					<input type="checkbox" bidi={setting('default_force')}/>
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
					<input type="checkbox" bidi={setting('disable_local')}/>
					Disable Local Avatars
				</label>
			</div>
			,
			<div className="Form-group">
				<label className="checkbox">
					<input type="checkbox" bidi={setting('link_new_tab')}/>
					Gravatar Link New Tab
				</label>
			</div>
		];
	}
}
