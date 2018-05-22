
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
require('bootstrap-tagsinput');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
 window.events = new Vue();

window.flash = function (message) {
    window.events.$emit('flash', message);
};
window.errorFlash = function (errorsObject) {
    window.events.$emit('errorFlash', errorsObject);
};

window.Delete = function(element) {
		$(element).addClass('is-loading');
		var id = $(element).parent().siblings().first().text();
		var target = getPrefix(location.pathname)+'/'+id;
		axios.delete(target).then((response) => {
			flash(response.data);
			$(element).parents('tr').fadeOut(300);
		});
};
function getPrefix(str) {
	var segments = str.split('/');
	segments[segments.length - 1] = pluralize.singular(segments[segments.length - 1]);
	return segments.join('/');
}

window.getFormData = function() {
    var data = {};
    $("input, textarea, select").filter(function() {
    	if(this.type != 'radio') return true;
    	if(this.checked) return true;
    }).map(function () { 
    	data[$(this).attr('name')] = $(this).val(); 
    });
    data['keywords'] = $('#keywords').tagsinput('items');
    data['emails'] = $('#emails').tagsinput('items');
    data['telephones'] = window.telephones;
    return data;
}
window.save = function(el) {
	$(el).addClass('is-loading');
	var data = getFormData();
	var action = location.pathname.replace('/edit','');
	axios.patch(action,data).then(response => {
		errorFlash('');
		$(el).removeClass('is-loading');
		flash(response.data);
	}).catch(error => {
		$(el).removeClass('is-loading');
		errorFlash(error.response.data.errors);
	});
};

$('form').attr('action',location.pathname);

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('error-flash', require('./components/errorFlash.vue'));
const app = new Vue({
    el: '#app'
});
