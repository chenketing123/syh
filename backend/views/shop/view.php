<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>输入提示后查询</title>
    <link rel="stylesheet" href="https://cache.amap.com/lbs/static/main1119.css"/>
    <script src="https://webapi.amap.com/maps?v=2.0&key=9eb30b40d2f42e4280c050789cffa98c&plugin=AMap.Autocomplete"></script>
</head>
<body>
<div id="container"></div>
<div id="myPageTop">
    <table>
        <tr>
            <td>
                <label>请输入关键字：</label>
            </td>
        </tr>
        <tr>
            <td>
                <input id="tipinput"/>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    //地图加载
    var map = new AMap.Map("container", {
        resizeEnable: true
    });
    //输入提示
    var autoOptions = {
        input: "tipinput"
    };

    AMap.service(['AMap.PlaceSearch','AMap.AutoComplete'], function(){
        var auto = new AMap.AutoComplete(autoOptions);
        var placeSearch = new AMap.PlaceSearch({
            map: map
        });  //构造地点查询类
        auto.on("select", select);//注册监听，当选中某条记录时会触发
        function select(e) {
            placeSearch.setCity(e.poi.adcode);
            placeSearch.search(e.poi.name);  //关键字查询查询
        }
    });
</script>
</body>
</html>