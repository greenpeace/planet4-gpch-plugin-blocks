import { Fragment } from '@wordpress/element'
import { registerBlockType } from '@wordpress/blocks'
import {
	InspectorControls,
	useBlockProps,
	RichText,
} from '@wordpress/block-editor'
import {
	TextControl,
	PanelBody,
} from '@wordpress/components'

const { __ } = wp.i18n

export class BSBingoBlock {
	constructor() {
		registerBlockType( 'planet4-gpch-plugin-blocks/bs-bingo', {
			apiVersion: 2,
			title: 'BS Bingo',
			icon: 'lightbulb',
			category: 'gpch',
			keywords: [
				__( this.blockName ),
				__( 'bullshit', 'planet4-gpch-blocks' ),
				__( 'bingo', 'planet4-gpch-blocks' ),
				__( 'buzzword', 'planet4-gpch-blocks' ),
			],
			attributes: {
				bsTerms: {
					type: 'array',
					default: [],
				},
				testTerms: {
					type: 'array',
					default: [],
				},
			},
			
			edit: ( props ) => {
				const { attributes: { bsTerms }, setAttributes, className } = props
				const blockProps = useBlockProps()
				
				const onChangeTerms = ( index, newTerm ) => {
					var newTerms = [...props.attributes.bsTerms]
					newTerms[ index ] = newTerm
					
					setAttributes( { bsTerms: newTerms } )
				}
				
				const blocks = []
				
				for( var i = 0; i < 25; i++ ) {
					let j = i
					
					blocks.push( <RichText
					  tagName="div"
					  className="box"
					  placeholder={'Term ' + i}
					  value={props.attributes.bsTerms[ i ]}
					  onChange={function( value ) {
						  onChangeTerms( j, value )
					  }}
					  keepPlaceholderOnFocus={true}
					  withoutInteractiveFormatting
					  characterLimit={40}
					  multiline="false"
					/> )
				}
				
				return (
				  <Fragment>
					  <div {...blockProps}>
						  <div class="grid">
							  {blocks}
						  </div>
					  </div>
				  </Fragment>
				)
			},
			
			save: ( props ) => {
				const blockProps = useBlockProps.save()
				
				const boxes = []
				for( var i = 0; i < 25; i++ ) {
					boxes.push( <div className="box off" data-index={i}><div class="box-content">{props.attributes.bsTerms[i]}</div></div>)
				}
				
				return (
				  <div {...blockProps}>
					  <canvas className="fireworks"></canvas>
					  <div class="grid">
						  {boxes}
					  </div>

					  <div className="wp-block-buttons">
						  <div className="wp-block-button"><a
						    className="wp-block-button__link bsbingo-reset">Reset</a>
						  </div>
					  </div>
				  </div>
				)
			},
		} )
	}
}