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
	__experimentalLinkControl as LinkControl,
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
				shareText: {
					type: 'string',
				},
				shareLink: {
					type: 'object',
				},
				utmMedium: {
					type: 'string',
					default: 'p2p',
				},
				utmCampaign: {
					type: 'string',
				},
				whatsAppSmsCTA: {
					type: 'string',
				},
				smsMessage: {
					type: 'string',
				},
				smsShareText: {
					type: 'string',
				},
				emailText: {
					type: 'string',
				},
				emailSubject: {
					type: 'string',
				},
				threemaShareText: {
					type: 'string',
				},

				bg_color: { type: 'string', default: '#000000' },
				text_color: { type: 'string', default: '#ffffff' },
			},
			edit: ( { attributes, isSelected, setAttributes } ) => {
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
													'UTM Tags',
													'planet4-gpch-blocks'
												) }
											</legend>
											<TextControl
												label={ __(
													'UTM Medium',
													'planet4-gpch-blocks'
												) }
												value={ attributes.utmMedium }
												onChange={ ( val ) =>
													setAttributes( {
														utmMedium: val,
													} )
												}
											/>
											<TextControl
												label={ __(
													'UTM Campaign',
													'planet4-gpch-blocks'
												) }
												value={ attributes.utmCampaign }
												onChange={ ( val ) =>
													setAttributes( {
														utmCampaign: val,
													} )
												}
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
								<h3 style={ separatorStyle }>
									Share text/links
								</h3>
								<Text
									variant="caption"
									style={ descriptionStyle }
								>
									{ __(
										'Share link (unshortened and without UTM tags)',
										'planet4-gpch-blocks'
									) }
								</Text>
								<LinkControl
									value={ attributes.shareLink }
									onChange={ ( val ) =>
										setAttributes( {
											shareLink: val,
										} )
									}
									settings={ [] }
									showSuggestions={ true }
								></LinkControl>
								<Text
									variant="caption"
									style={ descriptionStyle }
								>
									{ __(
										'Share text for all channels. The link will be shortened and added to the end of the text:',
										'planet4-gpch-blocks'
									) }
								</Text>
								<RichText
									value={ attributes.shareText }
									placeholder={ __(
										'THE SHARE TEXT FOR ALL CHANNELS',
										'planet4-gpch-blocks'
									) }
									allowedFormats={ [] }
									onChange={ ( val ) =>
										setAttributes( {
											shareText: val,
										} )
									}
									style={ textboxStyle }
								/>
								<h3 style={ separatorStyle }>WhatsApp Share</h3>
								<Text
									variant="caption"
									style={ descriptionStyle }
								>
									{ __(
										'WhatsApp SMS CTA (Link will be added at the end):',
										'planet4-gpch-blocks'
									) }
								</Text>
								<RichText
									value={ attributes.whatsAppSmsCTA }
									placeholder={ __(
										'THE TEXT TO SEND BY SMS',
										'planet4-gpch-blocks'
									) }
									allowedFormats={ [] }
									onChange={ ( val ) =>
										setAttributes( {
											whatsAppSmsCTA: val,
										} )
									}
									style={ textboxStyle }
								/>
								<h3 style={ separatorStyle }>Email Share</h3>
								<Text
									variant="body.small"
									style={ descriptionStyle }
								>
									{ __(
										'Email Subject:',
										'planet4-gpch-blocks'
									) }
								</Text>
								<RichText
									value={ attributes.emailSubject }
									placeholder={ __(
										'EMAIL SUBJECT',
										'planet4-gpch-blocks'
									) }
									allowedFormats={ [] }
									onChange={ ( val ) =>
										setAttributes( {
											emailSubject: val,
										} )
									}
									style={ textboxStyle }
								/>
								<Text
									variant="body.small"
									style={ descriptionStyle }
								>
									{ __(
										'Email Text:',
										'planet4-gpch-blocks'
									) }
								</Text>
								<RichText
									value={ attributes.emailText }
									placeholder={ __(
										'EMAIL TEXT',
										'planet4-gpch-blocks'
									) }
									allowedFormats={ [] }
									onChange={ ( val ) =>
										setAttributes( {
											emailText: val,
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
								<h3 style={ separatorStyle }>Threema Share</h3>
								<Text
									variant="body.small"
									style={ descriptionStyle }
								>
									{ __(
										'Threema Share Text:',
										'planet4-gpch-blocks'
									) }
								</Text>
								<RichText
									value={ attributes.threemaShareText }
									placeholder={ __(
										'THREEMA SHARE TEXT',
										'planet4-gpch-blocks'
									) }
									allowedFormats={ [] }
									onChange={ ( val ) =>
										setAttributes( {
											threemaShareText: val,
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
