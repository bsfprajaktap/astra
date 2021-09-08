import { createURL } from '@wordpress/e2e-test-utils';
import { setCustomize } from '../../../../utils/set-customize';
describe( 'Add Menu Hover Effect', () => {
	it( 'menu hover effect should be added properly', async () => {
		const menuHoverEffect = {
            'header-menu1-menu-hover-animation': 'all 0.3s linear 0s',
		};

		await setCustomize( menuHoverEffect );

		await page.goto( createURL( '/' ), {
			waitUntil: 'networkidle0',
		} );

        await expect( {
			selector: '.main-header-menu  a',
			property: 'transition',
		} ).cssValueToBe(
			`${ menuHoverEffect[ 'header-menu1-menu-hover-animation' ] }`,
		);
	} );
} );