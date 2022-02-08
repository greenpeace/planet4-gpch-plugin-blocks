import { Fragment } from '@wordpress/element';
import { registerBlockType } from '@wordpress/blocks';
import { RichText, useBlockProps } from '@wordpress/block-editor';

const { __ } = wp.i18n;

export class BSBingoBlock {
	constructor() {
		registerBlockType('planet4-gpch-plugin-blocks/bs-bingo', {
			apiVersion: 2,
			title: 'BS Bingo',
			icon: 'lightbulb',
			category: 'gpch',
			keywords: [
				__('bullshit', 'planet4-gpch-plugin-blocks'),
				__('bingo', 'planet4-gpch-plugin-blocks'),
				__('buzzword', 'planet4-gpch-plugin-blocks'),
			],
			attributes: {
				bsTerms: {
					type: 'array',
					default: [],
				},
			},

			edit: (props) => {
				const {
					attributes: {},
					setAttributes,
				} = props;
				const blockProps = useBlockProps(); // eslint-disable-line react-hooks/rules-of-hooks

				const onChangeTerms = (index, newTerm) => {
					const newTerms = [...props.attributes.bsTerms];
					newTerms[index] = newTerm;

					setAttributes({ bsTerms: newTerms });
				};

				const blocks = [];

				for (let i = 0; i < 25; i++) {
					const j = i;

					blocks.push(
						<RichText
							tagName="div"
							className="box"
							value={props.attributes.bsTerms[i]}
							onChange={function (value) {
								onChangeTerms(j, value);
							}}
							keepPlaceholderOnFocus={true}
							withoutInteractiveFormatting
							characterLimit={40}
							multiline="false"
						/>
					);
				}

				return (
					<Fragment>
						<div {...blockProps}>
							<div className="grid">{blocks}</div>
						</div>
					</Fragment>
				);
			},

			save: (props) => {
				const blockProps = useBlockProps.save();

				const boxes = [];
				for (let i = 0; i < 25; i++) {
					boxes.push(
						<div className="box off" data-index={i}>
							<div className="box-content">{props.attributes.bsTerms[i]}</div>
						</div>
					);
				}

				return (
					<div {...blockProps}>
						<canvas className="fireworks"></canvas>
						<div className="grid">{boxes}</div>

						<div className="controls">
							<div className="wp-block-buttons">
								<div className="wp-block-button is-style-default">
									<button className="wp-block-button__link bsbingo-reset">Reset</button>
								</div>
							</div>

							<div className="bingo-score">
								Score:&nbsp;
								<span className="number" id="bs-bingo-score">
									0
								</span>
							</div>
						</div>
					</div>
				);
			},
		});
	}
}
