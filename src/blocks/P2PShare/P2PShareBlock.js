import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { TextControl } from '@wordpress/components';
import {
	useBlockProps,
	RichText,
	InspectorControls,
	__experimentalLinkControl as LinkControl,
} from '@wordpress/block-editor';

/* global gpchBlocks */

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
					default: __(
						"I just signed this petition, it's a very important topic. Click here to sign it also: ",
						'planet4-gpch-blocks'
					),
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
					default: __(
						'Thank you for sharing on WhatsApp! Click this link, you will be able to edit the message before sending it: ',
						'planet4-gpch-blocks'
					),
				},
				smsMessage: {
					type: 'string',
					default: __(
						'Thank you for sharing by SMS! Please copy the following message and send it to your friends.',
						'planet4-gpch-blocks'
					),
				},
				signalMessage: {
					type: 'string',
					default: __(
						'Thank you for sharing on Signal! Please copy the following message and send it to your friends.',
						'planet4-gpch-blocks'
					),
				},
				emailText: {
					type: 'string',
					default: __(
						'Hi, I just signed this petition. Can I ask you to sign it too? CTA_LINK',
						'planet4-gpch-blocks'
					),
				},
				emailSubject: {
					type: 'string',
					default: __(
						'Help by also signing this petition!',
						'planet4-gpch-blocks'
					),
				},

				bg_color: { type: 'string', default: '#000000' },
				text_color: { type: 'string', default: '#ffffff' },
			},
			edit: ( { attributes, isSelected, setAttributes } ) => {
				const separatorStyle = {
					color: '#000',
					backgroundColor: '#dbebbe',
					margin: '1rem 0 .5rem 0',
					padding: '.2em .5em',
					fontSize: '1rem',
				};

				const editElementStyle = {
					margin: '.5rem 0 .5rem 0',
					padding: '0 .5rem',
				};

				const textboxStyle = {
					border: 'solid 1px #666',
					marginBottom: '.5em',
					margin: '.5rem',
					padding: '0 .5rem',
				};

				const descriptionStyle = {
					fontStyle: 'italic',
					margin: '1rem 0 .5rem 0',
					padding: '0 .5rem',
				};

				const blockProps = useBlockProps();

				return (
					<div { ...blockProps }>
						{ ! isSelected ? (
							<div className="wp-block-planet4-gpch-plugin-blocks-p2p-share">
								<form className="p2p-share-form">
									<fieldset className="p2p-share-step p2p-share-step-1">
										<legend>
											{ attributes.step1Title }
										</legend>
										<ul className="select">
											<li>
												<input
													id="n1"
													type="radio"
													name="number_of_people"
													value="1-5"
													className="autoforward"
													data-next-element=".p2p-share-step-2"
												/>
												<label htmlFor="n1">
													<img
														alt=""
														className="social-icon"
														src={ `${ gpchBlocks.pluginUrl }assets/img/icon/people-1.svg` }
													/>{ ' ' }
													1 - 5 People
												</label>
											</li>
											<li>
												<input
													id="n6"
													type="radio"
													name="number_of_people"
													value="6-10"
													className="autoforward"
													data-next-element=".p2p-share-step-2"
												/>
												<label htmlFor="n6">
													<img
														alt=""
														className="social-icon"
														src={ `${ gpchBlocks.pluginUrl }assets/img/icon/people-2.svg` }
													/>{ ' ' }
													6 - 10 People
												</label>
											</li>
											<li>
												<input
													id="n10"
													type="radio"
													name="number_of_people"
													value="10-20"
													className="autoforward"
													data-next-element=".p2p-share-step-2"
												/>
												<label htmlFor="n10">
													<img
														alt=""
														className="social-icon"
														src={ `${ gpchBlocks.pluginUrl }assets/img/icon/people-3.svg` }
													/>{ ' ' }
													10 - 20 People
												</label>
											</li>
											<li>
												<input
													id="n20"
													type="radio"
													name="number_of_people"
													value="20+"
													className="autoforward"
													data-next-element=".p2p-share-step-2"
												/>
												<label htmlFor="n20">
													<img
														alt=""
														className="social-icon"
														src={ `${ gpchBlocks.pluginUrl }assets/img/icon/people-3.svg` }
													/>
													<img
														alt=""
														className="social-icon"
														src={ `${ gpchBlocks.pluginUrl }assets/img/icon/people-3.svg` }
													/>{ ' ' }
													20+ People
												</label>
											</li>
										</ul>
										<div className="controls form-section wp-block-button">
											<button
												className="button next dark"
												data-next-step-field="number_of_people"
											>
												Next
											</button>
										</div>
									</fieldset>
								</form>
							</div>
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
											<p>
												<i>
													{ __(
														'utm_source will be added automatically depending on the channel.',
														'planet4-gpch-blocks'
													) }
												</i>
											</p>
										</fieldset>
									</div>
								</InspectorControls>

								<h3 style={ separatorStyle }>
									{ __( 'Step 1', 'planet4-gpch-blocks' ) }
								</h3>
								<RichText
									style={ editElementStyle }
									tagName={ 'h4' }
									value={ attributes.step1Title }
									allowedFormats={ [] }
									onChange={ ( val ) =>
										setAttributes( { step1Title: val } )
									}
								/>
								<h3 style={ separatorStyle }>
									{ __( 'Step 2', 'planet4-gpch-blocks' ) }
								</h3>
								<RichText
									style={ editElementStyle }
									tagName={ 'h4' }
									value={ attributes.step2Title }
									allowedFormats={ [] }
									onChange={ ( val ) =>
										setAttributes( { step2Title: val } )
									}
								/>
								<h3 style={ separatorStyle }>
									{ __(
										'Share text/links',
										'planet4-gpch-blocks'
									) }
								</h3>
								<p style={ descriptionStyle }>
									{ __(
										'Share text for all channels. The link will be shortened and added to the end of the text:',
										'planet4-gpch-blocks'
									) }
								</p>
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
								<p style={ descriptionStyle }>
									{ __(
										'Share link (unshortened and without UTM tags)',
										'planet4-gpch-blocks'
									) }
								</p>
								<LinkControl
									value={ attributes.shareLink }
									onChange={ ( val ) =>
										setAttributes( {
											shareLink: val,
										} )
									}
									settings={ [] }
									showSuggestions={ true }
									style={ editElementStyle }
								></LinkControl>

								<h3 style={ separatorStyle }>WhatsApp Share</h3>
								<p style={ descriptionStyle }>
									{ __(
										'WhatsApp SMS CTA (Link to WhatsApp will be added at the end):',
										'planet4-gpch-blocks'
									) }
								</p>
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
								<p style={ descriptionStyle }>
									{ __(
										'Email Subject:',
										'planet4-gpch-blocks'
									) }
								</p>
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
								<p style={ descriptionStyle }>
									{ __(
										'Email Text. Put CTA_LINK anywhere you would like to put a shortened link.',
										'planet4-gpch-blocks'
									) }
								</p>
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
								<p style={ descriptionStyle }>
									{ __(
										'First SMS, share CTA:',
										'planet4-gpch-blocks'
									) }
								</p>
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
								<p style={ descriptionStyle }>
									{ __(
										'A second SMS is sent with the share text and link.',
										'planet4-gpch-blocks'
									) }
								</p>
								<h3 style={ separatorStyle }>Signal Share</h3>
								<p style={ descriptionStyle }>
									{ __(
										'First SMS, share CTA:',
										'planet4-gpch-blocks'
									) }
								</p>
								<RichText
									value={ attributes.signalMessage }
									placeholder={ __(
										'FOR EXAMPLE: Thank you for sharing with your friends. Please copy/paste the following text into signal and send it to your friends.',
										'planet4-gpch-blocks'
									) }
									allowedFormats={ [] }
									onChange={ ( val ) =>
										setAttributes( {
											signalMessage: val,
										} )
									}
									style={ textboxStyle }
								/>
								<p style={ descriptionStyle }>
									{ __(
										'A second SMS is sent with the share text and link.',
										'planet4-gpch-blocks'
									) }
								</p>
								<h3 style={ separatorStyle }>Threema Share</h3>
								<p style={ descriptionStyle }>
									{ __(
										'No additional options.',
										'planet4-gpch-blocks'
									) }
								</p>
							</div>
						) }
					</div>
				);
			},
		} );
	}
}
