import {$, $$, addClass, attr, closest, css, hasClass, offset, removeClass} from 'uikit-util';

export const Header = {

    update: [

        {
            read() {
                return getSection() ? {height: this.$el.offsetHeight} : false;
            },

            write({height}) {

                const [section, modifier] = getSection();

                if (!hasClass(this.$el, 'tm-header-transparent')) {

                    addClass(this.$el, 'tm-header-transparent tm-header-overlay');
                    addClass($$('.tm-headerbar-top, .tm-headerbar-bottom, .tm-toolbar-transparent'), `uk-${modifier}`);
                    removeClass($('.tm-toolbar-transparent.tm-toolbar-default'), 'tm-toolbar-default');

                    if (!$('[uk-sticky]', this.$el)) {
                        addClass($('.uk-navbar-container', this.$el), `uk-navbar-transparent uk-${modifier}`);
                    }

                }

                css($('.tm-header-placeholder', section), {height});
            },

            events: ['resize']
        }

    ]

};

export const Sticky = {

    update: {

        read() {

            const [section, modifier] = getSection() || [];

            if (!modifier || !closest(this.$el, '[uk-header]')) {
                return;
            }

            this.animation = 'uk-animation-slide-top';
            this.clsInactive = `uk-navbar-transparent uk-${modifier}`;
            this.top = section.offsetHeight <= window.innerHeight
                ? offset(section).bottom
                : offset(section).top + 300;

        },

        events: ['resize']

    }

};

export const Navbar = {

    computed: {

        dropbarMode({dropbarMode}) {
            return getSection() || closest(this.$el, '[uk-sticky]') ? 'slide' : dropbarMode;
        }

    }

};

function getSection() {
    const section = $('.tm-header ~ [class*="uk-section"], .tm-header ~ :not(.tm-page) > [class*="uk-section"]');
    const modifier = attr(section, 'tm-header-transparent');
    return section && modifier && [section, modifier];
}
