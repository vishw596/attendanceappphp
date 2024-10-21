

$(function()
{
    load_data();
    function load_data()
    {
        $.ajax({
            url:"./handlers/coursereg/load_creg.php",
            method:"POST",
            data:{action:"getCourseRegData"},
            success:function(data)
            {
                $(".result").html(data);
            },
            error:function(xhr,status,error)
            {
                alert("Something Went wrong");
            }
        });
    }
    $(document).on("click",".delete",function(){
        let id = $(this).attr('id');
        $.ajax({
            url:"./handlers/coursereg/delete_creg.php",
            method:"POST",
            data:{id:id},
            success:function(res){
                load_data();
            },
            error:function()
            {
                alert("something went wrong");
            }
        })
    })
});
