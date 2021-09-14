import { createURL } from '@wordpress/e2e-test-utils';
import { setCustomize } from '../../../../utils/set-customize';
describe( 'Add Menu Hover Effect', () => {
	it( 'menu hover effect should be added properly', async () => {
		const menuHoverEffect = {
			'header-menu1-menu-hover-animation': 0,
		};

		await setCustomize( menuHoverEffect );

		await page.goto( createURL( '/' ), {
			waitUntil: 'networkidle0',
		} );

		await page.waitForSelector( '#ast-desktop-header #ast-hf-menu-1' );

		await expect( {
			selector: '.ast-menu-hover-style-underline > .menu-item > .menu-link:before',
			property: 'bottom',
		} ).cssValueToBe(
			`${ menuHoverEffect[ 'header-menu1-menu-hover-animation' ] }`,
		);
	} );
} );