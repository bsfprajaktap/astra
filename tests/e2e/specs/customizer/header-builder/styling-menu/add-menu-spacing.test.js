import { createURL } from '@wordpress/e2e-test-utils';
import { setCustomize } from '../../../../utils/set-customize';
describe( 'Add menu spacing', () => {
	it( 'menu spacing should be added properly', async () => {
		const menuSpacing = {
			'header-menu1-menu-spacing': '30px',
		};

		await setCustomize( menuSpacing );

		await page.goto( createURL( '/' ), {
			waitUntil: 'networkidle0',
		} );

		await page.waitForSelector( '#ast-desktop-header .main-navigation a' );

		await expect( {
			selector: '.menu-link',
			property: 'padding-left',
		} ).cssValueToBe(
			`${ menuSpacing[ 'header-menu1-menu-spacing' ] }`,
		);
	} );
} );