import { Fragment } from '@wordpress/element';
import { registerBlockType } from '@wordpress/blocks';
import { RichText, useBlockProps } from '@wordpress/block-editor';

const { __ } = wp.i18n;

export class P2PShareBlock {
	constructor() {
		registerBlockType( 'planet4-gpch-plugin-blocks/p2p-share', {
			apiVersion: 2,
			title: 'P2P Share',
			icon: 'share',
			category: 'gpch',
			keywords: [
				__( 'P2P', 'planet4-gpch-blocks' ),
				__( 'Share', 'planet4-gpch-blocks' ),
			],
			attributes: {
				content: {
					type: 'array',
					source: 'children',
					selector: 'p',
				},
			},
			example: {
				attributes: {
					content: 'Hello World',
				},
			},
			edit: ( props ) => {
				const { attributes: { content }, setAttributes, className } = props;
				const blockProps = useBlockProps();
				const onChangeContent = ( newContent ) => {
					setAttributes( { content: newContent } );
				};
				return (
					<RichText
						{ ...blockProps }
						tagName="p"
						onChange={ onChangeContent }
						value={ content }
					/>
				);
			},
			save: ( props ) => {
				const blockProps = useBlockProps.save();
				return <RichText.Content { ...blockProps } tagName="p" value={ props.attributes.content } />;
			},
		} );
	}
}
