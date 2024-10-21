

$(function()
{
    load_data();
    function load_data()
    {
        $.ajax({
            url:"./handlers/courseallot/load_callot.php",
            method:"POST",
            data:{action:"getCourseAllotData"},
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
            url:"./handlers/courseallot/delete_callot.php",
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
