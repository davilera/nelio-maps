/**
 * Import the blocks.
 */

import * as map from './google-map';

const {
	registerBlockType,
	registerBlockStyle,
} = wp.blocks;

[
	map,
].forEach( block => {

	if ( ! block ) {
		return;
	}//end if

	// Register the block in the editor.
	const { name, settings } = block;
	registerBlockType( name, settings );

	// Register new block styles.
	const styles = block.styles || [];
	styles.forEach( style => registerBlockStyle( name, style ) );

} );
