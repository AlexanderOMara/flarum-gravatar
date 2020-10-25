import app from 'flarum/app';

import {ID} from '../config';
import {intercept} from '../shared/intercept';
import {GravatarSettingsModal} from './components/GravatarSettingsModal';

app.initializers.add(ID, () => {
	intercept();

	app.extensionSettings[ID] = () => app.modal.show(GravatarSettingsModal);
});
