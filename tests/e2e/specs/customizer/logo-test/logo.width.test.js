/* eslint-disable linebreak-style */
import { visitAdminPage } from '@wordpress/e2e-test-utils';
import { setCustomize } from '../../../utils/set-customize';
describe( 'Site logo and margin settings in the customizer', () => {
	it( 'logo width & margin should apply corectly', async () => {
		const siteLogo = {
			'components-input-control__input css-1nqs3qz-Input e1cr7zh12': 164,
			desktop: 22,
			tablet: 20,
			mobile: 18,
			'desktop-unit': 'px',
			'tablet-unit': 'px',
			'mobile-unit': 'px',
		};
		//await setCustomize(siteLogo);
		await visitAdminPage('customize.php');
		
	
	} );
} );
