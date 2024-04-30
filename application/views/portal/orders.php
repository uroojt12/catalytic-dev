<?php echo showMsg(); ?>
<?php echo getBredcrum(LOCATION, array('#' => 'Manage Orders')); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="fa fa-bar-chart-o"></i> Manage <strong>Orders</strong></h2>
    </div>
    <div class="col-md-6 text-right">

        <!-- <a href="" class="btn btn-lg btn-primary"><i class="fa fa-play"></i> Play All</a> -->
        <?php
        if ($this->uri->segment(3) == 'today_orders') {
        ?>
            <a href="javascript:void(0)" class="btn btn-lg btn-primary popBtn" data-popup="play-add" id="play_all"><i class="fa fa-play"></i> Play All</a>
        <?php
        }
        ?>
    </div>
</div>
<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <td>Order ID</td>
            <td>Order By</td>
            <td width="20%" class="text-center">Video</td>
            <td width="20%" class="text-center">Start Time</td>
        </tr>
    </thead>
    <tbody id="playList">
        <?php
        if ($this->uri->segment(3) != 'today_orders') {
            if (!empty($rows)) {
             
                foreach ($rows as $row) {
                    // pr($row['timeslots']);
                    foreach ($row['timeslots'] as $row_time_slot) { ?>
                    <tr>
                        <td><?= setOrderNo($row['ord_id']) ?></td>
                        <td><?= get_member_name($row['mem_id']) ?></td>
                        <td>
                            <video controls class="prop_video" id="video_tag" style="width:150px">
                                <source src="<?= get_site_image_src("videos", $row['video']) ?>" id="video_src">
                                Your browser does not support HTML5 video.
                            </video>
                        </td>
                        
                        <td>
                            <?php $time=date("g:i A", strtotime($row_time_slot['video_start_time'])); ?>
                            <?= $time; ?>
                            
                        </td>
                    </tr>
                <?php
                } }
            } else {
                ?>
                <tr>
                    <td colspan="4">No order for today date</td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>

<?php
if ($this->uri->segment(3) == 'today_orders') {
?>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>
    <script>
        // const socket = io('https://67.205.151.20:8080/');
        
        // socket.on('news', (data) => {
        //     console.log(data);
        //     socket.emit('my other event', {
        //         my: 'data'
        //     });
        // });


        var watchID;
        var geoLoc;

        // function showLocation(position) {
        //     // console.log("Video Data");
        //     // console.log(videoData);
        //     // console.log(position);
        //     var latitude = position.coords.latitude;
        //     var longitude = position.coords.longitude;
        //     // console.log("Latitude : " + latitude + " Longitude: " + longitude);
        //     // console.log("Operator ID : " + videoData.mem_id + " Orde ID: " + videoData.ord_id);
        //     let timestamp = Date.now();
        //     $("#location").append("<br>Latitude : " + latitude + " Longitude: " + longitude);
        //     var videoObj = {
        //         loc_id: videoData.mem_id,
        //         orderId: videoData.ord_id,
        //         lat: latitude,
        //         long: longitude,
        //         lastUpdated: timestamp
        //     };
        //     console.log(videoObj);
        //     socket.emit('update-location', {
        //         loc_id: videoData.mem_id,
        //         orderId: videoData.ord_id,
        //         lat: latitude,
        //         long: longitude,
        //         lastUpdated: timestamp
        //     });
        // }

        // function errorHandler(err) {
        //     console.log(err);
        //     if (err.code == 1) {
        //         alert("Error: Access is denied!");
        //     } else if (err.code == 2) {
        //         alert("Error: Position is unavailable!");
        //     }
        // }

        // function getLocationUpdate() {

        //     if (navigator.geolocation) {

        //         // timeout at 60000 milliseconds (60 seconds)
        //         var options = {
        //             timeout: 500
        //         };
        //         geoLoc = navigator.geolocation;
        //         watchID = geoLoc.watchPosition(showLocation, errorHandler, options);
        //     } else {
        //         alert("Sorry, browser does not support geolocation!");
        //     }
        // }
    </script>
    <script type="text/javascript">
        /*========== Popup ==========*/
        function loadVideos() {
            $.ajax({
                url: base_url + "locationoperator/Orders/get_todayorders",
                method: "get",
                async: true,
                dataType: 'json',
                error: function(er) {
                    console.log(er)
                },
                success: function(data) {
                    // console.log(data);    
                    $("#playList").html(data);
                }
            });
            return false;
        }
        loadVideos();
        $(document).on("click", "#play_all", function() {
            // alert('yes');
            $.ajax({
                url: base_url + "locationoperator/Orders/play_all_videos",
                method: "get",
                async: true,
                dataType: 'json',
                error: function(er) {
                    console.log(er)
                },
                success: function(data) {
                    // console.log("data",data);
                    // setInterval(playAll(data), 1000);
                    setInterval(
                        function() {
                            playAll(data);
                        },

                        1000);

                }
            });
            return false;
        });
        var selectVideo = function(now, vidTime) {
            // console.log("now", vidTime.getTime());
            if (vidTime.getTime() < now.getTime() && (vidTime.getTime() + (3600000)) > now.getTime()) {
                return true;
            }
            return false

        }
        // console.log("<?= $adminsite_setting->site_video ?>");
        var currentVideo = null;
        var defaultVideo = null;
        var videoData;

        function playAll(timeslots) {
            var videoPlayer = document.getElementById("adPlayer");
            timeslots.map(video => {
                // console.log('videooooo', video);
                let d = new Date();
                let dt = (("0" + (d.getMonth() + 1)).slice(-2)) + '/' + d.getDate() + '/' + d.getFullYear();
                let todayDate = dt + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();;

                let vid_st = dt + " " + video.t_start_time;
                // console.log(todayDate);
                // console.log("vid_st", selectVideo(new Date(todayDate), new Date(vid_st)));

                if (selectVideo(new Date(todayDate), new Date(vid_st))) {
                    // console.log('first if')
                    if (currentVideo != video.video) {

                        videoData = video;
                        saveVideoStartTime(video.mem_t_id, video.t_start_time);
                        // getLocationUpdate();
                        // console.log(video);
                        videoPlayer.style.display = "block";
                        videoPlayer.src = base_url + "uploads/videos/" + video.video;

                        currentVideo = video.video;
                        videoPlayer.play();
                        // console.log('Video is playing');
                    } else {
                        // console.log(currentVideo);
                    }
                    videoEnd(vid_st, todayDate, video.mem_t_id);
                } else if (selectVideo(new Date(todayDate), new Date(vid_st)) == false) {
                    // console.log(selectVideo(new Date(todayDate), new Date(vid_st)));
                    // console.log(video.t_start_time);
                    if (currentVideo != video.video) {
                        if (defaultVideo != '<?= $adminsite_setting->site_video ?>') {
                            // console.log("result is false");
                            videoPlayer.style.display = "block";
                            videoPlayer.src = base_url + "uploads/videos/" + "<?= $adminsite_setting->site_video ?>";

                            defaultVideo = '<?= $adminsite_setting->site_video ?>';
                            videoPlayer.play();
                        }

                    } else {
                        // console.log("currently playing small.mp4");
                    }
                } else {
                    // console.log("nothing here");
                }
            })
        }

        function saveVideoStartTime(mem_t_id, vid_st) {
            $.ajax({
                url: base_url + "locationoperator/Orders/updateVideoStartTime/",
                method: "post",
                data: {
                    mem_t_id: mem_t_id,
                    vid_st: vid_st
                },
                async: true,
                dataType: 'json',
                error: function(er) {
                    console.log(er)
                },
                success: function(data) {
                    console.log(data);
                }
            });
        }

        function videoEnd(vid_st, todayDate, mem_t_id) {
            var vidDate = new Date(vid_st);
            var curDate = new Date(todayDate);
            var myTime = "00:" + vid_st.substr(11, 2) + ":00";
            vidDate.setMinutes(vidDate.getMinutes() + 59);
            var end_time = vidDate.getMinutes() + 59;
            if (vidDate.getTime() == curDate.getTime()) {
                $.ajax({
                    url: base_url + "locationoperator/Orders/updateTimeslotStatus/",
                    method: "post",
                    data: {
                        mem_t_id: mem_t_id,
                        end_time: myTime
                    },
                    async: true,
                    dataType: 'json',
                    error: function(er) {
                        console.log(er)
                    },
                    success: function(data) {
                        console.log(data);
                    }
                });
            } else {

            }
        }

        var elem = "#adPlayer";
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27) { // ESC
                $(elem).css("display", "none");
            }
        });
    </script>
<?php
}
?>