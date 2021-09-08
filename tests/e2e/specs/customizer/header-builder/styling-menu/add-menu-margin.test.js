import { createURL } from '@wordpress/e2e-test-utils';
import { setCustomize } from '../../../../utils/set-customize';
describe( 'Add menu spacing', () => {
	it( 'menu margin should be added properly', async () => {
		const menuMargin = {
            'section-hb-menu-1-margin': '10px',
		};

		await setCustomize( menuMargin );

		await page.goto( createURL( '/' ), {
			waitUntil: 'networkidle0',
		} );

		await page.waitForSelector( '#ast-desktop-header .main-navigation a' );

        await expect( {
			selector: '#ast-hf-menu-1',
			property: 'margin',
		} ).cssValueToBe(
			`${ menuMargin[ 'section-hb-menu-1-margin' ] }`,
		);

	} );
} );