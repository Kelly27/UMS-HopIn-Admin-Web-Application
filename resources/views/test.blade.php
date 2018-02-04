<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>

</body>
<script>
    $.ajax({
    url: "http://localhost:8000/api/login",
    dataType: "json",
    type: "POST",
    data: {"email":admin@umshopin.com","password":"123456"},
    success: function (data) {
        alert(data.result)
    }
    // 这里我们用ajax请求测试，当然你也可以用Angular.js  Vue.js
});
</script>
</html>