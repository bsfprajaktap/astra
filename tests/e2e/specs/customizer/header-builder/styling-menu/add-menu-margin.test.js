import { createURL } from '@wordpress/e2e-test-utils';
import { setCustomize } from '../../../../utils/set-customize';
describe( 'Add menu margin-left', () => {
	it( 'menu margin-left should be added properly', async () => {
		const menuMargin = {
            'section-hb-menu-1-margin': {
				desktop:'10px',
			}
		};

		await setCustomize( menuMargin );

		await page.goto( createURL( '/' ), {
			waitUntil: 'networkidle0',
		} );

		await page.waitForSelector( '#ast-desktop-header .main-navigation a' );

        await expect( {
			selector: '#ast-hf-menu-1',
			property: 'margin-left',
		} ).cssValueToBe(
			`${ menuMargin[ 'section-hb-menu-1-margin' ]}`,
		);

	} );
	
} );
describe( 'Add menu margin-right', () => {
	it( 'menu margin-right should be added properly', async () => {
		const menuMargin = {
            'section-hb-menu-1-margin': '20px',
		};

		await setCustomize( menuMargin );

		await page.goto( createURL( '/' ), {
			waitUntil: 'networkidle0',
		} );

		await page.waitForSelector( '#ast-desktop-header .main-navigation a' );

        await expect( {
			selector: '#ast-hf-menu-1',
			property: 'margin-right',
		} ).cssValueToBe(
			`${ menuMargin[ 'section-hb-menu-1-margin' ]}`,
		);

	} );
	
} );
describe( 'Add menu margin-top', () => {
	it( 'menu margin-right should be added properly', async () => {
		const menuMargin = {
            'section-hb-menu-1-margin': '15px',
		};

		await setCustomize( menuMargin );

		await page.goto( createURL( '/' ), {
			waitUntil: 'networkidle0',
		} );

		await page.waitForSelector( '#ast-desktop-header .main-navigation a' );

        await expect( {
			selector: '#ast-hf-menu-1',
			property: 'margin-top',
		} ).cssValueToBe(
			`${ menuMargin[ 'section-hb-menu-1-margin' ]}`,
		);

	} );
	
} );
describe( 'Add menu margin-bottom', () => {
	it( 'menu margin-bottom should be added properly', async () => {
		const menuMargin = {
            'section-hb-menu-1-margin': '25px',
		};

		await setCustomize( menuMargin );

		await page.goto( createURL( '/' ), {
			waitUntil: 'networkidle0',
		} );

		await page.waitForSelector( '#ast-desktop-header .main-navigation a' );

        await expect( {
			selector: '#ast-hf-menu-1',
			property: 'margin-bottom',
		} ).cssValueToBe(
			`${ menuMargin[ 'section-hb-menu-1-margin' ]}`,
		);


	} );
	
} );