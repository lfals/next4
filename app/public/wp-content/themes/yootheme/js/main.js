import UIkit from 'uikit';
import {Header, Navbar, Sticky} from './header';
import {isRtl, ready, swap} from 'uikit-util';

UIkit.component('header', Header);
UIkit.mixin(Sticky, 'sticky');
UIkit.mixin(Navbar, 'navbar');

if (isRtl) {

    const mixin = {

        created() {
            this.$props.pos = swap(this.$props.pos, 'left', 'right');
        }

    };

    UIkit.mixin(mixin, 'drop');
    UIkit.mixin(mixin, 'tooltip');
}

ready(() => {

    const {$load = [], $theme = {}} = window;

    function load(stack, config) {
        stack.length && stack.shift()(
            config, () => load(stack, config)
        );
    }

    load($load, $theme);
});
