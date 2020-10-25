import app from 'flarum/app';

import {ID} from '../config';

export function data() {
	return app.data[ID];
}
