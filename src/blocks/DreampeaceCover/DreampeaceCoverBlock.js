import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

export class DreampeaceCoverBlock {
	constructor() {
		registerBlockType( 'planet4-gpch-plugin-blocks/dreampeace-cover', {
			apiVersion: 2,
			title: 'Dreampeace Cover',
			icon: 'align-wide',
			category: 'gpch',
			attributes: {
				title: {
					type: 'string',
				},
				text: {
					type: 'string',
				},
				noYear: {
					type: 'string',
				},
			},
			edit: ( { attributes, isSelected, setAttributes } ) => {
				const blockProps = useBlockProps();

				const blockStyle = {
					backgroundColor: '#dbebbe',
					padding: '1rem',
				};
				const textboxStyle = {
					border: 'solid 1px #666',
					padding: '0 .5rem',
					backgroundColor: '#ffffff',
				};
				const titleStyle = {
					marginTop: '0',
				};

				return (
					<div { ...blockProps }>
						{ ! isSelected ? (
							<div className="gpch-plugin-blocks-dreampeace-cover">
								<ServerSideRender
									block="planet4-gpch-plugin-blocks/dreampeace-cover"
									attributes={ attributes }
								/>
							</div>
						) : (
							<div>
								<div style={ blockStyle }>
									<h3 style={ titleStyle }>
										Dreampeace Cover
									</h3>
									<RichText
										style={ textboxStyle }
										tagName={ 'h2' }
										value={ attributes.title }
										allowedFormats={ [] }
										placeholder="Title"
										label="Title"
										onChange={ ( val ) =>
											setAttributes( { title: val } )
										}
									/>
									<RichText
										style={ textboxStyle }
										tagName={ 'p' }
										value={ attributes.text }
										allowedFormats={ [ 'core/bold' ] }
										placeholder="Text"
										onChange={ ( val ) =>
											setAttributes( { text: val } )
										}
									/>
									<p>
										Text to show if no slide for that year
										exists:
									</p>
									<RichText
										style={ textboxStyle }
										tagName={ 'p' }
										value={ attributes.noYear }
										placeholder="Error Text"
										onChange={ ( val ) =>
											setAttributes( { noYear: val } )
										}
									/>
								</div>
							</div>
						) }
					</div>
				);
			},
		} );
	}
}
