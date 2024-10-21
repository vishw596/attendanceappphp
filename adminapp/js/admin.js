

$(function()
{
    load_data();
    function load_data()
    {
        $.ajax({
            url:"./handlers/load_st.php",
            method:"POST",
            data:{action:"getStudentData"},
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
});
