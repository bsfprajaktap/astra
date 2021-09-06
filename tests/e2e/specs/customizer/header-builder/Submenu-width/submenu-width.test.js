
import { createURL } from '@wordpress/e2e-test-utils';
import { setCustomize } from '../../../../utils/set-customize';

describe( 'Submenu width in the customizer', () => {
	it( 'Submenu width should apply corectly', async () => {
		const submenuWidth = {
			'submenu-width': {
				desktop: 240,
				tablet: 42,
				mobile: 32,
				'desktop-unit': 'px',
				'tablet-unit': 'px',
				'mobile-unit': 'px',
			},
		};

		await setCustomize( submenuWidth );

		await page.goto( createURL( '/' ), {
			waitUntil: 'networkidle0',
		} );

		await page.waitForSelector( '#ast-hf-menu-1 .menu-item-has-children ul' );

		await expect( {
			selector: '#ast-hf-menu-1 .menu-item-has-children ul',
			property: 'width',
		} ).cssValueToBe(
			`${ submenuWidth[ 'submenu-width' ].desktop }${ submenuWidth[ 'submenu-width' ][ 'desktop-unit' ] }`,
		);

		await page.goto( createURL( '/' ), {
			waitUntil: 'networkidle0',
		} );

	} );
} );
