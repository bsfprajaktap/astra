import{ createURL } from '@wordpress/e2e-test-utils';
import { setCustomize } from '../../../utils/set-customize';
describe( 'breadcrumb Typography settings in the customizer', () => {
    it( 'breadcrumb typography should apply corectly', async () =>
       {
        const aftbreadcrumbFont = {
            'breadcrumb-position' : 'astra_header_after',
            'breadcrumb-font-family': 'Raleway, sans-serif',
            'breadcrumb-font-weight': '800',
            'breadcrumb-text-transform': 'uppercase',
            'breadcrumb-font-size': {
                desktop: 72,
                tablet: '42',
                mobile: '32',
                'desktop-unit': 'px',
                'tablet-unit': 'px',
                'mobile-unit': 'px',
            },
            'breadcrumb-line-height': 0.99,
            'breadcrumb-active-color-responsive': {
                desktop: 'rgb(255, 77, 0)',
                tablet: 'rgb(0, 11, 255)',
                mobile: 'rgb(7, 140, 0)',
            },
        };

        await setCustomize( aftbreadcrumbFont );
        await page.goto( createURL( '/' ), {
        waitUntil: 'networkidle0',
        } );

        await page.waitForSelector( '.ast-breadcrumbs .trail-browse, .ast-breadcrumbs .trail-items, .ast-breadcrumbs .trail-items li' );

        await expect( {
            selector: '.ast-breadcrumbs-wrapper, .ast-breadcrumbs-wrapper a',
            property: 'font-size',
        } ).cssValueToBe(
           `${ aftbreadcrumbFont[ 'breadcrumb-font-size' ].desktop }${ aftbreadcrumbFont[ 'breadcrumb-font-size' ][ 'desktop-unit' ] }`,
        );

        await expect( {
            selector: '.ast-breadcrumbs-wrapper, .ast-breadcrumbs-wrapper a',
            property: 'font-weight',
        } ).cssValueToBe(
           `${ aftbreadcrumbFont[ 'breadcrumb-font-weight' ] }`,
        );

        await expect( {
            selector: '.ast-breadcrumbs-wrapper',
            property: 'line-height',
        } ).cssValueToBe(
           `${ aftbreadcrumbFont[ 'breadcrumb-line-height' ] }`,
        );

        await expect( {
            selector: '.ast-breadcrumbs-wrapper, .ast-breadcrumbs-wrapper a',
            property: 'text-transform',
        } ).cssValueToBe(
           `${ aftbreadcrumbFont[ 'breadcrumb-text-transform' ] }`,
        );

        await expect( {
            selector: '.ast-breadcrumbs-wrapper, .ast-breadcrumbs-wrapper a',
            property: 'font-family',
        } ).cssValueToBe( 
           `${ aftbreadcrumbFont[ 'breadcrumb-font-family' ] }` );

        await expect( {
            selector: '.ast-breadcrumbs-wrapper .trail-items .trail-end',
            property: 'color',
        } ).cssValueToBe( `${ aftbreadcrumbFont[ 'breadcrumb-active-color-responsive' ].desktop }` );
    } );
} );