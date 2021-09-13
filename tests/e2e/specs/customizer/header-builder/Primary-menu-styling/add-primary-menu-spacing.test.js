import { createURL } from '@wordpress/e2e-test-utils';
import { setCustomize } from '../../../../utils/set-customize';
describe( 'Add menu spacing left', () => {
	it( 'menu spacing should be added properly on left', async () => {
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
describe( 'Add menu spacing right', () => {
	it( 'menu spacing should be added properly on right', async () => {
		const menuSpacing = {
			'header-menu1-menu-spacing': '10px',
		};

		await setCustomize( menuSpacing );

		await page.goto( createURL( '/' ), {
			waitUntil: 'networkidle0',
		} );

		await page.waitForSelector( '#ast-desktop-header .main-navigation a' );

		await expect( {
			selector: '.menu-link',
			property: 'padding-right',
		} ).cssValueToBe(
			`${ menuSpacing[ 'header-menu1-menu-spacing' ] }`,
		);
	} );
} );
describe( 'Add menu spacing top', () => {
	it( 'menu spacing should be added properly on top', async () => {
		const menuSpacing = {
			'header-menu1-menu-spacing': '40px',
		};

		await setCustomize( menuSpacing );

		await page.goto( createURL( '/' ), {
			waitUntil: 'networkidle0',
		} );

		await page.waitForSelector( '#ast-desktop-header .main-navigation a' );

		await expect( {
			selector: '.menu-link',
			property: 'padding-top',
		} ).cssValueToBe(
			`${ menuSpacing[ 'header-menu1-menu-spacing' ] }`,
		);
	} );
} );
describe( 'Add menu spacing bottom', () => {
	it( 'menu spacing should be added properly on bottom', async () => {
		const menuSpacing = {
			'header-menu1-menu-spacing': '50px',
		};

		await setCustomize( menuSpacing );

		await page.goto( createURL( '/' ), {
			waitUntil: 'networkidle0',
		} );

		await page.waitForSelector( '#ast-desktop-header .main-navigation a' );

		await expect( {
			selector: '.menu-link',
			property: 'padding-bottom',
		} ).cssValueToBe(
			`${ menuSpacing[ 'header-menu1-menu-spacing' ] }`,
		);
	} );
} );