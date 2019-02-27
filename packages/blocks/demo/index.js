/* =================================================================== */
/* =================================================================== */
const BLOCK_NAME = 'nelio-maps/demo';
const BLOCK_TITLE = wp.i18n._x( 'Demo', 'text', 'nelio-maps' );
const BLOCK_DESCRIPTION = wp.i18n._x( 'Show a demo block.', 'user', 'nelio-maps' );
/* =================================================================== */
/* =================================================================== */

import './styles/style.scss';
import './styles/editor.scss';

// Uncomment the following line to use a SVG file for the icon of the block.
// import ElementIcon from './icon.svg';

import DemoEdit from './edit';
import DemoSave from './save';
import attributes from './attributes';

const { _x } = wp.i18n;

export const name = BLOCK_NAME;
export const settings = {

	title: BLOCK_TITLE,
	description: BLOCK_DESCRIPTION,

	// icon: <ElementIcon />, // Use a SVG for the icon instead.
	icon: 'heart', // Use a Dashicon for the icon instead of a SVG.

	category: 'demo',
	keywords: [
		_x( 'Demo', 'text', 'nelio-maps' ),
	],

	attributes,
	edit: DemoEdit,
	save: DemoSave,

};

export const styles = [
	{ name: 'default', label: _x( 'Default', 'text', 'nelio-maps' ) },
	{ name: 'awesome', label: _x( 'Awesome', 'text', 'nelio-maps' ) },
];
