<template>
	<div class="alert alert-danger" v-show="show">
			<li v-for="(value, key) in dataObject">{{ value[0] }}</li>
		</div>
</template>

<script>
	export default {
        props:['errorsobject'],
        data() {
            return {
                dataObject: '',
                show: false
            }
        },
        created() {
            if(!Array.isArray(this.errorsobject)) this.flash(this.errorsobject);
            window.events.$on(
                'errorFlash', errorsObject => this.flash(errorsObject)
        );
        },
        methods: {
            flash(errorsObject) {
            	if(!errorsObject) {this.show = false; return;}
                this.dataObject = errorsObject;
                this.show = true;
            }
        }
    };
</script>