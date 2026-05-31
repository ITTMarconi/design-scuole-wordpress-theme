<?php
// TODO: add support for external video types. For now, only local video is supported.
//
$visualizza_highlights = dsi_get_option("visualizza_highlights", "homepage");
if ($visualizza_highlights == "si") {
    $highlights_group = dsi_get_option("highlights_group", "homepage");
    ?>
    <div class="highlights_group wrapper position-relative">
        <div class="d-flex justify-content-center flex-column variable-gutters mb-3">
            <?php
            foreach ($highlights_group as $highlight) {
                // TODO: change this comparison to a switch statement
                if ($highlight["video_type"] == "local") {
                    ?>
                    <div class='hightlight-video'>
                        <video controls="" style="width:100%;" poster="<?php echo $highlight["video_cover"] ?>">
                            <source src="<?php echo $highlight["video_local"] ?>" type="video/mp4">
                        </video>
                    </div>
                    <?php
                } else {
                    switch ($highlight["video_type"]) {
                        case "youtube":
                            $video_url = "https://www.youtube.com/embed/" . $highlight["video_embed"];
                            break;
                        case "facebook":
                            $video_url = "https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2F" . $highlight["video_id"] . "%2F&show_text=0&width=560";
                            break;
                        default:
                            $video_url = "";
                    }
                    ?>
                    <div class='hightlight-video'>
                        <?php // TODO: add html to show videos ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div><!-- /container -->

    <?php
}
