import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';

export default function Edit( props ) {
	const { attributes, setAttributes } = props;
	//const { step1title, step2title } = attributes;

	return (
		<div { ...useBlockProps() } key="my-key">
			<RichText
				tagName="p"
				onChange={ ( val ) => {
					console.log( val );
					/*
					let newStep1Title = [ ...props.attributes.bsTerms ];
					newStep1Title = val;
					
					 */

					setAttributes( { step1title: val } );
				} }
				value={ attributes.step1title }
				key="test-key"
			/>
		</div>
	);
}
