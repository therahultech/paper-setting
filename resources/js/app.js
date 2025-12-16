import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;

/**
 * IMPORTANT:
 * Do NOT use @alpinejs/collapse with tw-elements
 * It causes promise crashes
 */
Alpine.start();

/**
 * tw-elements (Bootstrap-based UI)
 */
import {
    Tab,
    Datepicker,
    Ripple,
    Input,
    initTE,
    Alert,
    Validation,
    Select,
    Modal
} from "tw-elements";

initTE({
    Tab,
    Datepicker,
    Ripple,
    Input,
    Alert,
    Validation,
    Select,
    Modal
});
