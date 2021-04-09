import app from 'flarum/app';

import {ID} from '../config';
import {intercept} from '../shared/intercept';

const join = (v, j) => v.reduce((a, e) => a ? [...a, j, e] : e, null)

const head = (name, examples = null) => (<span>{[
	name,
	...(examples ?
		[' (', ...join(examples.map(e => (<code>{e}</code>)), ', '), ')'] :
		[]
	)
]}</span>);

app.initializers.add(ID, app => {
	intercept();

	const ext = app.extensionData.for(ID);
	const code = (key, name, examples = null) => {
		ext.registerSetting(function() {
			return (
				<div className="Form-group">
					<label>{head(name, examples)}</label>
					<code>
						<input
							type='text'
							className='FormControl'
							bidi={this.setting(`${ID}.${key}`)}
						/>
					</code>
				</div>
			);
		});
	};
	const bool = (key, name, examples = null) => {
		ext.registerSetting({
			setting: `${ID}.${key}`,
			label: head(name, examples),
			type: 'boolean'
		});
	};

	code('default', 'Default', ['mp', 'identicon', 'retro', '[URL]', '...']);
	bool('default_force', 'Force Default Gravatar Icons');
	code('rating', 'Rating', ['g', 'pg', 'r', 'x']);
	bool('disable_local', 'Disable Local Avatars');
	bool('link_new_tab', 'Gravatar Link New Tab');
});
