<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
        body, html {width: 100%;height: 100%; margin:0;font-family:"微软雅黑";}
        #allmap{height:100%;width:100%;}
        #r-result,#r-result table{width:100%;}
    </style>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=99OO8mdE4xQFBsp6q5mGTk2sk5t474Dy"></script>

    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
    <title>根据起终点名称驾车导航</title>
    <script>

        //定义一些常量

        var x_PI = 3.14159265358979324 * 3000.0 / 180.0;
        var PI = 3.1415926535897932384626;
        var a = 6378245.0;
        var ee = 0.00669342162296594323;　　 //百度坐标系 (BD-09) 与 火星坐标系 (GCJ-02)的转换
        function bd09togcj02(bd_lon, bd_lat) {
            var x_pi = 3.14159265358979324 * 3000.0 / 180.0;
            var x = bd_lon - 0.0065;
            var y = bd_lat - 0.006;
            var z = Math.sqrt(x * x + y * y) - 0.00002 * Math.sin(y * x_pi);
            var theta = Math.atan2(y, x) - 0.000003 * Math.cos(x * x_pi);
            var gg_lng = z * Math.cos(theta);
            var gg_lat = z * Math.sin(theta);
            return [gg_lng, gg_lat]
        }
        //火星坐标系 (GCJ-02) 与百度坐标系 (BD-09) 的转换
        function gcj02tobd09(lng, lat) {
            var z = Math.sqrt(lng * lng + lat * lat) + 0.00002 * Math.sin(lat * x_PI);
            var theta = Math.atan2(lat, lng) + 0.000003 * Math.cos(lng * x_PI);
            var bd_lng = z * Math.cos(theta) + 0.0065;
            var bd_lat = z * Math.sin(theta) + 0.006;
            return [bd_lng, bd_lat];
        }
        //WGS84转GCj02
        function wgs84togcj02(lng, lat) {
            if(out_of_china(lng, lat)) {
                return [lng, lat]
            } else {
                var dlat = transformlat(lng - 105.0, lat - 35.0);
                var dlng = transformlng(lng - 105.0, lat - 35.0);
                var radlat = lat / 180.0 * PI;
                var magic = Math.sin(radlat);
                magic = 1 - ee * magic * magic;
                var sqrtmagic = Math.sqrt(magic);
                dlat = (dlat * 180.0) / ((a * (1 - ee)) / (magic * sqrtmagic) * PI);
                dlng = (dlng * 180.0) / (a / sqrtmagic * Math.cos(radlat) * PI);
                var mglat = lat + dlat;
                var mglng = lng + dlng;
                return [mglng, mglat]
            }
        }
        //GCJ02 转换为 WGS84
        function gcj02towgs84(lng, lat) {
            if(out_of_china(lng, lat)) {
                return [lng, lat]
            } else {
                var dlat = transformlat(lng - 105.0, lat - 35.0);
                var dlng = transformlng(lng - 105.0, lat - 35.0);
                var radlat = lat / 180.0 * PI;
                var magic = Math.sin(radlat);
                magic = 1 - ee * magic * magic;
                var sqrtmagic = Math.sqrt(magic);
                dlat = (dlat * 180.0) / ((a * (1 - ee)) / (magic * sqrtmagic) * PI);
                dlng = (dlng * 180.0) / (a / sqrtmagic * Math.cos(radlat) * PI);
                mglat = lat + dlat;
                mglng = lng + dlng;
                return [lng * 2 - mglng, lat * 2 - mglat]
            }
        }

        function transformlat(lng, lat) {
            var ret = -100.0 + 2.0 * lng + 3.0 * lat + 0.2 * lat * lat + 0.1 * lng * lat + 0.2 * Math.sqrt(Math.abs(lng));
            ret += (20.0 * Math.sin(6.0 * lng * PI) + 20.0 * Math.sin(2.0 * lng * PI)) * 2.0 / 3.0;
            ret += (20.0 * Math.sin(lat * PI) + 40.0 * Math.sin(lat / 3.0 * PI)) * 2.0 / 3.0;
            ret += (160.0 * Math.sin(lat / 12.0 * PI) + 320 * Math.sin(lat * PI / 30.0)) * 2.0 / 3.0;
            return ret;
        }

        function transformlng(lng, lat) {
            var ret = 300.0 + lng + 2.0 * lat + 0.1 * lng * lng + 0.1 * lng * lat + 0.1 * Math.sqrt(Math.abs(lng));
            ret += (20.0 * Math.sin(6.0 * lng * PI) + 20.0 * Math.sin(2.0 * lng * PI)) * 2.0 / 3.0;
            ret += (20.0 * Math.sin(lng * PI) + 40.0 * Math.sin(lng / 3.0 * PI)) * 2.0 / 3.0;
            ret += (150.0 * Math.sin(lng / 12.0 * PI) + 300.0 * Math.sin(lng / 30.0 * PI)) * 2.0 / 3.0;
            return ret;
        }
        // 判断是否在国内，不在国内则不做偏移
        function out_of_china(lng, lat) {
            return(lng < 72.004 || lng > 137.8347) || ((lat < 0.8293 || lat > 55.8271) || false);
        }

    </script>
</head>
<body>
<div id="allmap"></div>
<div id="r-result"></div>
</body>
</html>
<script type="text/javascript">
    // 百度地图API功能
    var map = new BMap.Map("allmap");
    var start = "伊尔克什坦口岸";
    var end = "吐尔尕特口岸";
    map.centerAndZoom(new BMap.Point(73.972833,39.71875), 19);
    //三种驾车策略：最少时间，最短距离，避开高速
    var routePolicy = [BMAP_DRIVING_POLICY_LEAST_TIME,BMAP_DRIVING_POLICY_LEAST_DISTANCE,BMAP_DRIVING_POLICY_AVOID_HIGHWAYS];

    //$("#result").click();
    //  $("#result").click(function(){
    map.clearOverlays();
    var i=$("#driving_way select").val();
    search(start,end,routePolicy[2]);
    var PERIOD_DIS=3;
    function search(start,end,route){
        var options = {
            renderOptions:{
                policy: route,
                map: map,
                //              panel: "r-result",
                enableDragging : true //起终点可进行拖拽,
            },
            onSearchComplete: function(results){
                var pointArr=results.Yr[0].ok[0].$r;
                var dis=0;
                var points=[];
                var temp=0;
                var str="";
                var bg=bd09togcj02(pointArr[0].lng,pointArr[0].lat);
                var gw=gcj02towgs84(bg[0],bg[1]);
                str+="["+gw[0]+","+gw[1]+"],\n";
//                   str+=pointArr[0].lat+","+pointArr[0].lng+";";
                var isEnd=false;
                for (var i = 1; i < pointArr.length; i++) {
                    var pointA=pointArr[i-1];
                    var pointB=pointArr[i]
                    dis+=map.getDistance(pointA,pointB);
                    var dd=dis/1000;
//                      console.log("dd--->"+dd);
                    if(dd%PERIOD_DIS<1){
                        var _temp=(dd-dd%PERIOD_DIS)/PERIOD_DIS;
                        if(_temp!=0&&temp!=_temp){
//                          console.log("temp---->"+temp+",_temp---->"+_temp)
                            temp=_temp;
//                          console.log("dis%5-->"+dd%PERIOD_DIS+",dis%5<=1---->"+(dd%PERIOD_DIS<1)+",dis--->"+dd);
                            points.push(pointB);
                            bg=bd09togcj02(pointB.lng,pointB.lat);
                            gw=gcj02towgs84(bg[0],bg[1]);
                            str+="["+gw[0]+","+gw[1]+"],\n";
//                           str+=pointB.lat+","+pointB.lng+";";
                            if(i==pointArr.length-1){
                                isEnd=true;
                            }
                        }
                    }

                }
                if(!isEnd){
                    bg=bd09togcj02(pointArr[pointArr.length-1].lng,pointArr[pointArr.length-1].lat);
                    gw=gcj02towgs84(bg[0],bg[1]);
                    str+="["+gw[0]+","+gw[1]+"],\n";
//                    str+=pointArr[pointArr.length-1].lat+","+pointArr[pointArr.length-1].lng+";";
                }

//                   console.log("dis--------->"+dis);
//                   console.log("len--->"+points.length)
                console.log("所有5公里倍数的点--->\n"+str)

                if (driving.getStatus() == BMAP_STATUS_SUCCESS){

                    var plan = results.getPlan(0);

                    var ddd=map.getDistance(results.getStart().point,results.getEnd().point)/1000

//                      console.log("result----->"+JSON.stringify(results))
                    // 获取第一条方案
                    var distance= plan.getDistance(true);
                    var dd=parseFloat(distance-1.2)%5;

//                      console.log("start--->"+JSON.stringify(results.getStart().point)+",distance--->"+distance);

//                      if(dd==0){
//                          alert("start--->"+JSON.stringify(results.getStart().point)+",distance--->"+distance);
//                      }

                    // 获取方案的驾车线路
                    var route = plan.getRoute(0);
                    // 获取每个关键步骤，并输出到页面
                    var s = [];

                    for (var i = 0; i < route.getNumSteps(); i ++){
                        var step = route.getStep(i);

                        s.push((i + 1) + ". " + step.getDescription());
                    }
                    var d=s.join("<br>");
//                      console.log("test--------->"+d );
                }    else{
                    console.log("test-----1---->" );
                }
            }
        };
        var driving = new BMap.DrivingRoute(map, options);

        console.log("test-------------------")
        driving.search(start,end);
    }


    //  });

</script>