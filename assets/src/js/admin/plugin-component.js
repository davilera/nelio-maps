const { _x } = wp.i18n;
const { Fragment } = wp.element;
const { PluginSidebar, PluginSidebarMoreMenuItem } = wp.editPost;
const { dispatch } = wp.data;
const { createBlock } = wp.blocks;
const {
	Button,
	ColorPicker,
	PanelBody,
} = wp.components;

function addDemoBlock() {

	const demoBlock = createBlock( 'nelio-maps/demo', {
		greeting: 'Hey there!',
		className: 'is-style-awesome',
	} );
	dispatch( 'core/editor' ).insertBlock( demoBlock );

}//end addDemoBlock()

const PluginComponent = () => (

	// Every component must have only one parent element.
	// In this case, the parent element is a Fragment.
	<Fragment>
		<PluginSidebarMoreMenuItem target="sidebar-name">
			{ _x( 'My Sidebar', 'text', 'nelio-maps' ) }
		</PluginSidebarMoreMenuItem>
		<PluginSidebar name="sidebar-name" title="My Sidebar">

			<PanelBody title={ _x( 'Color', 'text', 'nelio-maps' ) }>
				<ColorPicker
					onChangeComplete={ ( value ) => console.log( `The selected color was: ${ value.hex }` ) }
				/>
			</PanelBody>

			<PanelBody title={ _x( 'Content', 'text', 'nelio-maps' ) }>
				<Button
					className="nelio-maps-plugin-button"
					isLarge
					onClick={ () => addDemoBlock() }
				>
					{ _x( 'Add a demo block', 'text', 'nelio-maps' ) }
				</Button>
			</PanelBody>

		</PluginSidebar>
	</Fragment>
);
export default PluginComponent;
