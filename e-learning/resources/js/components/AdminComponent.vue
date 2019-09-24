<template>
	<div class="container-fluid page-body-wrapper">
		<sidebar-component :role_id="role_id"></sidebar-component>
		<div class="main-panel">
	        <div class="content-wrapper">
	          <h2>Hello World</h2>
	        </div>
	        <footer-component></footer-component>
	    </div>
	</div>
</template>
<script>
export default {
	props:{
		role_id:0,
	},
    data(){
    	return{

    	}
    }
}
</script>