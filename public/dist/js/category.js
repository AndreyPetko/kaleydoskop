document.addEventListener('DOMContentLoaded', function () {

    var categorySubCategoryButton = document.getElementById('categorySubCategoryButton');

    if (categorySubCategoryButton) {
        var categorySubCategoryDiv = document.getElementById('categorySubCategoryDiv');
        var blockTria = document.getElementById('block-tria');
        // categorySubCategoryDiv.style.display = 'none';
        categorySubCategoryButton.addEventListener("click", function () {

            if (categorySubCategoryDiv.style.display == 'none') {
                categorySubCategoryDiv.style.display = 'block';
                blockTria.style.cssText = " border-bottom: 10px solid #616161; border-top:none; "
            }
            else {
                categorySubCategoryDiv.style.display = 'none';
                blockTria.style.cssText = " border-top: 10px solid #616161; border-bottom:none; "
            }
        })

    }

    var resetButton = document.getElementById('quick-reset');

    if (resetButton) {
        resetButton.addEventListener('click', function () {
            var quickBlock = document.getElementById('close-quick-thread');
            var inputs = quickBlock.querySelectorAll('input');

            for (var i = inputs.length - 1; i >= 0; i--) {
                inputs[i].value = '';
            }
        });
    }

    var threadInputs = document.querySelectorAll('.thread-input');

    for(var i = 0; i < threadInputs.length; i++) {
        threadInputs[i].addEventListener('change', function() {
            if(this.value < 0) {
                this.value = 0;
            }
        })
    }

});

