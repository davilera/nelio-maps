import './styles/editor.scss';
import classnames from 'classnames';

const { Component } = wp.element;

const {
	BaseControl,
} = wp.components;

export default class ImagePicker extends Component {

	render() {

		const {
			label,
			value,
			options = false,
			onChange = () => {},
		} = this.props;

		return (
			<BaseControl
				label={ label }
				className="nelio-maps-image-picker"
			>
				{ options && options.map( ( option ) => {
					return (
						<button
							key={ `image-picker-${ option.value }` }
							onClick={ () => onChange( option.value, option ) }
							aria-pressed={ (value === option.value).toString() }
							className={ classnames( 'nelio-maps-image-picker-item', { 'nelio-maps-image-picker-item-active': value === option.value } ) }
						>
							{ option.image && 'string' === typeof option.image && (
								<img
									src={ option.image }
									alt={ option.label || option.value }
								/>
							) }
							{ option.image && 'string' !== typeof option.image && (
								option.image
							) }
							{ option.label && (
								<span>{ option.label }</span>
							) }
						</button>
					);
				} ) }
			</BaseControl>
		);

	}//end render()

}//end class

