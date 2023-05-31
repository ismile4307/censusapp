/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';


/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

// // register jw pagination component globally
// import JwPagination from 'jw-vue-pagination';
// app.component('jw-pagination', JwPagination);

// import VuePagination from 'laravel-vue-pagination';
// app.component('pagination', VuePagination);

// Vue.component('pagination', require('laravel-vue-pagination'));

// import ExampleComponent from './components/ExampleComponent.vue';

import SurveyDataComponent from './components/data_analysis/SurveyDataComponent.vue';
import FrequencyComponent from './components/data_analysis/FrequencyComponent.vue';
import CrossTableComponent from './components/data_analysis/CrossTableComponent.vue';
import AdvancedAnalysisComponent from './components/data_analysis/AdvancedAnalysisComponent.vue';
import DashboardComponent from './components/data_analysis/DashboardComponent.vue';
import SearchOperationComponent from './components/data_analysis/SearchOperationComponent.vue';

app.component('survey_data-component', SurveyDataComponent);
app.component('frequency-component', FrequencyComponent);
app.component('cross_table-component', CrossTableComponent);
app.component('advanced_analysis-component', AdvancedAnalysisComponent);
app.component('dashboard-component', DashboardComponent);
app.component('search_operation-component', SearchOperationComponent);


import SetupSurveyLinkComponent from './components/settings/SetupSurveyLinkComponent.vue';
import SurveyFiltersComponent from './components/settings/SurveyFiltersComponent.vue';
import FilterParameterComponent from './components/settings/FilterParameterComponent.vue';
import ShowingVariablesComponent from './components/settings/ShowingVariablesComponent.vue';

app.component('setup_survey_link-component', SetupSurveyLinkComponent);
app.component('survey_filters-component', SurveyFiltersComponent);
app.component('filter_parameter-component', FilterParameterComponent);
app.component('showing_variables-component', ShowingVariablesComponent);


import UserTypeComponent from './components/admin/UserTypeComponent.vue';
app.component('user_type-component', UserTypeComponent);
// Vue.component('user_type-component', require('./components/UserTypeComponent.vue').default);


import UserRoleComponent from './components/admin/UserRoleComponent.vue';
app.component('user_role-component', UserRoleComponent);
import SupportInfoComponent from './components/settings/SupportInfoComponent.vue';
app.component('support_info-component', SupportInfoComponent);
import ProjectUsersComponent from './components/settings/ProjectUsersComponent.vue';
app.component('project_users-component', ProjectUsersComponent);


// Project Teaf
import TeafDashboardComponent from './components/dashboard/Teaf/MotherTeafComponent.vue';
app.component('dashboard_teaf-component', TeafDashboardComponent);

import FirstComponent from './components/dashboard/Teaf/FirstComponent.vue';
import SecondComponent from './components/dashboard/Teaf/SecondComponent.vue';
import ThirdComponent from './components/dashboard/Teaf/ThirdComponent.vue';
import ForthComponent from './components/dashboard/Teaf/ForthComponent.vue';
import FifthComponent from './components/dashboard/Teaf/FifthComponent.vue';


app.component('first-component', FirstComponent);
app.component('second-component', SecondComponent);
app.component('third-component', ThirdComponent);
app.component('forth-component', ForthComponent);
app.component('fifth-component', FifthComponent);
// End of Projec teaf

// Project InfoC
import InfoCDashboardComponent from './components/dashboard/InfoC_Consumer/MotherInfoCComponent.vue';
app.component('dashboard_infoc-component', InfoCDashboardComponent);

import Child01Component from './components/dashboard/InfoC_Consumer/Child01Component.vue';
import Child02Component from './components/dashboard/InfoC_Consumer/Child02Component.vue';
import Child03Component from './components/dashboard/InfoC_Consumer/Child03Component.vue';
import Child04Component from './components/dashboard/InfoC_Consumer/Child04Component.vue';
import Child05Component from './components/dashboard/InfoC_Consumer/Child05Component.vue';
import Child06Component from './components/dashboard/InfoC_Consumer/Child06Component.vue';
import Child07Component from './components/dashboard/InfoC_Consumer/Child07Component.vue';
import Child08Component from './components/dashboard/InfoC_Consumer/Child08Component.vue';


app.component('child01-component', Child01Component);
app.component('child02-component', Child02Component);
app.component('child03-component', Child03Component);
app.component('child04-component', Child04Component);
app.component('child05-component', Child05Component);
app.component('child06-component', Child06Component);
app.component('child07-component', Child07Component);
app.component('child08-component', Child08Component);
// End of Projec teaf

//Respondent Panel Component link
import RespondentPanelComponen from './components/resp_panel/RespondentPanelComponent.vue';
import RespPanelColumnComponent from './components/resp_panel/RespPanelColumnComponent.vue';
app.component('respondentpanel-component', RespondentPanelComponen);
app.component('respcolumn-component', RespPanelColumnComponent);



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
