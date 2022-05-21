import {domReady} from '@roots/sage/client';

const addCallback = (arr, cb /* {callback: CallbableFunction, id = '' } */) => {
    arr.push(cb);
};

const removeCallback = (arr, callbackOrId) => {
    if (callbackOrId === null) {
        // clear all
        return [];
    }

    if (typeof callbackOrId === 'string') {
        const indexes = [];
        const cbs = [];
        arr.forEach((c) => {
            if (!(c.id && c.id === callbackOrId)) {
                cbs.push(c);
            }
        });

        return cbs;
    }

    // must be callback given
    const cbs = [];
    arr.forEach((cb) => {
        if (cb.callback !== callbackOrId) {
            cbs.push(cb);
        }
    });

    return cbs;
};

const dispatchCallbacks = (arr, ...xs) => {
    if (arr?.length) {
        arr.forEach((c) => {
            c.callback(...xs);
        });
    }
};

const slideUp = (target, duration = 500) => {
    target.style.transitionProperty = 'height, margin, padding';
    target.style.transitionDuration = duration + 'ms';
    const computed = getComputedStyle(target);
    if (computed.boxSizing === 'border-box') {
        target.style.height = target.offsetHeight + 'px';
    } else {
        const pt = parseFloat(computed.paddingTop);
        const pb = parseFloat(computed.paddingBottom);
        const bt = parseFloat(computed.borderTopWidth);
        const bb = parseFloat(computed.borderBottomWidth);
        target.style.height = target.offsetHeight - pt - pb - bt - bb + 'px';
    }
    target.offsetHeight;
    target.style.overflow = 'hidden';
    target.style.height = 0;

    window.setTimeout(() => {
        target.style.display = 'none';
        target.style.removeProperty('height');
        target.style.removeProperty('overflow');
        target.style.removeProperty('transition-duration');
        target.style.removeProperty('transition-property');
    }, duration);
};

/* SLIDE DOWN */
const slideDown = (target, duration = 500) => {
    target.style.removeProperty('display');
    let display = window.getComputedStyle(target).display;

    if (display === 'none') display = 'block';
    target.style.display = display;

    let height = target.offsetHeight;
    target.style.overflow = 'hidden';
    target.style.height = 0;

    target.offsetHeight;
    target.style.transitionProperty = 'height, margin, padding';
    target.style.transitionDuration = duration + 'ms';
    target.style.height = height + 'px';

    window.setTimeout(() => {
        target.style.removeProperty('height');
        target.style.removeProperty('overflow');
        target.style.removeProperty('transition-duration');
        target.style.removeProperty('transition-property');
    }, duration);
};

/* TOOGLE */
const slideToggle = (target, duration = 500) => {
    if (window.getComputedStyle(target).display === 'none') {
        return slideDown(target, duration);
    } else {
        return slideUp(target, duration);
    }
};

class ResizeService {
    service;

    lastWidth = null;
    tolerance = 5;
    callbacks = [
        /*
        {
            callback: CallableFunction
            id: string; 
        }
        */
    ];

    static name = 'resize';
    static dependencies = [];

    constructor() {
        this.getAndSetWidth();
        this.setWatcher();
    }

    init() {}

    getWidth() {
        return window.innerWidth;
    }
    getAndSetWidth() {
        this.lastWidth = this.getWidth();
    }

    setWatcher() {
        window.addEventListener('resize', () => {
            const w = this.getWidth();
            if (Math.abs(w - this.lastWidth) > this.tolerance) {
                this.lastWidth = w;
                this.dispatchWidth(w);
            }
        });
    }

    dispatchWidth(width) {
        dispatchCallbacks(this.callbacks, width);
    }

    on(callback, id = '') {
        addCallback(this.callbacks, {callback, id});
    }

    off(callbackOrId = null) {
        this.callbacks = removeCallback(callbackOrId);
    }
}

class BreakpointService {
    // service vars
    service;
    static name = 'breakpoint';
    static dependencies = [ResizeService.name];

    // class vars
    breakpoints = {
        sm: 640,
        md: 768,
        lg: 1024,
        xl: 1280,
        '2xl': 1536,
    };

    lastBreakpoint = null;

    keys = [];

    callbacks = [];

    init() {
        const rs = this.service.getService(ResizeService.name);

        this.keys = Object.keys(this.breakpoints);

        this.lastBreakpoint = this.getBreakpoint(rs.getWidth());

        rs.on((width) => {
            if (!this.callbacks.length) {
                return;
            }
            const cbp = this.getBreakpoint(width);

            if (cbp !== this.lastBreakpoint) {
                this.lastBreakpoint = cbp;
                this.dispatchBreakpoint(cbp);
            }
        }, 'breakpoint-service');
    }

    getBreakpoint(width) {
        for (let i = 0; i < this.keys.length; i++) {
            const key = this.keys[i];
            const bpw = this.breakpoints[key];

            if (width <= bpw) {
                return key;
                break;
            }
        }

        return this.keys.slice(-1)[0];
    }

    dispatchBreakpoint(bp) {
        dispatchCallbacks(this.callbacks, bp, this.breakpoints[bp]);
    }

    on(callback, id = '') {
        addCallback(this.callbacks, {callback, id});
    }

    off(callbackOrId = null) {
        this.callbacks = removeCallback(callbackOrId);
    }
}

class MenuService {
    service;
    static name = 'menu';
    static dependencies = [BreakpointService.name];

    isMobile = false;

    selectors = {
        parent: 'header.header',
        menu: '{parent} .menu',
        toggle: '{parent} .menu__toggle',
        toggleBtn: '{parent} .menu__toggle button',
        items: '{parent} .menu__items',
        itemsWrapper: '{parent} .menu__items-wrapper',
    };

    elements = {
        parent: null,
        menu: null,
        toggle: null,
        toggleBtn: null,
        items: null,
        itemsWrapper: null,
    };

    desktopBreakpoints = ['xl', '2xl'];

    init() {
        this.loadElements();

        const bp = this.service.getService(BreakpointService.name);

        this.checkMobileToggle(bp.getBreakpoint(window.innerWidth));

        bp.on((bp) => {
            this.checkMobileToggle(bp);
        }, 'menu-service');

        this.elements.toggleBtn.addEventListener('click', () =>
            slideToggle(this.elements.itemsWrapper, 350),
        );
    }

    prepareSelector(selector) {
        return selector.replace('{parent}', this.selectors.parent);
    }
    loadElements() {
        Object.entries(this.selectors).forEach(([name, rawSelector]) => {
            const selector = this.prepareSelector(rawSelector);

            this.elements[name] = document.querySelector(selector);
        });
    }

    checkMobileToggle(bp) {
        const isMobile = this.breakpointIsMobile(bp);
        if (isMobile !== this.isMobile) {
            this.isMobile = isMobile;
            if (isMobile) {
                this.goMobile();
            } else {
                this.goDesktop();
            }
        }
    }

    breakpointIsMobile(bp) {
        return !this.desktopBreakpoints.includes(bp);
    }

    goMobile() {
        this.elements.toggle.classList.remove('hidden');
        slideUp(this.elements.itemsWrapper, 50);
    }

    goDesktop() {
        this.elements.toggle.classList.add('hidden');

        const wrapper = this.elements.itemsWrapper;

        wrapper.style.removeProperty('hidden');
        wrapper.style.removeProperty('height');
        wrapper.style.display = 'block';
    }
}
class ServiceManager {
    static service = {
        resize: 'ResizeService',
        breakpoint: 'BreakpointService',
        menu: 'MenuService',
    };

    static services = {
        ResizeService,
        BreakpointService,
        MenuService,
    };

    autoInit = [
        // BreakpointService.name
    ];

    instances = {};

    constructor() {
        this.autoInit.forEach((serviceName) => {
            this.loadService(serviceName);
        });
    }

    loadService(serviceName) {
        const cls =
            ServiceManager.services[ServiceManager.service[serviceName]];
        if (!cls) {
            return console.warn('Unregistered service: ', servieName);
        }

        const deps = this.getClassDependencies(cls);

        if (deps.length) {
            deps.forEach((serviceName) => {
                this.getService(serviceName);
            });
        }

        return this.getService(serviceName);
    }

    getService(serviceName) {
        if (this.instances[serviceName]) {
            return this.instances[serviceName];
        }

        const cls =
            ServiceManager.services[ServiceManager.service[serviceName]];

        this.instances[serviceName] = new cls();
        this.instances[serviceName].service = this;
        this.instances[serviceName].init();

        return this.instances[serviceName];
    }

    getClassDependencies(cls) {
        const registeredMap = {
            [cls.name]: true,
        };
        const treeMap = {
            [cls.name]: {},
        };

        this.loadClassDependenciesRec(cls, registeredMap, treeMap[cls.name]);

        return this.treeMapToUniqueArray(treeMap);
    }

    loadClassDependenciesRec(
        cls,
        registeredMap,
        treeMap,
        parentService = null,
    ) {
        if (cls.dependencies) {
            cls.dependencies.forEach((serviceName) => {
                const scls =
                    ServiceManager.services[
                        ServiceManager.service[serviceName]
                    ];
                treeMap[serviceName] = {};

                if (
                    scls.dependencies?.length &&
                    !(
                        registeredMap[parentService] &&
                        registeredMap[serviceName]
                    )
                ) {
                    if (!registeredMap[serviceName]) {
                        registeredMap[serviceName] = true;
                    }

                    this.loadClassDependenciesRec(
                        scls,
                        registeredMap,
                        treeMap[serviceName],
                        cls.name,
                    );
                }
            });
        }
    }

    treeMapToUniqueArray(treeMap) {
        const allDeps = [];
        const parseObject = (obj) => {
            Object.entries(obj).forEach(([key, val]) => {
                allDeps.push(key);
                if (Object.keys(val).length > 0) {
                    parseObject(val);
                }
            });
        };

        parseObject(treeMap);

        allDeps.reverse();

        const uniqueHash = {};
        return allDeps.reduce((arr, d) => {
            if (!uniqueHash[d]) {
                uniqueHash[d] = true;
                arr.push(d);
            }

            return arr;
        }, []);
    }
}

const debounce = (callback, timeout) => {
    let timeoutHandle = null;
    const func = (...xs) => {
        clearTimeout(timeoutHandle);
        timeoutHandle = setTimeout(() => callback(...xs), timeout);
    };
    const cancel = () => clearTimeout(timeoutHandle);

    return [func, cancel];
};

const initStepHoverToggle = () => {
    const steps = document.querySelectorAll('.steps .step');

    const setActiveIndex = (index) => {
        steps.forEach((step, i) => {
            if (i === index) {
                step.classList.remove('border-t-neutral-200');
                step.classList.add('border-t-primary');
            } else {
                step.classList.add('border-t-neutral-200');
                step.classList.remove('border-t-primary');
            }
        });
    };

    const [startResetTimer, cancelResetTimer] = debounce(() => {
        setActiveIndex(0);
    }, 500);

    const [startShowTimer, cancelShowTimer] = debounce((index) => {
        setActiveIndex(index);
    }, 350);

    steps.forEach((step, i) => {
        step.addEventListener('mouseleave', (e) => {
            startResetTimer();
            cancelShowTimer();
        });
        step.addEventListener('mouseenter', (e) => {
            cancelResetTimer();
            startShowTimer(i);
        });
    });
};

/**
 * app.main
 */
const main = async (err) => {
    if (err) {
        // handle hmr errors
        console.error(err);
    }

    const services = new ServiceManager();

    window.services = services;

    // services.getService(MenuService.name);

    const observer = lozad('.lozad', {
        rootMargin: '10px 0px', // syntax similar to that of CSS Margin
        threshold: 0.1, // ratio of element convergence
        enableAutoReload: true, // it will reload the new image when validating attributes changes
    });
    observer.observe();

    const isHome = document.querySelector('body.home');
    if (isHome) {
        initStepHoverToggle();
    }

    // application code
};

/**
 * Initialize
 *
 * @see https://webpack.js.org/api/hot-module-replacement
 */
domReady(main);
import.meta.webpackHot?.accept(main);
