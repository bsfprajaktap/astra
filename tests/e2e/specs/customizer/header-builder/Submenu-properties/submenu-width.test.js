import { createURL } from '@wordpress/e2e-test-utils';
import { setCustomize } from '../../../../utils/set-customize';

describe( 'Change submenu properties of primary menu', () => {
	it( 'submenu properties of primary menu should be changed', async () => {
		const submenuProperties = { 
			'header-menu1-submenu-border-radius': '5px',
			'header-menu1-submenu-width': {
				desktop: 250,
				tablet: 42,
				mobile: 32,
				'desktop-unit': 'px',
				'tablet-unit': 'px',
				'mobile-unit': 'px',
			}
		};

		await setCustomize( submenuProperties );

		await page.goto( createURL( '/' ), {
			waitUntil: 'networkidle0',
		} );

		await page.waitForSelector( '#ast-desktop-header .sub-menu' );

		await expect( {
			selector: '#ast-desktop-header .sub-menu',
			property: 'border-radius',
		} ).cssValueToBe(
			`${ submenuProperties[ 'header-menu1-submenu-border-radius' ]}`,
		);
		await expect( {
			selector: '#ast-desktop-header .sub-menu',
			property: 'width',
		} ).cssValueToBe(
			`${ submenuProperties[ 'header-menu1-submenu-width' ].desktop }${ submenuProperties[ 'header-menu1-submenu-width' ][ 'desktop-unit' ] }`,
		);
	} );
} );
	