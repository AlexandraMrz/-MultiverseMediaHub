$(document).ready(function(){
    $(document).ready(function(){
        $("#addCatBtn").click(function(){
            $("#addCatForm").slideToggle();
        });
    });

    $(".editCatBtn").click(function(e){
        e.preventDefault(); 
        var categoryId = $(this).data('id');
        var categoryName = $(this).data('name');
        $("#edit_category_id").val(categoryId);
        $("#edit_category_name").val(categoryName);
        $("#editCategoryModal").modal('show');
    });

    $("#editCategoryForm").submit(function(e){
        e.preventDefault();
        var categoryId = $("#edit_category_id").val();
        var categoryName = $("#edit_category_name").val();
        $.post("editCategory.php", { category_id: categoryId, category_name: categoryName }, function(data){
           
            $("#category_name_" + categoryId).text(categoryName);
            $("#editCategoryModal").modal('hide'); 
            location.reload();
        });
    });
});
