import { registerBlockType } from '@wordpress/blocks';
import {
	TextControl,
	__experimentalNumberControl as NumberControl,
} from '@wordpress/components';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

export class FormEntriesBlock {
	constructor() {
		registerBlockType( 'planet4-gpch-plugin-blocks/form-entries', {
			apiVersion: 2,
			title: 'Form Entries',
			icon: 'editor-ul',
			category: 'gpch',
			attributes: {
				formId: {
					type: 'integer',
				},
				fieldId: {
					type: 'number',
				},
				numberOfEntries: {
					type: 'integer',
					default: 4,
				},
				text: {
					type: 'string',
				},
			},
			edit: ( { attributes, isSelected, setAttributes } ) => {
				const blockProps = useBlockProps();

				return (
					<div { ...blockProps }>
						{ ! isSelected ? (
							<div className="wp-block-planet4-gpch-plugin-blocks-form-entries">
								<p>PREVIEW</p>
							</div>
						) : (
							<div>
								<NumberControl
									label={ 'Form ID' }
									description={
										'The ID of the form you want to pull entries from'
									}
									isShiftStepEnabled={ true }
									onChange={ ( val ) =>
										setAttributes( {
											formId: parseInt( val ),
										} )
									}
									dragDirection={ 'n' }
									dragThreshold={ 20 }
									step={ 1 }
									value={ attributes.formId }
								/>
								<NumberControl
									label={ 'Form Field ID' }
									description={
										'The ID of the form field you want to display'
									}
									isShiftStepEnabled={ true }
									onChange={ ( val ) =>
										setAttributes( {
											fieldId: parseFloat( val ),
										} )
									}
									dragDirection={ 'n' }
									dragThreshold={ 20 }
									step={ 0.1 }
									value={ attributes.fieldId }
								/>
								<NumberControl
									label={ 'Number of entries to show' }
									isShiftStepEnabled={ true }
									onChange={ ( val ) =>
										setAttributes( {
											numberOfEntries: parseInt( val ),
										} )
									}
									dragDirection={ 'n' }
									dragThreshold={ 20 }
									step={ 1 }
									value={ attributes.numberOfEntries }
								/>
								<p>The text to diplay for every line:</p>
								<RichText
									tagName={ 'p' }
									value={ attributes.text }
									allowedFormats={ [ 'core/bold' ] }
									onChange={ ( val ) =>
										setAttributes( { text: val } )
									}
								/>
							</div>
						) }
					</div>
				);
			},
		} );
	}
}
