
document.addEventListener('DOMContentLoaded', function() {

	var categorySubCategoryButton = document.getElementById('categorySubCategoryButton');

	if(categorySubCategoryButton) {
		var categorySubCategoryDiv = document.getElementById('categorySubCategoryDiv');
		var blockTria = document.getElementById('block-tria');
		// categorySubCategoryDiv.style.display = 'none';
		categorySubCategoryButton.addEventListener("click", function(){

			if(categorySubCategoryDiv.style.display == 'none'){
				categorySubCategoryDiv.style.display = 'block';
				blockTria.style.cssText = " border-bottom: 10px solid #616161; border-top:none; "
			}
			else{
				categorySubCategoryDiv.style.display = 'none';
				blockTria.style.cssText = " border-top: 10px solid #616161; border-bottom:none; "
			};
		})

	}


	var resetButton = document.getElementById('quick-reset');

	resetButton.addEventListener('click', function() {
		var quickBlock = document.getElementById('close-quick-thread');
		var inputs = quickBlock.querySelectorAll('input');

		for (var i = inputs.length - 1; i >= 0; i--) {
			inputs[i].value = '';
		}
	});

});

