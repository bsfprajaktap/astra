import { createURL } from '@wordpress/e2e-test-utils';
import { setCustomize } from '../../../../utils/set-customize';
describe( 'Menu Styling', () => {
	it( 'menu styling should be applied properly', async () => {
        const menuStyling = {
            'header-menu1-menu-hover-animation': 'zoom',
        };
        await setCustomize( menuStyling );
        await page.goto( createURL( '/' ), {
			waitUntil: 'networkidle0',
		} );
        await page.waitForSelector( '#ast-hf-menu-1 a' );
        await expect( {
			selector: '#ast-hf-menu-1 a',
			property: 'transform',
		} ).cssValueToBe(
			` ${ menuStyling[ 'header-menu1-menu-hover-animation' ]} `,
		);
    });
});