/**
 * WordPress dependencies
 */
import { _x } from '@wordpress/i18n';
import {
	Component,
	Fragment,
} from '@wordpress/element';
import { TextareaControl } from '@wordpress/components';

/**
 * Internal dependencies
 */
import ImagePicker from '../../../components/image-picker/image-picker';

import defaultMapStyle from './default';
import darkMapStyle from './dark';
import lightMapStyle from './light';
import dawnMapStyle from './dawn';
import nightMapStyle from './night';
import customMapStyle from './custom';

const styles = [
	defaultMapStyle,
	nightMapStyle,
	lightMapStyle,
	darkMapStyle,
	dawnMapStyle,
	customMapStyle,
];

export default class MapStyles extends Component {

	render() {

		const {
			value,
			customStyle,
			onChange = () => {},
		} = this.props;

		return (
			<Fragment>

				<ImagePicker
					value={ value }
					options={ styles }
					onChange={ ( styleName, style ) => onChange( styleName, style.json ? JSON.stringify( style.json ) : '' ) }
				/>

				{ 'custom' === value && (
					<TextareaControl
						label={ _x( 'JSON Style', 'text', 'nelio-maps' ) }
						placeholder={ _x( 'Enter JSON style', 'user', 'nelio-maps' ) }
						help={
							<p>
								{ _x( 'You can use custom styles presets from Snazzy Maps.', 'text', 'nelio-maps' ) }
								{ ' ' }
								<a href="https://snazzymaps.com/" target="_blank" rel="noopener noreferrer">{ _x( 'Check them out here!', 'user (snazzy maps)', 'nelio-maps' ) }</a>
							</p>
						}
						value={ customStyle || '' }
						onChange={ ( style ) => onChange( 'custom', style ) }
					/>
				) }

			</Fragment>

		);
	}//end render()

}//end class

