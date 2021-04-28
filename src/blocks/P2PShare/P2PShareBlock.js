import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import {
	Placeholder,
	TextControl,
	Tooltip,
	__experimentalText as Text,
} from '@wordpress/components';
import {
	useBlockProps,
	RichText,
	ColorPalette,
	InspectorControls,
} from '@wordpress/block-editor';

export class P2PShareBlock {
	constructor() {
		registerBlockType( 'planet4-gpch-plugin-blocks/p2p-share', {
			apiVersion: 2,
			title: 'P2P Share',
			icon: 'share',
			category: 'gpch',
			attributes: {
				step1Title: {
					type: 'string',
					default: __(
						'How many people can you motivate to also sign the petition?',
						'planet4-gpch-blocks'
					),
				},
				step2Title: {
					type: 'string',
					default: __(
						'How will you be able to reach your friends best?',
						'planet4-gpch-blocks'
					),
				},
				whatsAppShareText: {
					type: 'string',
				},
				whatsAppSmsText: {
					type: 'string',
				},
				smsMessage: {
					type: 'string',
				},
				smsShareText: {
					type: 'string',
				},

				bg_color: { type: 'string', default: '#000000' },
				text_color: { type: 'string', default: '#ffffff' },
			},
			edit: ( { attributes, isSelected, setAttributes } ) => {
				const onChangeBGColor = ( hexColor ) => {
					setAttributes( { bg_color: hexColor } );
				};

				const onChangeTextColor = ( hexColor ) => {
					setAttributes( { text_color: hexColor } );
				};

				const separatorStyle = {
					color: '#fff',
					backgroundColor: '#333',
					padding: '.2em .5em',
				};

				const textboxStyle = {
					border: 'solid 1px #666',
					marginBottom: '.5em',
					padding: '.5em',
				};

				const descriptionStyle = {
					fontStyle: 'italic',
				};

				return (
					<div { ...useBlockProps() }>
						{ ! isSelected ? (
							<div>HERE GOES A PREVIEW OF THE BLOCK</div>
						) : (
							<div>
								<InspectorControls key="setting">
									<div id="gpch-blocks-p2p-controls">
										<fieldset>
											<legend className="blocks-base-control__label">
												{ __(
													'Background color',
													'planet4-gpch-blocks'
												) }
											</legend>
											<RichText
												value={ attributes.smsText1 }
												allowedFormats={ [] }
												onChange={ ( val ) =>
													setAttributes( {
														smsText1: val,
													} )
												}
											/>
										</fieldset>
										<fieldset>
											<legend className="blocks-base-control__label">
												{ __(
													'Text color',
													'planet4-gpch-blocks'
												) }
											</legend>
											<ColorPalette // Element Tag for Gutenberg standard colour selector
												onChange={ onChangeTextColor } // onChange event callback
											/>
										</fieldset>
									</div>
								</InspectorControls>

								<h3 style={ separatorStyle }>Step 1</h3>
								<RichText
									tagName={ 'h4' }
									value={ attributes.step1Title }
									allowedFormats={ [] }
									onChange={ ( val ) =>
										setAttributes( { step1Title: val } )
									}
								/>
								<h3 style={ separatorStyle }>Step 2</h3>
								<RichText
									tagName={ 'h4' }
									value={ attributes.step2Title }
									allowedFormats={ [] }
									onChange={ ( val ) =>
										setAttributes( { step2Title: val } )
									}
								/>
								<h3 style={ separatorStyle }>WhatsApp Share</h3>
								<Text
									variant="caption"
									style={ descriptionStyle }
								>
									{ __(
										'WhatsApp Share Text:',
										'planet4-gpch-blocks'
									) }
								</Text>
								<RichText
									value={ attributes.whatsAppShareText }
									placeholder={ __(
										'THE TEXT TO SHARE BY WHATSAPP',
										'planet4-gpch-blocks'
									) }
									allowedFormats={ [] }
									onChange={ ( val ) =>
										setAttributes( {
											whatsAppShareText: val,
										} )
									}
									style={ textboxStyle }
								/>
								<Text
									variant="caption"
									style={ descriptionStyle }
								>
									{ __(
										'WhatsApp SMS Text (needs to include a WhatsApp link):',
										'planet4-gpch-blocks'
									) }
								</Text>
								<RichText
									value={ attributes.whatsAppSmsText }
									placeholder={ __(
										'THE TEXT TO SEND BY SMS',
										'planet4-gpch-blocks'
									) }
									allowedFormats={ [] }
									onChange={ ( val ) =>
										setAttributes( {
											whatsAppSmsText: val,
										} )
									}
									style={ textboxStyle }
								/>
								<h3 style={ separatorStyle }>SMS Share</h3>
								<Text
									variant="body.small"
									style={ descriptionStyle }
								>
									{ __(
										'First SMS, share CTA:',
										'planet4-gpch-blocks'
									) }
								</Text>
								<RichText
									value={ attributes.smsMessage }
									placeholder={ __(
										'FOR EXAMPLE: Thank you for sharing with your friends. Please forward the following SMS text to them.',
										'planet4-gpch-blocks'
									) }
									allowedFormats={ [] }
									onChange={ ( val ) =>
										setAttributes( {
											smsMessage: val,
										} )
									}
									style={ textboxStyle }
								/>
								<Text
									variant="caption"
									style={ descriptionStyle }
								>
									{ __(
										'Second SMS, Text to share:',
										'planet4-gpch-blocks'
									) }
								</Text>
								<RichText
									value={ attributes.smsShareText }
									placeholder={ __(
										'THE TEXT TO SHARE BY SMS',
										'planet4-gpch-blocks'
									) }
									allowedFormats={ [] }
									onChange={ ( val ) =>
										setAttributes( {
											smsShareText: val,
										} )
									}
									style={ textboxStyle }
								/>
							</div>
						) }
					</div>
				);
			},
			/*
			save: ( { attributes } ) => {
				return (
					<div
						{ ...useBlockProps.save() }
						style={ {
							backgroundColor: attributes.bg_color,
							color: attributes.text_color,
						} }
					>
						{ attributes.message }
					</div>
				);
			},
			
			 */
		} );
	}
}
