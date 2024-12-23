import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { Tab,Datepicker,Ripple, Input, initTE, Alert, Validation, Select, Modal } from "tw-elements";
// import { initTWE,Tab,Datepicker,Ripple, Input, Alert, Validation, Select, Modal } from "tw-elements";
initTE({ Tab,Datepicker,Ripple, Input, Alert, Validation, Select, Modal });
// initTWE({ Tab,Datepicker,Ripple, Input, Alert, Validation, Select, Modal });
