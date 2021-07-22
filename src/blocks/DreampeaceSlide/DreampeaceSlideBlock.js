import { registerBlockType } from '@wordpress/blocks';
import {
	useBlockProps,
	MediaUpload,
	MediaUploadCheck,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalLinkControl as LinkControl,
} from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { Button, TextControl } from '@wordpress/components';

export class DreampeaceSlideBlock {
	constructor() {
		registerBlockType( 'planet4-gpch-plugin-blocks/dreampeace-slide', {
			apiVersion: 2,
			title: 'Dreampeace Slide',
			icon: 'slides',
			category: 'gpch',
			attributes: {
				year: {
					type: 'string',
				},
				media: {
					type: 'object',
				},
				text: {
					type: 'string',
				},
				buttonText: {
					type: 'string',
				},
				link: {
					type: 'object',
				},
			},
			edit: ( { attributes, isSelected, setAttributes } ) => {
				const blockProps = useBlockProps();

				const removeMedia = () => {
					attributes.media = undefined;
				};

				const blockStyle = {
					backgroundColor: '#dbebbe',
					padding: '1rem',
				};

				const titleStyle = {
					marginTop: '0',
				};

				return (
					<div { ...blockProps }>
						{ ! isSelected ? (
							<div className="gpch-plugin-blocks-dreampeace-slide">
								<ServerSideRender
									block="planet4-gpch-plugin-blocks/dreampeace-slide"
									attributes={ attributes }
								/>
							</div>
						) : (
							<div style={ blockStyle }>
								<h3 style={ titleStyle }>Dreampeace Slide</h3>
								<TextControl
									label="Year"
									value={ attributes.year }
									onChange={ ( val ) =>
										setAttributes( { year: val } )
									}
								/>
								<label htmlFor="media">Image</label>
								<MediaUploadCheck>
									<MediaUpload
										onSelect={ ( val ) =>
											setAttributes( {
												media: val,
											} )
										}
										value={
											attributes.media !== undefined &&
											attributes.media.id
										}
										allowedTypes={ [ 'image' ] }
										render={ ( { open } ) => (
											<Button
												className={
													attributes.media ===
													undefined
														? 'editor-post-featured-image__toggle'
														: 'editor-post-featured-image__preview'
												}
												onClick={ open }
											>
												{ attributes.media ===
													undefined &&
													'Choose an image' }
												{ attributes.media !==
													undefined && (
													<img
														alt=""
														src={
															attributes.media
																.sizes.medium
																.url
														}
													/>
												) }
											</Button>
										) }
									/>
								</MediaUploadCheck>
								{ attributes.media !== undefined && (
									<MediaUploadCheck>
										<MediaUpload
											title="Replace image"
											value={ attributes.media.id }
											onSelect={ ( val ) =>
												setAttributes( {
													media: val,
												} )
											}
											allowedTypes={ [ 'image' ] }
											render={ ( { open } ) => (
												<Button
													onClick={ open }
													isDefault
													isLarge
												>
													Replace image
												</Button>
											) }
										/>
									</MediaUploadCheck>
								) }
								{ attributes.media !== undefined && (
									<MediaUploadCheck>
										<Button
											onClick={ removeMedia }
											isLink
											isDestructive
										>
											Remove image
										</Button>
									</MediaUploadCheck>
								) }
								<TextControl
									label="Text"
									value={ attributes.text }
									onChange={ ( val ) =>
										setAttributes( { text: val } )
									}
								/>
								<TextControl
									label="Button Text"
									value={ attributes.buttonText }
									onChange={ ( val ) =>
										setAttributes( {
											buttonText: val,
										} )
									}
								/>
								<label htmlFor="link">Button Link</label>
								<LinkControl
									value={ attributes.link }
									onChange={ ( val ) =>
										setAttributes( {
											link: val,
										} )
									}
									settings={ [] }
									showSuggestions={ true }
								></LinkControl>
							</div>
						) }
					</div>
				);
			},
		} );
	}
}
